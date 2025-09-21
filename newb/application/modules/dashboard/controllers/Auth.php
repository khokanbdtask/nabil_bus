<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends MX_Controller
{
private $active_theme = null;
    public function __construct()
    {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->load->model(array(
            'auth_model',
            'website/user_model',
            'website/website_model'
        ));
        $this->active_theme = $this->website_model->get_active_themes();

        $this->load->helper('captcha');
    }

    public function index()
    {
        if ($this->session->userdata('isLogIn'))
            redirect('dashboard/home');
        $data['title'] = display('login');

        #-------------------------------------#
        $this->form_validation->set_rules('email', display('email'), 'required|valid_email|max_length[100]|trim');
        $this->form_validation->set_rules('password', display('password'), 'required|max_length[32]|md5|trim');
        $this->form_validation->set_rules(
            'captcha', display('captcha'),
            array(
                'matches[captcha]',
                function ($captcha) {

// _______________________________________________________________________________________
// After Catch the Captcha Texts, split them into charecters and sum the numbers only.    |
// Then we will just match the sum value.                                                 |
// _______________________________________________________________________________________|

                    $oldCaptcha = $this->session->userdata('captcha');

                    // $elements = str_split($oldCaptcha);
                    // $elements = explode('+', $oldCaptcha);

                    $pattern = "/[+\s=\s?]/";
                    $elements = preg_split($pattern, $oldCaptcha);

                   

                    $sum = 0;

                    foreach ($elements as $numbers) {
                        if (is_numeric($numbers)) {
                            $sum += $numbers;
                        }
                    }

                    // echo $sum;

                    // print_r($elements);

                    // die();

                    if ($captcha == $sum) {
                        return true;
                    }


//___________________________________________________________________________________________

                }
            )
        );

        #-------------------------------------#
        $data['user'] = (object)$userData = array(
            'email' => $this->input->post('email'),
            'password' => $this->input->post('password'),
        );
        #-------------------------------------#
        if ($this->form_validation->run()) {

            $this->session->unset_userdata('captcha');

            $user = $this->auth_model->checkUser($userData);

            if ($user->num_rows() > 0) {

                $checkPermission = $this->auth_model->userPermission2($user->row()->id);
                if ($checkPermission != NULL) {
                    $permission = array();
                    $permission1 = array();
                    if (!empty($checkPermission)) {
                        foreach ($checkPermission as $value) {
                            $permission[$value->module] = array(
                                'create' => $value->create,
                                'read' => $value->read,
                                'update' => $value->update,
                                'delete' => $value->delete
                            );

                            $permission1[$value->menu_title] = array(
                                'create' => $value->create,
                                'read' => $value->read,
                                'update' => $value->update,
                                'delete' => $value->delete
                            );
                            //print_r($checkPermission);exit;
                        }
                    }
                }


                if ($user->row()->is_admin == 2) {
                    $row = $this->db->select('client_id,client_email')->where('client_email', $user->row()->email)->get('setup_client_tbl')->row();
                }

                $sData = array(
                    'isLogIn' => true,
                    'isAdmin' => (($user->row()->is_admin == 1) ? true : false),
                    'user_type' => $user->row()->is_admin,
                    'id' => $user->row()->id,
                    'client_id' => @$row->client_id,
                    'fullname' => $user->row()->fullname,
                    'user_level' => $user->row()->user_level,
                    'email' => $user->row()->email,
                    'image' => $user->row()->image,
                    'last_login' => $user->row()->last_login,
                    'last_logout' => $user->row()->last_logout,
                    'ip_address' => $user->row()->ip_address,
                    'permission' => json_encode(@$permission),
                    'label_permission' => json_encode(@$permission1)
                );

                //store date to session
                $this->session->set_userdata($sData);
                //update database status
                $this->auth_model->last_login();
                //welcome message
                $this->session->set_flashdata('message', display('welcome_back') . ' ' . $user->row()->fullname);
                redirect('dashboard/home');

            } else {
                $this->session->set_flashdata('exception', display('incorrect_email_or_password'));
                redirect('login');
            }

        } else {

            $captcha = create_captcha(array(
                'img_path' => './assets/img/captcha/',
                'img_url' => base_url('assets/img/captcha/'),
                'font_path' => './assets/fonts/captcha.ttf',
                'img_width' => '330',
                'img_height' => 64,
                'expiration' => 600, //5 min
                'word_length' => 2,
                'font_size' => 20,
                'img_id' => 'Imageid',
                'pool' => '0123456789',

                // White background and border, black text and red grid
                'colors' => array(
                    'background' => array(255, 255, 255),
                    'border' => array(234, 229, 231),
                    'text' => array(49, 141, 1),
                    'grid' => array(200, 220, 220)
                )
            ));
            $data['captcha_word'] = $captcha['word'];
            $data['captcha_image'] = $captcha['image'];
            $this->session->set_userdata('captcha', $captcha['word']);

            echo Modules::run('template/login', $data);
        }
    }

    public function logout()
    {
        //update database status
        $this->auth_model->last_logout();
        //destroy session
        $this->session->sess_destroy();
        redirect('login');
    }

// passenger login info
    public function user_info()
    {
//        echo "<pre>";
//        print_r($this->session);
//        die();

        if ($this->session->userdata('isLogIn') == 1 || $this->session->userdata('is_passenger') == 1)
        {
            $id_no = $this->session->userdata('id_no');
            if(count($this->auth_model->passenger_check($id_no)) > 0)
            {
                redirect("website/user/user_details/".$id_no);
            }
            else
            {
                redirect('website/website/index');
            }
        }


        $this->form_validation->set_rules('email', display('email'), 'required|valid_email|max_length[100]|trim');
        $this->form_validation->set_rules('password', display('password'), 'required|max_length[32]|md5|trim');
        $data['user'] = (object)$userData = array(
            'email' => $this->input->post('email'),
            'password' => $this->input->post('password'),
        );
        if ($this->form_validation->run()) {
            $user = $this->user_model->checkUser($userData);
            if ($user->num_rows() > 0) {
                $sData = array(
                    'id' => $user->row()->id,
                    'id_no' => $user->row()->id_no,
                    'firstname' => $user->row()->firstname,
                    'lastname' => $user->row()->lastname,
                    'p_email' => $user->row()->email,
                    'image' => $user->row()->image,
                    'p_password' => $user->row()->password,
                    'phone' => $user->row()->phone,
                    'address' => $user->row()->address_line_1,
                    'is_passenger' => 1
                );

                //store date to session
                $this->session->set_userdata($sData);
                //update database status
                $this->session->set_flashdata('message', display('welcome_back') . ' ' . $user->row()->firstname . ' ' . $user->row()->lastname);
                redirect("website/User/user_details/");
            } else {
                $this->session->set_flashdata('exception', display('incorrect_email_or_password'));
                redirect('userlog');
            }
        } else {
            $data['title'] = display('login');
            $this->load->view("website/".$this->active_theme."/user/login_form");
        }

    }

    public function user_log()
    {
        $data['title'] = display('login');
        $this->load->view("website/".$this->active_theme."/user/login_form");
    }

    public function pass_logout()
    {
        $this->session->sess_destroy();
        redirect('website');
    }


    public function password_recovery()
    {
        $this->form_validation->set_rules('rec_email', display('email'), 'required|valid_email|max_length[100]|trim');
        $userData = array(
            'email' => $this->input->post('rec_email')
        );
        if ($this->form_validation->run()) {
            $user = $this->auth_model->password_recovery($userData);
            $ptoken = date('ymdhis');
            $type = 'admin_user';
            if ($user->num_rows() > 0) {
                $email = $user->row()->email;
                $precdat = array(
                    'email' => $email,
                    'password_reset_token' => $ptoken,

                );
                $send_email = '';

///////////////////////////////////////////////////////////////////////
        //// IF MAIL SENDING CREATES PROBLEM , SKIP IT ////
///////////////////////////////////////////////////////////////////////


goto skip_pdf_mail;

                if (!empty($email)) {
                    $send_email = $this->setmail($email, $ptoken, $type);
                    $this->auth_model->update_recovery_pass($precdat);
                }
                if ($send_email) {
                    $user_data['success'] = 'check Your email';
                    $user_data['status'] = true;
                } else {
                    $user_data['exception'] = 'Sorry Email Not Send';
                    $user_data['status'] = false;
                }

                
skip_pdf_mail:

///////////////////////////////////////////////////////////////////////
        //// IF MAIL SENDING CREATES PROBLEM , SKIP IT ////
///////////////////////////////////////////////////////////////////////


            } else {
                $user_data['exception'] = 'Email Not found';
                $user_data['status'] = false;
            }
        } else {
            $user_data['exception'] = 'please try again';
            $user_data['status'] = false;
        }

        echo json_encode($user_data);
    }

    //Passenger password recovery

    public function setmail($email, $ptoken = null, $type = null, $subject = null, $message = null)
    {
        $setting_detail = $this->db->select('*')->from('email_config')->get()->row();
        if(empty($subject))
        {
            $subject = 'Bus 365 password recovery';
        }

        if(empty($message))
        {
            if ($type == 'admin_user') {
                $message = base_url() . '/website/website/recovery_password_confirmation/' . $ptoken;
            } else {
                $message = base_url() . '/website/website/passenger_password_confirmation/' . $ptoken;
            }
        }

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
        //$this->email->attach($file_path);

        $check_email = $this->test_input($email);

        if (filter_var($check_email, FILTER_VALIDATE_EMAIL)) {

            if ($this->email->send()) {
                $this->session->set_flashdata(array('message' => display('email_send_to_passenger')));
                return true;
            } else {
                $this->session->set_flashdata(array('exception' => display('email_not_send')));
                return false;
            }

        } else {
            $this->session->set_userdata(array('message' => display('successfully_added')));
            //redirect("website/Paypal/local_success/". $id);
        }
    }

    public function test_input($data)
    {

        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    //Email testing for email

    public function passenger_password_recovery()
    {
        $this->form_validation->set_rules('rec_email', display('email'), 'required|valid_email|max_length[100]|trim');
        $data['user'] = (object)$userData = array(
            'email' => $this->input->post('rec_email'),
        );
        $user_data['success'] = "";
        $user_data['exception'] = "";
        if ($this->form_validation->run()) {
            $user = $this->auth_model->passenger_password_recovery($userData);
            $ptoken = date('ymdhis');
            if ($user->num_rows() > 0) {
                $email = $user->row()->email;
                $type = 'passenger';
                $precdat = array(
                    'email' => $email,
                    'password_reset_token' => $ptoken
                );
                $send_email = '';
                if (!empty($email)) {
                    $send_email = $this->setmail($email, $ptoken, $type);

                }
                if ($send_email) {
                    if($this->auth_model->passenger_recovery_pass($precdat))
                    {
                        $user_data['success'] .= 'Recovery Code Sent. ';
                        $user_data['status'] = true;
                    }
                    else
                    {
                        $user_data['exception'] .= 'Recovery Failed';
                        goto x;
                    }
                    $user_data['success'] .= 'Check Your email';

                } else {
                    $user_data['exception'] .= 'Sorry Email Not Send';
                    $user_data['status'] = false;
                }

            } else {
                $user_data['exception'] .= 'Email Not found';
                $user_data['status'] = false;
            }
        } else {
            x:
            $user_data['exception'] .= 'Please try again';
            $user_data['status'] = false;
        }

        echo json_encode($user_data);
    }

    public function recovery_pass_update()
    {
        $this->form_validation->set_rules('new_password', display('password'), 'required|max_length[100]|trim');
        if ($this->form_validation->run()) {
            $precdat = array(
                'password' => md5($this->input->post('new_password')),
                'password_reset_token' => $this->input->post('rec_password')
            );
            if (!empty($this->input->post('new_password'))) {
                $this->auth_model->update_forgot_pass($precdat);
                $this->session->set_flashdata(array('message' => 'Successfully recoverd'));
                redirect('login');
            }
        }
        $this->session->set_flashdata(array('exception' => 'Check Password'));
        redirect('website/website/recovery_password_confirmation/' . $this->input->post('rec_password'));
    }

// passenger recovery password update
    public function passenger_recovery_pass_update()
    {
        $this->form_validation->set_rules('new_password', display('password'), 'required|max_length[100]|trim');

        if ($this->form_validation->run()) {
            $precdat = array(
                'password' => md5($this->input->post('new_password')),
                'password_reset_token' => $this->input->post('rec_password')
            );
            if (!empty($this->input->post('new_password')) && !empty($this->input->post('rec_password'))) {
                if ($email = $this->auth_model->update_passenger_forgot_pass($precdat)) {
                        $this->session->set_flashdata(array('message' => 'Successfully recoverd'));
                        $subject = "Passanger Information";
                        $message = "Your password reset successfully. \nThank you. \n ** This is an Auto Generated Mail. Please, Do not reply.";
                        $this->setmail($email,"","",$subject,$message);

                        redirect('userlog');
                }
            }
        }

        $this->session->set_flashdata(array('exception' => 'Check Password'));
        redirect('website/website/passenger_password_confirmation/' . $this->input->post('rec_password'));

    }
}
