<?php 
class Api extends CI_Controller {
     public function __construct()
    {
        parent::__construct();
        $this->load->model(array(
            'api_model'
        )); 
    }
    
        //Index is loading first
        public function index(){
            $secret_key = $this->input->get('secret_key');
            $check_secret = $this->api_model->check_secret($secret_key);
            if($check_secret > 0){

            $json['response'] = array(
                'status' => display('ok')
            );
        }else{
             $json['response'] = array(
                'status'  => display('error'),
                'message' => 'Secret Key is not valid'
                 );
        }
            
            echo json_encode($json,JSON_UNESCAPED_UNICODE);
        }

        /*
        |---------------------------------------------------
        |Web Settings And Language Data 
        |---------------------------------------------------
        */

        public function webSetting(){
            $secret_key   = $this->input->get('secret_key');
            $check_secret = $this->api_model->check_secret($secret_key);


             if($check_secret > 0){
            $settings = $this->api_model->settings_data();

            if (!empty($settings)) {

        $json['response'] = [
                'status'         => display('ok'),
                'base_url'       => base_url(),
                'email'          => display('email'),
                'logo_url'       => base_url().$settings->logo,
                'dashboard'      => display('dashboard'),
                'login'          => display('login'),
                'register'       => display('register'),
                'registrantion'  => display('registrantion'),
                'forgot_password'=> display('forgot_password'),
                'password'       => display('password'),
                'search_tour'    => display('search_tour'),
                'start_point'    => display('start_point'),
                'end_point'      => display('end_point'),
                'location_details'=> display('location_details'),
                'journey_date'   => display('journey_date'),
                'fleet_type'     => display('fleet_type'),
                'select_start_point'     => display('select_start_point'),
                'select_end_point' => display('select_end_point'),
                'select_fleet_type'=> display('select_fleet_type'),
                'route'            => display('route'),
                'departure'        => display('departure'),
                'duration'         => display('duration'),
                'distance'         => display('distance'),
                'arrival'          => display('arrival'),
                'adult_fare'       => display('adult_fare'),
                'child_fare'       => display('child_fare'),
                'special_fare'     => display('special_fare'),
                'operator'         => display('operator'),
                'seats_available'  => display('seats_available'),
                'total_seats'      => display('total_seats'),
                'pickup_and_drop'  => display('pickup_and_drop'),
                'pickup_location'  => display('pickup_location'),
                'drop_location'    => display('drop_location'),
                'select_pickup_location' => display('select_pickup_location'),
                'select_drop_location'   => display('select_drop_location'),
                'adult'          => display('adult'),
                'children'       => display('children'),
                'special'        => display('special'),
                'offer_code'     => display('offer_code'),
                'facilities'     => display('facilities'),
                'tap_to_select_seat'=> display('tap_to_select_seat'),
                'seat_layout'    => display('seat_layout'),
                'adult_price'    => display('adult_price'),
                'child_price'    => display('child_price'),
                'special_price'  => display('special_price'),
                'group_price'    => display('group_price'),
                'total'          => display('total'),
                'continue'       => display('continue'),
                'passenger_details'     => display('passenger_details'),
                'full_name'      => display('full_name'),
                'email_address'  => display('email_address'),
                'address'        => display('address'),
                'journery_details'=> display('journery_details'),
                'booking_date'   => display('booking_date'),
                'terms_and_condition'     => display('terms_and_condition'),
                'select_your_payment_method'=> display('select_your_payment_method'),
                'paypal'         => display('paypal'),
                'bank_transfer'  => display('bank_transfer'),
                'cash_payment'   => display('cash_payment'),
                'total_price'    => display('total_price'),
                'select_your_bank_first'  => display('select_your_bank_first'),
                'select_bank_name'=> display('select_bank_name'),
                'transaction_id'  => display('transaction_id'),
                'confirm_booking' => display('confirm_booking'),
                'select_journey_date'     => display('select_journey_date'),
                'search'         => display('search'),
                'seat_details'   => display('seat_details'),
                'book'           => display('book'),
                'seat_n'         => display('seat_n'),
                'booking_id'     => display('booking_id'),
                'first_name'     => display('first_name'),
                'last_name'      => display('last_name'),
                'confirm_password'=> display('confirm_password'),
                'no_facilities_available'  => display('no_facilities_available'),
                'seats'         => display('seats'),
                'must_put_email_pass'      => display('must_put_email_pass'),
                'havn_nt_acc'   => display('havn_nt_acc'),
                'email_and_password_d_match'=> display('email_and_password_d_match'),
                'required_field' => display('required_field'),
                'must_put_email' => display('must_put_email'),
                'select_pickup_and_drop_location'=> display('select_pickup_and_drop_location'),
                'select_your_seat_properly'=> display('select_your_seat_properly'),
                'seat_properly'           => display('seat_properly'),
                'check_term_and_condition'=> display('check_term_and_condition'),
                'check_your_mail'         => display('check_your_mail'),
                'plz_check_your_seat'     => display('plz_check_your_seat'),
                'no_rout_available'       => display('no_rout_available'),
                'your_booking_complete'   => display('your_booking_complete'),
                'bank_booking_message'    => display('bank_booking_message'),
                'must_put_atlest_seat_num'=> display('must_put_atlest_seat_num'),
                'phone'           => display('phone'),
                'account_name'    => display('account_name'),
                'account_number'  => display('account_number'),
                'bank_name'       => display('bank_name'),
                'paypal_payment'  => display('paypal_payment'),
                'bank_information'=> display('bank_information'),
                'change_select_end_point' => display('change_select_end_point'),
                'must_put_your_mail'      => display('must_put_your_mail'),
                'invalid_email_address'   => display('invalid_email_address'),
                'logout'         => display('logout'),
                'log_out'        => display('log_out'),
                'name'           => display('name'),
                'confirm'        => display('confirm'),
                'are_you_sure'   => display('are_you_sure'),
                'plz_check_your_mail_to_reset_passw'=> display('plz_check_your_mail_to_reset_passw'),
                'edit_profile'   => display('edit_profile'),
                'select_profile_image'        => display('select_profile_image'),
                'save_profile'  => display('save_profile'),
                'view_profile'  => display('view_profile'),
                'no'            => display('no'),
                'home'          => display('home'),
                'developed_by_bdtask'         => display('developed_by_bdtask'),
                'pass_username_cant_be_empty' => display('pass_username_cant_be_empty'),
                'login_again'  => display('login_again'),
                'settings'     => $settings,
                'permission'   => 'read'
            ];

            } else {

                $json['response'] = [

                        'status'  => display('error'),
                        'message' => display('settings_not_found')

                    ];
                
            }

             }else{
             $json['response'] = array(
                'status'  => display('error'),
                'message' => 'Secret Key is not valid'
                 );
        }

            echo $json_encode = json_encode($json, JSON_UNESCAPED_UNICODE);

        }
    /*
    |----------------------------------------------------
    |Location List
    |-----------------------------------------------------
     */
    public function location(){
            $secret_key = $this->input->get('secret_key');
            $check_secret = $this->api_model->check_secret($secret_key);
            if($check_secret > 0){
          $location = $this->api_model->all_location();
             if (!empty($location)) {

                $json['response'] = [
                        'status'    => 'ok',
                        'locations' => $location,
                        'permission'=> 'read'
                    ];

            } else {

                $json['response'] = [

                        'status'  => display('error'),
                        'message' => display('location_not_found')

                    ];
                
            }
             }else{
             $json['response'] = array(
                'status'  => display('error'),
                'message' => 'Secret Key is not valid'
                 );
        }

            echo $json_encode = json_encode($json, JSON_UNESCAPED_UNICODE);
        }
   

