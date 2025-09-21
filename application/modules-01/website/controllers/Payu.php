<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Payu extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array(
            'price/price_model',
            'Website/website_model'
        ));
    }


    public function payucheck($booking_id = null)
    {
        $setting_info = $this->db->select('*')->from('ws_setting')->get()->row();

        $amount = $this->input->post('amount');
        $product_info = $this->input->post('ticketinfo');
        $customer_name = $this->input->post('firstname');
        $customer_emial = $this->input->post('email');
        $customer_mobile = $this->input->post('mobile');
        $customer_address = $this->input->post('address');
        $passenger_id = $this->input->post('passenger_id_no');

        //payumoney details

        $MERCHANT_KEY = $setting_info->merchantkey; //change  merchant with yours
        $SALT = $setting_info->salt;  //change salt with yours

        $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
        //optional udf values
        $udf1 = '';
        $udf2 = '';
        $udf3 = '';
        $udf4 = '';
        $udf5 = '';

        $hashstring = $MERCHANT_KEY . '|' . $txnid . '|' . $amount . '|' . $product_info . '|' . $customer_name . '|' . $customer_emial . '|' . $udf1 . '|' . $udf2 . '|' . $udf3 . '|' . $udf4 . '|' . $udf5 . '||||||' . $SALT;
        $hash = strtolower(hash('sha512', $hashstring));
        $this->session->unset_userdata('_tran_token');
        $this->session->set_userdata(array('_tran_token' => $booking_id));
        $success = base_url("website/payu/success/$booking_id/$passenger_id");
        $fail = base_url("website/payu/transaction_fail");
        $cancel = base_url("website/payu/cancel");


        $data = array(
            'mkey' => $MERCHANT_KEY,
            'tid' => $txnid,
            'hash' => $hash,
            'amount' => $amount,
            'name' => $customer_name,
            'productinfo' => $product_info,
            'mailid' => $customer_emial,
            'phoneno' => $customer_mobile,
            'address' => $customer_address,
            'action' => $setting_info->payu_url, //for live change
            'sucess' => $success,
            'failure' => $fail,
            'cancel' => $cancel
        );

        $data['module'] = "website";
        $data['page'] = "pages/payupayment_checkout";
        echo Modules::run('template/layout', $data);


    }

    public function success($booking_id_no = null, $passenger_id_no = null)
    {


        $data['title'] = display('ticket');
        #--------------------------------------
        //get the transaction data

        $passinfo = $this->db->select('*')->from('tkt_passenger')->where('id_no', $passenger_id_no)->get()->row();

        $email = $passinfo->email;
        $this->load->library('pdfgenerator');
        $id = $booking_id_no;
        $name = $passinfo->firstname . ' ' . $passinfo->lastname;
        $datas['appSetting'] = $this->website_model->read_setting();
        $data['languageList'] = $this->languageList();
        $datas['ticket'] = $this->website_model->getTicket($id);
        $html = $this->load->view('pages/ticket_pdf', $datas, true);
        $dompdf = new DOMPDF();
        $dompdf->load_html($html);
        $dompdf->render();
        $output = $dompdf->output();
        file_put_contents('assets/data/pdf/' . $id . '.pdf', $output);
        $file_path = 'assets/data/pdf/' . $id . '.pdf';
        $send_email = '';

///////////////////////////////////////////////////////////////////////
        //// IF MAIL SENDING CREATES PROBLEM , SKIP IT ////
///////////////////////////////////////////////////////////////////////


goto skip_pdf_mail;

        if (!empty($email)) {
            $send_email = $this->setmail($email, $file_path, $id, $name);
        }

skip_pdf_mail:

///////////////////////////////////////////////////////////////////////
        //// IF MAIL SENDING CREATES PROBLEM , SKIP IT ////
///////////////////////////////////////////////////////////////////////

        //pass the transaction data to view 
        $this->load->model('website_model');
        $data['appSetting'] = $this->website_model->read_setting();
        $data['ticket'] = $this->website_model->getTicket($booking_id_no);

        $data['module'] = "website";
        $data['page'] = "pages/ticket";
        $this->load->view('layout', $data);
    }

    public function languageList()
    {
        if ($this->db->table_exists("language")) {

            $fields = $this->db->field_data("language");

            $i = 1;
            $result[] = 'Select Language';
            foreach ($fields as $field) {
                if ($i++ > 2)
                    $result[$field->name] = ucfirst($field->name);
            }

            if (!empty($result)) return $result;


        } else {
            return false;
        }
    }

    public function setmail($email, $file_path, $id = null, $name = null)
    {

        $setting_detail = $this->db->select('*')->from('email_config')->get()->row();

        $subject = 'ticket Information';

        $message = display('email_gritting') . ' ' . $name . display('email_ticket_idinfo') . '-' . $id;

        $config = array(
            'protocol' => $setting_detail->protocol,
            'smtp_host' => $setting_detail->smtp_host,
            'smtp_port' => $setting_detail->smtp_port,
            'smtp_user' => $setting_detail->smtp_user,
            'smtp_pass' => $setting_detail->smtp_pass,
            'mailtype' => $setting_detail->mailtype,
            'charset' => 'utf-8'
        );


        // $this->load->library('email', $config);
        $this->email->initialize($config);
        $this->email->set_newline("\r\n");
        $this->email->from($setting_detail->smtp_user);
        $this->email->to($email);
        $this->email->subject($subject);
        $this->email->message($message);
        $this->email->attach($file_path);

        $check_email = $this->test_input($email);

        if (filter_var($check_email, FILTER_VALIDATE_EMAIL)) {

            if ($this->email->send()) {
                $this->session->set_flashdata(array('message' => display('email_send_to_passenger')));
                return true;
            } else {
                $this->session->set_flashdata(array('exception' => display('Please configure your mail.')));
                return false;
            }

        } else {
            $this->session->set_userdata(array('message' => display('successfully_added')));
            redirect("website/Paypal/local_success/" . $id);
        }
    }

    public function test_input($data)
    {

        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    //Send Customer Email with invoice

    public function transaction_fail()
    {
        $data['title'] = display('ticket');
        #--------------------------------------
        $data['appSetting'] = $this->website_model->read_setting();
        $data['module'] = "website";
        $data['page'] = "pages/fail";
        $this->load->view('layout', $data);
    }

    //Email testing for email

    public function cancel()
    {

        $data['title'] = display('ticket');
        #--------------------------------------
        $data['appSetting'] = $this->website_model->read_setting();
        $data['module'] = "website";
        $data['page'] = "pages/cancel";
        $this->load->view('layout', $data);

    }

}
