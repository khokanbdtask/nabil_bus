<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once './vendor/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

class Paypal extends CI_Controller
{
    private $active_theme = null;

    public function __construct()
    {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->load->library('paypal_lib');
        $this->load->model(array(
            'price/price_model',
            'Website/website_model',
            'tax/tax_model'
        ));

        $this->active_theme = $this->website_model->get_active_themes();

    }

    public function buy($booking_id_no = null)
    {
        if (empty($booking_id_no)) {
            redirect('website/paypal/cancel');
        } else {
            //get particular product data
            $this->load->model(array('website_model'));
            $ticket = $this->website_model->getBooking($booking_id_no);

            // print_r($ticket);exit;
            $appSetting = $this->website_model->read_setting();

            $seat = (!empty($ticket->quantity) ? $ticket->quantity : 1);

            $price = (!empty($ticket->price) ? $ticket->price : 0);
            $price = $price / $seat;

            $discount = number_format((!empty($ticket->discount) ? $ticket->discount : 0), 2);
            $item_name = "Ticket :: $appSetting->title";
            // ---------------------
            //Set variables for paypal form
            $returnURL = base_url("website/paypal/success/$ticket->booking_id_no/$ticket->tkt_passenger_id_no"); //payment success url
            $cancelURL = base_url("website/paypal/cancel/$ticket->booking_id_no/$ticket->tkt_passenger_id_no"); //payment cancel url
            $notifyURL = base_url('website/paypal/ipn'); //ipn url

            //set session token
            $this->session->unset_userdata('_tran_token');
            $this->session->set_userdata(array('_tran_token' => $booking_id_no));
            // set form auto fill data
            $this->paypal_lib->add_field('return', $returnURL);
            $this->paypal_lib->add_field('cancel_return', $cancelURL);
            $this->paypal_lib->add_field('notify_url', $notifyURL);

            // item information
            $this->paypal_lib->add_field('item_number', $booking_id_no);
            $this->paypal_lib->add_field('item_name', $item_name);
            $this->paypal_lib->add_field('amount', $price);
            $this->paypal_lib->add_field('quantity', $seat);
            $this->paypal_lib->add_field('discount_amount', $discount);

            // additional information 
            $this->paypal_lib->add_field('custom', $ticket->tkt_passenger_id_no);
            $this->paypal_lib->image(base_url($appSetting->logo));
            // generates auto form
            $this->paypal_lib->paypal_auto_form();
        }
    }