    /*
    |-------------------------------------------------
    |Fleet List 
    |--------------------------------------------------
    */
    public function fleet_list(){
        $secret_key = $this->input->get('secret_key');
        $check_secret = $this->api_model->check_secret($secret_key);
            if($check_secret > 0){

        $fleets = $this->api_model->all_fleet();
             if (!empty($fleets)) {

                $json['response'] = [
                        'status'     => 'ok',
                        'fleets'     => $fleets,
                        'permission' => 'read'
                    ];

            } else {

                $json['response'] = [
                        'status'  => display('error'),
                        'message' => display('Fleets_not_found')

                    ];
                
            }
            }else{
             $json['response'] = array(
                'status'  => display('error'),
                'message' => 'Secret Key is not valid'
                 );
        }

            echo $json_encode = json_encode($json, JSON_UNESCAPED_UNICODE);
    }
    /*
    |-----------------------------------------------------
    |Website notifications
    |------------------------------------------------------
    */
    public function notification(){
       $totalpassenger = $this->api_model->all_passenger();
        $totalfleet    = $this->api_model->total_fleets();
        $total_trip    = $this->api_model->all_trip();
        $secret_key    = $this->input->get('secret_key');
        $check_secret  = $this->api_model->check_secret($secret_key);
            if($check_secret > 0){
                $json['response'] = [
                        'status'          => display('ok'),
                        'total_passenger' => $totalpassenger->total,
                        'total_fleet'     => $totalfleet->total,
                        'total_trip'      => $total_trip->total,
                        'permission'      => 'read'
                    ];
                     }else{
             $json['response'] = array(
                'status'  => display('error'),
                'message' => 'Secret Key is not valid'
                 );
        }

    
        echo $json_encode = json_encode($json, JSON_UNESCAPED_UNICODE);
    }
    /*
    |------------------------------------------------------------------
    |Offer image for slide
    |------------------------------------------------------------------
    */
    public function slide(){
        $images = $this->api_model->offer_image();
        $secret_key = $this->input->get('secret_key');
        $check_secret = $this->api_model->check_secret($secret_key);
            if($check_secret > 0){
             if (!empty($images)) {

                $json['response'] = [
                        'status'     => display('ok'),
                        'slide_image'=> $images,
                        'permission' => 'read'
                    ];

            } else {

                $json['response'] = [
                        'status'      => display('error'),
                        'message'     => display('image_not_found'),
                         'permission' => 'read'
                    ];
                
                 }
             }else{
             $json['response'] = array(
                'status'  => display('error'),
                'message' => 'Secret Key is not valid'
                 );
        }
        echo $json_encode = json_encode($json, JSON_UNESCAPED_UNICODE);
    }

    /*
    |---------------------------------------------------
    | Search Trip 
    |---------------------------------------------------
    */
    public function search(){
        $getStartPoint = $this->input->get('start_point');
        $getEndPoint   = $this->input->get('end_point');
        $getDate       = $this->input->get('date');
        $getFleetType  = $this->input->get('fleet_type');
        $searchdate    = date("Y-m-d", strtotime(!empty($getDate)?$getDate:date('Y-m-d')));
       $secret_key = $this->input->get('secret_key');
       $check_secret = $this->api_model->check_secret($secret_key);
            if($check_secret > 0){
        
        #--------------- DATA------------------
       
        $startpoint = $getStartPoint;
        $endpoint   =  $getEndPoint;
        $fleet      =  $getFleetType;
        $trips      = $this->api_model->trip_search($startpoint,$endpoint,$fleet,$searchdate);
        $available =[];
         $i=0;
        foreach($trips as $trp){
           $bookingResult = 0;
           $bookingResult = $this->api_model->booking_result($trp->trip_id_no,$getDate);
           $available[$i] = $trp->fleet_seats-$bookingResult;
            $i++;
            $route_name = $trp->trip_route_name;
        }
          if (empty( $startpoint) || empty( $endpoint || empty($fleet))) {
            $json['response'] = [
                'status'      => display('error'),
                'message'     => display('no_trip_available'),
                 'permission' => 'read'
            ];

        } else {
         $json['response'] = [
                'status'       => 'ok',
                'date'         => date("Y-m-d", strtotime(!empty($getDate)?$getDate:date('Y-m-d'))),
               'fleet_type'    => $fleet,
               'route_name'    => $route_name,
               'available'     => $available,
               'trip_list'     =>  $trips,
               'permission'    => 'read'
                    ];
    }
       }else{
             $json['response'] = array(
                'status'  => display('error'),
                'message' => 'Secret Key is not valid'
                 );
        }

    
        echo $json_encode = json_encode($json, JSON_UNESCAPED_UNICODE);
    }

  
    /*
    |---------------------------------------------------
    |   Get Login info
    |---------------------------------------------------
    */

    public function login(){ 

        $secret_key = $this->input->get('secret_key');
        $check_secret = $this->api_model->check_secret($secret_key);
            if($check_secret > 0){
        $email    = $this->input->get('email');
        $password =  $this->input->get('password'); 
        if (empty($email) || empty($password)) {
            $json['response'] = [
                'status'      => display('error'),
                'type'        => 'required_field',
                'message'     => 'required_field',
                'permission'  => 'read'
            ];

        } else {


            $data['user'] = (object) $userData =  [
                'email'      => $email,
                'password'   => $password
            ];


            $user = $this->api_model->checkUser($userData);


            if($user->num_rows() > 0) {
         
         
                $sData = array(
                    'id'          => $user->row()->id,
                    'id_no'       => $user->row()->id_no,
                    'firstname'   => $user->row()->firstname,
                    'lastname'    => $user->row()->lastname,
                    'email'       => $user->row()->email,
                    'image'       => $user->row()->image,
                    'password'    => $user->row()->password,
                    'phone'       => $user->row()->phone,
                    'address'     => $user->row()->address_line_1,
                    'is_passenger'=> 1
                );
                
                $json['response'] = [
                    'status'       => 'ok',
                    'user_data'    => $sData,
                    'message'      => display('successfully_login'),
                    'permission'   => 'read'
                ];

            } else {

                $json['response'] = [
                    'status'      => display('error'),
                    'message'     => display('no_data_found'),
                     'permission' => 'read'
                ];

            } 

        }
         }else{
             $json['response'] = array(
                'status'  => display('error'),
                'message' => 'Secret Key is not valid'
                 );
        }
        
        

        echo json_encode($json, JSON_UNESCAPED_UNICODE); 

    }


    /*
   |----------------------------------------------------------------------
   |User Registration Information
   |----------------------------------------------------------------------
   */

public function user_registration(){
     $firstname    = $this->input->get('firstname');
     $lastname     = $this->input->get('lastname');  
     $email        = $this->input->get('email');
     $password     =  $this->input->get('password'); 
     $phone        = $this->input->get('phone');
     $nid          = $this->input->get('nid');
     $address      = $this->input->get('address');
     $secret_key   = $this->input->get('secret_key');
     $check_secret = $this->api_model->check_secret($secret_key);
            if($check_secret > 0){

      $postData = array(
                    'id_no'       => $this->randdomString("P"),
                    'firstname'   => $firstname,
                    'lastname'    => $lastname,
                    'email'       => $email,
                    'password'    => $password,
                    'nid'         => (!empty($nid)?$nid:''),
                    'phone'       => (!empty($phone)?$phone:''),
                    'address_line_1'=> (!empty($address)?$address:''), 
                    'status'      => 1
                ); 
            $user = $this->api_model->registration_checkUser($email);
            if($user->num_rows() < 1) {
                if($this->api_model->create_passenger($postData)){
                
                    $json['response'] = [
                    'status'      => 'ok',
                    'message'     => display('successfully_saved'),
                     'permission' => 'write'
                ];
                }else{
                  $json['response'] = [
                    'status'      => display('error'),
                    'message'     => display('please_try_again'),
                     'permission' => 'read'
                ];  
                }
                    
               
                
            }else{
                $json['response'] = [
                    'status'  => display('error'),
                    'message' => 'User Already Exist !! Please Try another.',
                    'permission' => 'read'
                ];
            }
             }else{
             $json['response'] = array(
                'status'  => display('error'),
                'message' => 'Secret Key is not valid'
                 );
        }
 echo json_encode($json, JSON_UNESCAPED_UNICODE);                
}

//user edit data
public function user_edit_form(){
    $id            = $this->input->get('id');
    $userdata      = $this->api_model->paggenger_details($id); 
    $secret_key    = $this->input->get('secret_key');
    $check_secret  = $this->api_model->check_secret($secret_key);
            if($check_secret > 0){
   if(!empty($userdata)){
            $json['response'] = [
                    'id_no'      => $userdata->id_no,
                    'status'     => 'ok',
                    'firstname'  => $userdata->firstname,
                    'lastname'   => $userdata->lastname,
                    'email'      => $userdata->email,
                    'password'   => $userdata->password,
                    'img'        => base_url().$userdata->image,
                    'phone'      => $userdata->phone,
                    'nid'        => $userdata->nid,
                    'address'    => $userdata->address_line_1,
                    'permission' => 'read'
                ];
   }else{
       $json['response'] = [
                    'status'     => display('error'),
                    'message'    => 'No data found',
                    'permission' => 'read'
                ]; 
   }
    }else{
             $json['response'] = array(
                'status'  => display('error'),
                'message' => 'Secret Key is not valid'
                 );
        }
       
    echo json_encode($json, JSON_UNESCAPED_UNICODE); 
}
//user update
public function user_update(){
         $id           = $this->input->get('id_no'); 
         $firstname    = $this->input->get('firstname');
         $lastname     = $this->input->get('lastname');  
         $email        = $this->input->get('email');
         $password     =  $this->input->get('password');
         $old_password = $this->input->get('old_password');
         $phone        = $this->input->get('phone');
         $nid          = $this->input->get('nid');
         $address      = $this->input->get('address');

         $secret_key = $this->input->get('secret_key');
         $check_secret = $this->api_model->check_secret($secret_key);
            if($check_secret > 0){ 
        $postData = array(
                    'id_no'       => $id,
                    'firstname'   => $firstname,
                    'lastname'    => $lastname,
                    'email'       => $email,
                    'password'    => (!empty($password)?md5($password):$old_password),
                    'nid'         => (!empty($nid)?$nid:''),
                    'phone'       => (!empty($phone)?$phone:''),
                    'address_line_1'=> (!empty($address)?$address:''), 
                    'status'      => 1
                ); 
               $update =  $this->api_model->update_passenger($postData);
                  if($update){
            $json['response'] = [
                    'status'      => 'ok',
                     'message'    => 'Successfully Updated',
                     'permission' => 'write'
                ];
               }else{
                   $json['response'] = [
                                'status'     => display('error'),
                                'message'    => 'Please try again',
                                'permission' => 'read'
                            ]; 
               }
      }else{
             $json['response'] = array(
                'status'  => display('error'),
                'message' => 'Secret Key is not valid'
                 );
        }
    echo json_encode($json, JSON_UNESCAPED_UNICODE); 
}

   
    private function randdomString($prefix = null)
    {
        $result = ""; 
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

        $charArray = str_split($chars);
        for($i = 0; $i < 7; $i++) {
            $randItem = array_rand($charArray);
            $result .="".$charArray[$randItem];
        }
        return $prefix . $result;
    }