    public function success($booking_id_no = null, $passenger_id_no = null)
    {


        $data['title'] = display('ticket');
        #--------------------------------------
        //get the transaction data
        $paypalInfo = $this->input->get();

        //session token
        $token = $this->session->userdata('_tran_token');
        if ($token != $paypalInfo['item_number']) {
            redirect('website/paypal/cancel');
        }

        $data['item_number'] = $paypalInfo['item_number'];
        $data['txn_id'] = $paypalInfo["tx"];
        $data['payment_amt'] = $paypalInfo["amt"];
        $data['currency_code'] = $paypalInfo["cc"];
        $data['status'] = $paypalInfo["st"];
        $passinfo = $this->db->select('*')->from('tkt_passenger')->where('id_no', $passenger_id_no)->get()->row();

        $email = $passinfo->email;
        $this->load->library('pdfgenerator');
        $id = $booking_id_no;
        $name = $passinfo->firstname . ' ' . $passinfo->lastname;
        $datas['appSetting'] = $this->website_model->read_setting();
        $data['languageList'] = $this->languageList();
        $datas['ticket'] = $this->website_model->getTicket($id);
        $datas['item_number'] = $paypalInfo['item_number'];
        $datas['txn_id'] = $paypalInfo["tx"];
        $datas['payment_amt'] = $paypalInfo["amt"];
        $datas['currency_code'] = $paypalInfo["cc"];
        $datas['status'] = $paypalInfo["st"];
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
        $data['ticket'] = $this->website_model->getTicket($paypalInfo['item_number']);

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


    /*
    * Add this ipn url to your paypal account
    * Profile and Settings > My selling tools > 
    * Instant Payment Notification (IPN) > update 
    * Notification URL: (eg:- http://domain.com/website/paypal/ipn/)
    * Receive IPN messages (Enabled) 
    */

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


    // Booking locally

    public function test_input($data)
    {

        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }


    //Send Customer Email with invoice

    public function cancel($booking_id_no = null, $passenger_id_no = null)
    {
        #---------------Clean Database------------
        // delete booking
        if (!empty($booking_id_no)) {
            $this->db->where('id_no', $booking_id_no)->delete('ws_booking_history');
        }
        // delete user
        if (!empty($passenger_id_no)) {
            $this->db->where('id_no', $passenger_id_no)->delete('tkt_passenger');
        }
        #----------------------------------------

        $data['title'] = display('ticket');
        $this->load->model('website_model');
        $data['appSetting'] = $this->website_model->read_setting();
        $data['module'] = "website";
        $data['page'] = "pages/cancel";
        $this->load->view('layout', $data);
    }

    //Email testing for email

    public function ipn()
    {
        //paypal return transaction details array
        $paypalInfo = $this->input->post();

        $data['user_id'] = $paypalInfo['custom'];
        $data['product_id'] = $paypalInfo["item_number"];
        $data['txn_id'] = $paypalInfo["txn_id"];
        $data['payment_gross'] = $paypalInfo["mc_gross"];
        $data['currency_code'] = $paypalInfo["mc_currency"];
        $data['payer_email'] = $paypalInfo["payer_email"];
        $data['payment_status'] = $paypalInfo["payment_status"];

        $paypalURL = $this->paypal_lib->paypal_url;
        $result = $this->paypal_lib->curlPost($paypalURL, $paypalInfo);

        //check whether the payment is verified
        if (preg_match("/VERIFIED/i", $result)) {
            //insert the transaction data into the database
            $this->load->model('paypal_model');
            $this->paypal_model->insertTransaction($data);
        }
    }


    //local payment success

    public function paymentlocal($booking_id_no = null)
    {
        if (isset($_POST['booking_id_no'])) {
            $booking_id_no = $_POST['booking_id_no'];
        }

        //get particular product data
        //$this->load->model(array('website_model'));

        $ticket = $this->website_model->getlocal($booking_id_no);

       $tax_modules = array();

        $tax_module = $this->tax_model->active_tax();

        $taxids = ",";

        foreach ($tax_module as $tax_ids) {
            $taxids .= $tax_ids['id'].","; 
        }

        $tax_modules = explode(',', $tax_module[0]['apply_tax_module']);

        $total_tax_rate = 0;

        if($tax_modules[0]==1)
        {
            $total_tax_rate = $this->tax_model->total_tax_rate();
        }


        // echo "<pre>";
        //     // echo $booking_id_no."<br>";
        //     print_r($ticket);
        //     print_r($tax_module);
        //     echo $total_tax_rate;
        // exit();

        if(empty($ticket->email))
        {
            $email = $_POST['email'];
        }
        else
        {
            $email = $ticket->email;
        }
        

        $data = array(
            'pickup_trip_location' => $ticket->pickup_trip_location,
            'drop_trip_location' => $ticket->drop_trip_location,
            'tkt_passenger_id_no' => $ticket->tkt_passenger_id_no,
            'trip_id_no' => $ticket->trip_id_no,
            'id_no' => $ticket->id_no,
            'booking_date' => $ticket->booking_date,
            'trip_route_id' => $ticket->trip_route_id,
            'request_facilities' => $ticket->request_facilities,
            'price' => $ticket->price,
            'amount' => ((($ticket->price*$total_tax_rate)/100)+$ticket->price),
            'total_seat' => $ticket->total_seat,
            'discount' => $ticket->discount,
            'seat_numbers' => $ticket->seat_numbers,
            'agent_id' => $ticket->agent_id,
            'booking_date' => $ticket->booking_date,
            'date' => $ticket->date,
            'payment_status' => 2,
            'adult' => $ticket->adult,
            'child' => $ticket->child,
            'special' => $ticket->special,
            'booking_type' => "Cash(".$email.")", 
            'total_tax' => $total_tax_rate,
            'taxids' => $taxids
        );
        $email = $ticket->email;
        $name = $ticket->passenger_name;
        $this->load->library('pdfgenerator');
        $id = $ticket->id_no;
        $datas['appSetting'] = $this->website_model->read_setting();

        $pickup_id = $ticket->pickup_trip_location;
        $drop_id = $ticket->drop_trip_location;
        $datas['pickup'] = $this->website_model->location_name($pickup_id)->name;
        $datas['drop'] = $this->website_model->location_name($drop_id)->name;


        $html = $this->load->view($this->active_theme . '/pages/localticket_pdf', $datas, true);
        $dompdf = new Dompdf();
        $dompdf->load_html($html);
        $dompdf->render();
        $output = $dompdf->output();
        file_put_contents('assets/data/pdf/' . $id . '.pdf', $output);
        $file_path = 'assets/data/pdf/' . $id . '.pdf';
        $send_email = '';
        $this->db->where('id_no', $booking_id_no)->delete('tkt_booking');

        // echo "<pre>"; 
        // print_r($ticket); 
        // print_r($tax_module);
        //     echo $taxids."<br>";
        //     echo $total_tax_rate."<br>";
        // print_r($data);
        
        // die();

    /////// Ticket Booking Add
        
        $insertdata = $this->db->insert('tkt_booking', $data);

        $datas['ticket'] = $this->website_model->getTicket($id);

        // $this->load->view($this->active_theme . '/pages/localticket_pdf', $datas);
        $datas['languageList'] = $this->languageList();
        $datas['module'] = "website";
        $datas['page'] = $this->active_theme . '/pages/localticket_pdf';

        $datas['disclaimers'] = $this->db->select('disclaimer_details')->from('disclaimer')->where('status',0)->limit(1)->get()->row();


        

        $this->load->view($this->active_theme . "/layout", $datas);

        //// IF EMAIL MAKES PROBLEM, SKIP IT

        goto b;

        if ($insertdata) {
            if (!empty($email)) {
                $send_email = $this->setmail($email, $file_path, $id, $name);
                // redirect("website/Paypal/local_success/". $id);
                echo '<script>window.location.href = "' . base_url() . 'website/Paypal/local_success/' . $id . '"</script>';
            } else {
                echo 'Email NOt SEND';
                //                     echo '<script>window.location.href = "'.base_url().'website/Paypal/local_success/'. $id.'"</script>';
            }
        }


        b:


    }

    // Booking Ticket and Payed by bank

    public function local_success($booking_id_no = null)
    {

        $currency_details = $this->price_model->retrieve_setting_editdata();
        foreach ($currency_details as $price) {
        }
        $currency = $price['currency'];
        $data['title'] = display('ticket');
        #--------------------------------------
        //get the transaction data
        //pass the transaction data to view
        $this->load->model('website_model');
        $data['appSetting'] = $this->website_model->read_setting();
        $data['languageList'] = $this->languageList();
        $data['ticket'] = $this->website_model->getTicket($booking_id_no);
        $data['bank_commission'] = $this->db->select('*')->from('ws_setting')->get()->row();
        $rokute_id = $data['ticket']->trip_route_id;
        $data['pricess'] = $this->db->select('*')->from('pri_price')->where('route_id', $rokute_id)->get()->row();
        $data['currency'] = $currency;
        $data['module'] = "website";
        $data['page'] = $this->active_theme . "/pages/localticket";

       // echo "<pre>";
       // print_r($data);
       // die();

        $this->load->view($this->active_theme . '/layout', $data);
    }



    public function bank_info($booking_id_no = null)
    {

        $comission = $this->db->select('*')->from('ws_setting')->get()->row();

        $ticket = $this->website_model->getlocal($booking_id_no);

        $price_withcommission = ($ticket->price * $comission->bank_commission) / 100;
        $data = array(
            'pickup_trip_location' => $ticket->pickup_trip_location,
            'drop_trip_location' => $ticket->drop_trip_location,
            'tkt_passenger_id_no' => $ticket->tkt_passenger_id_no,
            'trip_id_no' => $ticket->trip_id_no,
            'id_no' => $ticket->id_no,
            'booking_date' => $ticket->booking_date,
            'trip_route_id' => $ticket->trip_route_id,
            'request_facilities' => $ticket->request_facilities,
            'price' => $price_withcommission + $ticket->price,
            'total_seat' => $ticket->total_seat,
            'discount' => $ticket->discount,
            'seat_numbers' => $ticket->seat_numbers,
            'agent_id' => ($ticket->agent_id)?$ticket->agent_id:'',
            'booking_date' => $ticket->booking_date,
            'date' => $ticket->date,
            'payment_status' => 1,
            'adult' => $ticket->adult,
            'child' => $ticket->child,
            'special' => $ticket->special,
            'booking_type' => 'Bank'
        );
        $email = $ticket->email;
        $name = $ticket->passenger_name;



        $this->load->library('pdfgenerator');

        $id = $ticket->id_no;


        $datas['appSetting'] = $this->website_model->read_setting();

        $datas['ticket'] = $this->website_model->getTicket($id);

        $datas['commission'] = $this->db->select('*')->from('ws_setting')->get()->row();
        $html = $this->load->view('pages/bank_ticket_pdf', $datas, true);

        $dompdf = new DOMPDF();
        $dompdf->load_html($html);
        $dompdf->render();

        $output = $dompdf->output();

        file_put_contents('assets/data/pdf/' . $id . '.pdf', $output);

        $file_path = 'assets/data/pdf/' . $id . '.pdf';

        $send_email = '';

        $this->db->where('id_no', $booking_id_no)->delete('tkt_booking');

        $insertdata = $this->db->insert('tkt_booking', $data);

        if($insertdata)
        {
            
            $data['status'] = true;

            $data['pickup'] = $this->website_model->location_by_id($ticket->pickup_trip_location);
            $data['drop'] = $this->website_model->location_by_id($ticket->drop_trip_location);

            $currency_details = $this->price_model->retrieve_setting_editdata();
        foreach ($currency_details as $price) {
        }
        $currency = $price['currency'];
        $data['title'] = display('ticket');
        #--------------------------------------
        //get the transaction data
        //pass the transaction data to view
        $this->load->model('website_model');
        $data['appSetting'] = $this->website_model->read_setting();
        $data['languageList'] = $this->languageList();
        $data['ticket'] = $this->website_model->getTicket($booking_id_no);
        $data['bank_commission'] = $this->db->select('*')->from('ws_setting')->get()->row();
        $rokute_id = $data['ticket']->trip_route_id;
        $data['pricess'] = $this->db->select('*')->from('pri_price')->where('route_id', $rokute_id)->get()->row();
        $data['currency'] = $currency;
        $data['module'] = "website";
        $data['page'] = $this->active_theme . "/pages/localticket";

       // echo "<pre>";
       // // print_r($ticket);

       // print_r($data);
       // die();

        $this->load->view($this->active_theme . '/layout', $data);
        }        

// echo json_encode($data);
///////////////////////////////////////////////////////////////////////
        //// IF MAIL SENDING CREATES PROBLEM , SKIP IT ////
///////////////////////////////////////////////////////////////////////


goto skip_pdf_mail;

        if ($insertdata) {
            if (!empty($email)) {
                $send_email = $this->setmail($email, $file_path, $id, $name);
                // redirect("website/Paypal/local_success/". $id);
                echo '<script>window.location.href = "' . base_url() . 'website/Paypal/local_success/' . $id . '"</script>';
            } else {
                echo 'Email NOt SEND';
            }
        }

skip_pdf_mail:

///////////////////////////////////////////////////////////////////////
        //// IF MAIL SENDING CREATES PROBLEM , SKIP IT ////
///////////////////////////////////////////////////////////////////////


    }
}