   /*
   |----------------------------------------------------------------------
   |Search Seat and Layout
   |----------------------------------------------------------------------
   */
     public function findBookingInformation()
    {
   #--------------------------------------------------------
        $trip_route_id         = $this->input->get('route');
        $trip_id_no            = $this->input->get('trip_id_no');
        $fleet_registration_id = $this->input->get('fleet_registration_id');
        $fleet_type_id         = $this->input->get('type');
        $booking_date          = $this->input->get('booking_date');
        $secret_key            = $this->input->get('secret_key');
        $check_secret          = $this->api_model->check_secret($secret_key);
            if($check_secret > 0){ 
        //booked seat
  
        $bookedSeats = $this->api_model->booked_seats($trip_id_no,$booking_date);

        $bookArray = array();
        $bookArray = array_map('trim', explode(',', $bookedSeats->booked_serial));
        
        //all seats 
         $fleetSeats = $this->api_model->fleet_seats($fleet_type_id);
        $seatArray   = array();
        $seatArray   = array_map('trim', explode(',', $fleetSeats->seat_numbers));
        
        // Facilities 
        $facilitiesArray = array();
        $facilitiesArray = array_map('trim', explode(',', $fleetSeats->fleet_facilities));
        
     $removelastcomma= trim($bookedSeats->booked_serial,',');
        $testarray =  explode(',', $removelastcomma);
        if($fleetSeats->layout=='2-2'){
        $leftseat = ["A1","A2","B1","B2","C1","C2","D1","D2","E1","E2","F1","F2","G1","G2","H1","H2","I1","I2","J1","J2","K1","K2","L1","L2","M1","M2"];
        $rightseat = ["A3","A4","B3","B4","C3","C4","D3","D4","E3","E4","F3","F4","G3","G4","H3","H4","I3","I4","J3","J4","K3","K4","L3","L4","M3","M4"];
    }else if($fleetSeats->layout=='3-2'){
      $leftseat = ["A1","A2","A3","B1","B2","B3","C1","C2","C3","D1","D2","D3","E1","E2","E3","F1","F2","F3","G1","G2","G3","H1","H2","H3","I1","I2","I3","J1","J2","J3","K1","K2","K3","L1","L2","L3","M1","M2","M3","N1","N2","N3"];
      $rightseat = ["A4","A5","B4","B5","C4","C5","D4","D5","E4","E5","F4","F5","G4","G5","H4","H5","I4","I5","J4","J5","K4","K5","L4","L5","M4","M5"];
    }else if($fleetSeats->layout=='2-3'){
      $leftseat =  ["A1","A2","B1","B2","C1","C2","D1","D2","E1","E2","F1","F2","G1","G2","H1","H2","I1","I2","J1","J2","K1","K2","L1","L2","M1","M2"];
      $rightseat =["A3","A4","A5","B3","B4","B5","C3","C4","C5","D3","D4","D5","E3","E4","E5","F3","F4","F5","G3","G4","G5","H3","H4","H5","I3","I4","I5","J3","J4","J5","K3","K4","K5","L3","L4","L5","M3","M4","M5","N3","N4","N5"];
    }else if($fleetSeats->layout=='1-1'){
      $leftseat =  ["A1","B1","C1","D1","E1","F1","G1","H1","I1","J1","K1","L1","M1"];
      $rightseat =["A2","B2","C2","D2","E2","F2","G2","H2","I2","J2","K2","L2","M2","N2"];
    }else if($fleetSeats->layout=='2-1'){
      $leftseat =  ["A1","A2","B1","B2","C1","C2","D1","D2","E1","E2","F1","F2","G1","G2","H1","H2","I1","I2","J1","J2","K1","K2","L1","L2","M1","M2"];
      $rightseat =["A3","B3","C3","D3","E3","F3","G3","H3","I3","J3","K3","L3","M3","N3"];
    }if($fleetSeats->layout=='1-2'){
        $leftseat = ["A1","B1","C1","D1","E1","F1","G1","H1","I1","J1","K1","L1","M1"];
        $rightseat = ["A2","A3","B2","B3","C2","C3","D2","D3","E2","E3","F2","F3","G2","G3","H2","H3","I2","I3","J2","J3","K2","K3","L2","L3","M2","M3"];
    }
        $testleft= array_intersect($seatArray, $leftseat);
        $testright= array_intersect($seatArray, $rightseat);
        $leftbooked = array_intersect($testleft, $bookArray);
        $rightbooked = array_intersect($testright, $bookArray);
        //left side without book
        $leftblank = array_diff($testleft, $bookArray);
        $rightblank = array_diff($testright, $bookArray);
        // booked and unbooked layout
        $lefttestbookarray =[];
         $i=0;
        foreach ($leftbooked as $value) {
            $lefttestbookarray[$i]['name']=$value;
            $lefttestbookarray[$i]['status']="booked";
            $i++;
           
        }
        $k=$i;
        foreach($leftblank as $value){
             $lefttestbookarray[$k]['name']=$value;
            $lefttestbookarray[$k]['status']="Free";
            $k++;
        }
        
        asort($lefttestbookarray);
        $lefttestbookarray = array_values($lefttestbookarray);
        $righttestbookarray =[];
         $e=0;
        foreach ($rightbooked as $value) {
            $righttestbookarray[$e]['name']=$value;
            $righttestbookarray[$e]['status']="booked";
            $e++;
           
        }
          
         $j=$e;
        foreach($rightblank as $value){
             $righttestbookarray[$j]['name']=$value;
            $righttestbookarray[$j]['status']="Free";
            $j++;
        }
       asort($righttestbookarray);
        $righttestbookarray = array_values($righttestbookarray);
        
        //stopages
         $tripLocation = $this->api_model->stoppage_points($trip_route_id);

        $locationArray = array();
        $locationArray = array_map('trim', explode(',', $tripLocation->stoppage_points));
        //trip prices
         $tripPrice = $this->api_model->trip_price($trip_route_id,$fleet_type_id);
            //offer part
            $offer_date =date("Y-m-d H:i:s", strtotime($booking_date)); 
            $checkOffer =  $this->api_model->offers($trip_route_id,$offer_date);
        if (empty($trip_id_no) || empty($fleet_type_id)) {

            $json['response'] = [
                'status'      => display('error'),
                'message'     => 'some mistakes',
                 'permission' => 'read'
            ];

        } else {

             $json['response'] = [
                    'status'      => 'ok',
                    'leftsite'    => $lefttestbookarray,
                    'right'       => $righttestbookarray,
                    'offers'      => $checkOffer,
                    'facilities'  => $facilitiesArray,
                    'stopages'    => $locationArray,
                    'prices'      =>  $tripPrice,
                    'layout'      => $fleetSeats->layout,
                    'll'          => substr($fleetSeats->layout,0,-2),
                    'rl'          => substr($fleetSeats->layout,2),
                    'date'        => $booking_date,
                     'permission' => 'read'
                ];
        }
         }else{
             $json['response'] = array(
                'status'  => display('error'),
                'message' => 'Secret Key is not valid'
                 );
        }
         echo json_encode($json, JSON_UNESCAPED_UNICODE);  

}

 /*
|----------------------------------------------------------
|Booking History
|-----------------------------------------------------------
*/
 public function booking_history(){
       $secret_key   = $this->input->get('secret_key');
       $check_secret = $this->api_model->check_secret($secret_key);
       $booking_id   = $this->randdomString("B");
       $bank_info    = $this->api_model->bank_info();
       $seat_no      = $this->input->get('seat_number');
       $seat_no      = json_decode($seat_no);
       $seat_n       ='';
       $facilities   = $this->input->get('facilities');
       $facilities   = json_decode($facilities);
       $fac = '';
       $k=0;
        foreach($seat_no as $value){
            if($value[1]==1){
             $seat_n.=$value[0].',';
            }
            $k++;
        }
         $f=0;
        foreach($facilities as $facility){
            if($facility[1]==1){
             $fac.=$facility[0].',';
            }
            $f++;
        }


            if($check_secret > 0){ 
     $postData = array(
            'id_no'                => $booking_id,
            'trip_id_no'           => $this->input->get('trip_id_no'),
            'tkt_passenger_id_no'  => $this->input->get('passenger_id'),
            'trip_route_id'        => $this->input->get('trip_route_id'),
            'pickup_trip_location' => $this->input->get('pickup_location'),
            'drop_trip_location'   => $this->input->get('drop_location'),
            'request_facilities'   => $fac,
            'price'                => $this->input->get('price'),
            'discount'             => $this->input->get('discount'),
            'adult'                => $this->input->get('adult'),
            'child'                => $this->input->get('child_no'),
            'special'              => $this->input->get('special'),
            'total_seat'           => $this->input->get('total_seat'),
            'seat_numbers'         => $seat_n,
            'offer_code'           => $this->input->get('offer_code'),
            'tkt_refund_id'        => null, 
            'agent_id'             => null, 
            'booking_date'         => $this->input->get('booking_date'),
            'date'                 => date('Y-m-d H:i:s'),
            'status'               => '0'
        );
    $insetdata = $this->api_model->create_booking_history($postData);
    if ($insetdata) {
           
            $json['response'] = [
                    'status'      => 'ok',
                    'booking_id'  => $booking_id,
                    'bankinfo'    => $bank_info,
                    'seat_numbers'=> $seat_n,
                    'total_seat'  => $k,
                    'message'     => display('successfully_saved'),
                    'permission'  => 'read'
                ];

        } else {
          $json['response'] = [
                'status'      => display('error'),
                'message'     => display('please_try_again'),
                 'permission' => 'read'
            ];
             
        }
        }else{
             $json['response'] = array(
                'status'  => display('error'),
                'message' => 'Secret Key is not valid'
                 );
        }
         echo json_encode($json, JSON_UNESCAPED_UNICODE);  
 }

 /*
|---------------------------------------------------------
| Cash BOOKING CONFIRMATION INFO
|-----------------------------------------------------------
*/
 public function CashBooking()
    {       
            $secret_key    = $this->input->get('secret_key');
            $check_secret  = $this->api_model->check_secret($secret_key);
            $booking_id_no =  $this->input->get('booking_id_no');
            $ticket        = $this->api_model->CashbookingTicket($booking_id_no);
             if($check_secret > 0){    
            $data = array(
                'pickup_trip_location' => $ticket->pickup_trip_location,
                'drop_trip_location'   => $ticket->drop_trip_location,
                'tkt_passenger_id_no'  => $ticket->tkt_passenger_id_no,
                'trip_id_no'           => $ticket->trip_id_no,
                'id_no'                => $ticket->booking_id_no,
                'booking_date'         => $ticket->booking_date,
                'trip_route_id'        => $ticket->trip_route_id,
                'request_facilities'   => $ticket->request_facilities,
                'price'                => $ticket->price,
                'total_seat'           => $ticket->quantity,
                'discount'             => $ticket->discount,
                'seat_numbers'         => $ticket->seat_serial,
                'agent_id'             => $ticket->agent_id,
                'booking_date'         => $ticket->booking_date,
                'date'                 => $ticket->date,
                'payment_status'       => 2,
                'adult'                => $ticket->adult,
                'child'                => $ticket->child,
                'special'              => $ticket->special,
                'booking_type'         => 'Cash',
                );
              $email=$ticket->email;
              $name=$ticket->passenger_name;
             $this->load->library('pdfgenerator'); 
             $id=$ticket->booking_id_no;
             $datas['ticket'] = $this->api_model->CashbookingTicket($id);
             $html = $this->load->view('localticket_pdf', $datas, true);
                $dompdf = new Dompdf();
                $dompdf->load_html($html);
                $dompdf->render();
                $output = $dompdf->output();
                file_put_contents('assets/data/pdf/'.$id.'.pdf', $output);
                $file_path       = 'assets/data/pdf/'.$id.'.pdf';
                $send_email      = '';
                $remove_existing = $this->api_model->remove_existing_booking($id);
                $insertdata      = $this->api_model->create_booking($data);
                $removehistory   = $this->api_model->remove_history($id);
                 if (!empty($email)) {
                    $send_email = $this->setmail($email,$file_path,$id,$name);
                  $json['response'] = [
                    'status'     => 'ok',
                    'message'    => 'Email Send successfully',
                    'permission' => 'read'
                ];
                 }else{
                     $json['response'] = [
                    'status'     => display('error'),
                    'message'    => 'Email Not Sent',
                    'permission' => 'read'
                ];
                 }
                 }else{
             $json['response'] = array(
                'status'  => display('error'),
                'message' => 'Secret Key is not valid'
                 );
        }
                       
              echo json_encode($json, JSON_UNESCAPED_UNICODE);   
 
    }
     /*
|---------------------------------------------------------
| Bank BOOKING CONFIRMATION INFO
|-----------------------------------------------------------
*/
 public function BankBooking()
    {       $secret_key    = $this->input->get('secret_key');
            $check_secret  = $this->api_model->check_secret($secret_key);
            $booking_id_no = $this->input->get('booking_id_no');
            $comission     = $this->api_model->settings();
            $ticket        = $this->api_model->CashbookingTicket($booking_id_no); 
            $price_withcommission =($ticket->price*$comission->bank_commission)/100;
            if($check_secret > 0){    
            $bdata = array(
               'pickup_trip_location' => $ticket->pickup_trip_location,
                'drop_trip_location'  => $ticket->drop_trip_location,
                'tkt_passenger_id_no' => $ticket->tkt_passenger_id_no,
                'trip_id_no'          => $ticket->trip_id_no,
                'id_no'               => $ticket->booking_id_no,
                'booking_date'        => $ticket->booking_date,
                'trip_route_id'       => $ticket->trip_route_id,
                'request_facilities'  => $ticket->request_facilities,
                'price'               => $ticket->price+$price_withcommission,
                'total_seat'          => $ticket->quantity,
                'discount'            => $ticket->discount,
                'seat_numbers'        => $ticket->seat_serial,
                'agent_id'            => $ticket->agent_id,
                'booking_date'        => $ticket->booking_date,
                'date'                => $ticket->date,
                'payment_status'      => 2,
                'adult'               => $ticket->adult,
                'child'               => $ticket->child,
                'special'             => $ticket->special,
                'booking_type'        => 'Bank',
                );
                 $bankdata = array(
                  'booking_id'     => $booking_id_no,
                  'bank_id'        => $this->input->get('bank_id',true),
                  'payer_name'     => $passenger_id,
                  'transaction_id' => $this->input->get('tran_num',true),
                  'b_account_no'   => 0,
                  'amount'         => $ticket->price+$price_withcommission,
                  'note'           => 'bank booking',
                    );
             $email=$ticket->email;
             $name=$ticket->passenger_name;
             $this->load->library('pdfgenerator'); 
             $id=$ticket->booking_id_no;
             $datas['ticket']     = $this->api_model->CashbookingTicket($id);
              $datas['commission']=$this->api_model->settings();
             $html = $this->load->view('bank_ticket_pdf', $datas, true);
                $dompdf = new DOMPDF();
                $dompdf->load_html($html);
                $dompdf->render();
                $output = $dompdf->output();
                file_put_contents('assets/data/pdf/'.$id.'.pdf', $output);
                $file_path       = 'assets/data/pdf/'.$id.'.pdf';
                 $send_email     = '';
                 $insertdata     = $this->api_model->create_booking($bdata);
                $removehistory   = $this->api_model->remove_history($id);
                $this->api_model->create_bank_transaction($bankdata);
                 if (!empty($email)) {
                    $send_email = $this->setmail($email,$file_path,$id,$name);
                  $json['response'] = [
                    'status'     => 'ok',
                    'message'    => 'Email Send successfully',
                    'permission' => 'read'
                ];
                 }else{
                     $json['response'] = [
                    'status'     => display('error'),
                    'message'    => 'Email Not Sent',
                    'permission' => 'read'
                ];
                 }
                  }else{
             $json['response'] = array(
                'status'  => display('error'),
                'message' => 'Secret Key is not valid'
                 );
        }
                       
            
              echo json_encode($json, JSON_UNESCAPED_UNICODE); 

 
    }
    /*
    |---------------------------------------------------------------------------
    |Paypal Booking Info Start
    |---------------------------------------------------------------------------
    */
    public function buy()
    { 
        $booking_id_no = $this->input->get('booking_id_no');
        $this->load->library('paypal_lib'); 
        if (empty($booking_id_no))
        {
            redirect('api/cancel');
        } 
        else 
        {
            $ticket     = $this->api_model->CashbookingTicket($booking_id_no);
            $appSetting = $this->api_model->settings_data();

            $seat  = (!empty($ticket->quantity)?$ticket->quantity:1);

            $price = (!empty($ticket->price)?$ticket->price:0);
            $price = number_format(($price/$seat), 2); 

            $discount = number_format((!empty($ticket->discount)?$ticket->discount:0), 2);
            $item_name = "Ticket :: $appSetting->title";
            // ---------------------
            //Set variables for paypal form
            $returnURL = base_url("api/success/$ticket->booking_id_no/$ticket->tkt_passenger_id_no"); //payment success url
            $cancelURL = base_url("api/cancel/$ticket->booking_id_no/$ticket->tkt_passenger_id_no"); //payment cancel url
            $notifyURL = base_url('api/ipn'); //ipn url
           
            //set session token
            $this->session->unset_userdata('_tran_token');
            $this->session->set_userdata(array('_tran_token'=>$booking_id_no));
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
    
   /*
   |----------------------------------------------------------------------
   |Paypal Success Function
   |----------------------------------------------------------------------
   */
    
    public function success($booking_id_no = null, $passenger_id_no = null)
    { 
    
       $this->load->library('paypal_lib'); 
        $data['title'] = display('ticket');
        #--------------------------------------
        //get the transaction data
        $paypalInfo = $this->input->get();
         
        //session token
        $token = $this->session->userdata('_tran_token');
        if ($token != $paypalInfo['item_number']) 
        {
            redirect('api/cancel');
        }   
        
        $data['item_number']   = $paypalInfo['item_number']; 
        $data['txn_id']        = $paypalInfo["tx"];
        $data['payment_amt']   = $paypalInfo["amt"];
        $data['currency_code'] = $paypalInfo["cc"];
        $data['status']        = $paypalInfo["st"];
        $passinfo=$this->db->select('*')->from('tkt_passenger')->where('id_no',$passenger_id_no)->get()->row();
         $email=$passinfo->email;
         $this->load->library('pdfgenerator'); 
         $id=$booking_id_no;
         $name=$passinfo->firstname.' '.$passinfo->lastname;
         $datas['appSetting']   = $this->api_model->settings_data();
         $data['languageList']  = $this->api_model->languageList(); 
         $datas['ticket']       = $this->api_model->getTicket($id);
         $datas['item_number']  = $paypalInfo['item_number']; 
         $datas['txn_id']       = $paypalInfo["tx"];
         $datas['payment_amt']  = $paypalInfo["amt"];
         $datas['currency_code']= $paypalInfo["cc"];
         $datas['status']       = $paypalInfo["st"];
         $html = $this->load->view('ticket_pdf', $datas, true);
            $dompdf = new DOMPDF();
            $dompdf->load_html($html);
            $dompdf->render();
            $output = $dompdf->output();
            file_put_contents('assets/data/pdf/'.$id.'.pdf', $output);
            $file_path = 'assets/data/pdf/'.$id.'.pdf';
             $send_email = '';
             if (!empty($email)) {
                $send_email = $this->setmail($email,$file_path,$id,$name);
             }
        $data['appSetting'] = $this->api_model->settings_data();
        $data['ticket']     = $this->api_model->getbookingTicket($data['item_number']); 
        $data['page']       = 'ticket'; 
        $this->load->view('layout', $data);  
    }
    
    /*
   |----------------------------------------------------------------------
   |Paypal Cancel Function
   |----------------------------------------------------------------------
   */
     public function cancel($booking_id_no = null, $passenger_id_no = null)
    {  
         $this->load->library('paypal_lib'); 
        #---------------Clean Database------------
        // delete booking
        if (!empty($booking_id_no)) {
            $this->api_model->remove_history($booking_id_no);
        }
        // delete user
        if (!empty($passenger_id_no)) {
            $this->api_model->remove_passenger($passenger_id_no);
        }
        #----------------------------------------
        $appSetting = $this->api_model->settings_data();
          $json['response'] = [
                    'status'     => display('error'),
                    'appSetting' => $appSetting,
                    'message'    => 'cancel',
                    'permission' => 'read'
                ]; 
        

        echo json_encode($json, JSON_UNESCAPED_UNICODE);   
    }
    
    /*
   |----------------------------------------------------------------------
   |Paypal IPN INformation
   |----------------------------------------------------------------------
   */
    public function ipn()
    {
         $this->load->library('paypal_lib'); 
        //paypal return transaction details array
        $paypalInfo             = $this->input->post(); 
        $data['user_id']        = $paypalInfo['custom'];
        $data['product_id']     = $paypalInfo["item_number"];
        $data['txn_id']         = $paypalInfo["txn_id"];
        $data['payment_gross']  = $paypalInfo["mc_gross"];
        $data['currency_code']  = $paypalInfo["mc_currency"];
        $data['payer_email']    = $paypalInfo["payer_email"];
        $data['payment_status'] = $paypalInfo["payment_status"];
        $paypalURL              = $this->paypal_lib->paypal_url;        
        $result                 = $this->paypal_lib->curlPost($paypalURL,$paypalInfo);
        
        //check whether the payment is verified
        if(preg_match("/VERIFIED/i",$result)){
            //insert the transaction data into the database
            $this->api_model->insertTransaction($data);
        }
    }
      
    /*
    |---------------------------------------------------------------------------
    |Paypal Booking Info End
    |---------------------------------------------------------------------------
    */
    

        //Send Custom Email 
    public function setmail($email,$file_path,$id,$name)
    {
        $setting_detail = $this->api_model->email_config_data();
        $subject ='ticket Information';
        $message =display('email_gritting').' '.$name.display('email_ticket_idinfo').'-'.$id;

        $config = Array(
            'protocol'      => $setting_detail->protocol,
            'smtp_host'     => $setting_detail->smtp_host,
            'smtp_port'     => $setting_detail->smtp_port,
            'smtp_user'     => $setting_detail->smtp_user, 
            'smtp_pass'     => $setting_detail->smtp_pass, 
            'mailtype'      => $setting_detail->mailtype,
            'charset'       => 'utf-8'
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

            if($this->email->send())
            {
                 $this->session->set_flashdata(array('message'=>display('email_send_to_passenger')));
                return true;
            }else{
               $this->session->set_flashdata(array('exception'=>display('email_not_send')));
                return false;
            }

        }else{
            $this->session->set_userdata(array('message'=>display('successfully_added')));
            redirect("website/Paypal/local_success/". $id);
        }
    }
        
        /*
        |--------------------------------------------------------------
        |Forgot Password
        |-----------------------------------------------------------------
        */
        public function password_recovery(){
         $secret_key   = $this->input->get('secret_key');
         $check_secret = $this->api_model->check_secret($secret_key);   
         $email        = $this->input->get('email');
         $user         = $this->api_model->passenger_password_recovery($email);
         $ptoken       = date('ymdhis');
         if($check_secret > 0){
        if($user->num_rows() > 0) {
            $email   = $user->row()->email;
            $type    = 'passenger';
            $precdat = array(
            'email'     => $email,
            'password_reset_token' => $ptoken
        );
             $send_email = '';
             if (!empty($email)) {
                $send_email = $this->setpasswordmail($email,$ptoken);
                $this->api_model->passenger_recovery_pass($precdat);
             }
           if($send_email){
           $json['response'] = [
                    'status'     => 'ok',
                    'message'    => 'Check Your Mail',
                    'permission' => 'read'
                ]; 
           
           }else{
            $json['response'] = [
                    'status'     => display('error'),
                    'message'    => 'Sorry Email Not Send',
                    'permission' => 'read'
                ]; 
           }

        }else{
             $json['response'] = [
                    'status'     => display('error'),
                    'message'    => 'Sorry Email Not Found',
                    'permission' => 'read'
                ]; 
        }
         }else{
             $json['response'] = array(
                'status'  => display('error'),
                'message' => 'Secret Key is not valid'
                 );
        }

        echo json_encode($json, JSON_UNESCAPED_UNICODE);   
    }
     public function setpasswordmail($email,$ptoken)
    {
   $msg = "Click on this url for change your password :".base_url().'recovery_form/'.$ptoken;
        // send email
        mail($email,"passwordrecovery",$msg);
        return true;
       
    }
       


    //Email testing for email
    public function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    
  
    
   
 public function do_upload() {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

        $status = array();
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $status['kode']=1;
        $status['deskripsi']='upload berhasil';
        } else {
        $status['kode']=0;
        $status['deskripsi']='upload TIDAK berhasil';
        }
      echo json_encode($status, JSON_UNESCAPED_UNICODE);  
    } 
    
    
    	public function user_booking(){
        $secret_key   = $this->input->get('secret_key');
        $check_secret = $this->api_model->check_secret($secret_key); 
    	$user_id      = $this->input->get('userid');   
    	 if($check_secret > 0){   
		$booking   = $this->api_model->passenger_booking_data($user_id);
             if (!empty($booking)) {

                $json['response'] = [
                        'status'     => display('ok'),
                        'booking'    => $booking,
                        'permission' => 'read'
                    ];

            } else {

                $json['response'] = [
                        'status'      => display('error'),
                        'message'     => 'no record found',
                        'permission'  => 'read'
                    ];
                
            }
              }else{
             $json['response'] = array(
                'status'  => display('error'),
                'message' => 'Secret Key is not valid'
                 );
        }
        echo $json_encode = json_encode($json, JSON_UNESCAPED_UNICODE);

 	}


  }

