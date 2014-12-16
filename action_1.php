<?php

//Actions for promotions
include_once './gen.php';
//include_once ;
//session_destroy();
//if (!isset($_SESSION['last_insert_id'])) {
//   session_start();
//}
//include "health_promotion.php";
//$last_inserted_id = $_SESSION['last_insert_id'];

$cmd = get_datan("cmd");
//$last_inserted_id = 2;
//$id = get_data("id");
//$date = get_data("date");
//$venue = get_data("venue");
//$page = get_datan("start");


switch ($cmd) {

   case 1:
      //get promotion based on idhealth promotion
      register();
      break;

   case 2:
      //get all promotions 
      login();
      break;

   case 3:
      confirm();
      break;

   case 4:
      //update promotion
      send_message();
      break;

   case 5:
      //g
      register_for_meeting();
      break;

   case 6;
      check_register_for_meeting();
      break;

   case 7;
      // get idcho from health promotion
      get_ticket();
      break;


   case 8;
      get_meetings();
      break;

   case 9;
      check_in();
      break;

   default:
      echo "{";
      echo jsonn("result", 0);
      echo ",";
      echo jsons("message", "not a recognised command");
      echo "}";
}

function check_in() {
   include_once './classes/user_has_meetings_class.php';

   $meeting_id = get_data("meeting_id");
   $user_id = get_datan("user_id");

   $obj = new user_has_meetings_class();
   if (!$obj->check_in_delegate($meeting_id, $user_id)) {
      echo "{";
      echo jsonn("result", 0) . ",";
      echo jsons("message", "Could not check in");
      echo "}";
      return;
   }

   echo "{";
   echo jsonn("result", 1) . ",";
   echo jsonn("id", $obj->get_insert_id()) . ",";
   echo jsons("message", "Checked in");
   echo "}";
}

function register() {
   include_once './classes/user_class.php';

   $fname = get_data("firstname");
   $lname = get_data("lastname");
   $email = get_data("email");
   $pass = get_data("password");
   $org = get_data("org");
   $phone = get_data("phone_num");
   $conf = get_datan("conf");

   $obj = new user_class();
   if (!$obj->add_user($fname, $lname, $email, $pass, $org, $phone, $conf)) {
      echo "{";
      echo jsonn("result", 0) . ",";
      echo jsons("message", "Could not register you");
      echo "}";
      return;
   }

   echo "{";
   echo jsonn("result", 1) . ",";
   echo jsonn("id", $obj->get_insert_id()) . ",";
   echo jsons("message", "Registered");
   echo "}";
}

function confirm() {
   include_once './classes/user_class.php';

   $id = get_datan("id");

   $schools_obj = new user_class();
   if (!$schools_obj->set_conf($id)) {

      echo "{";
      echo jsonn("result", 0) . ",";
      echo jsons("message", "Not confirmed");
      echo "}";
      return;
   }
   echo "{";
   echo jsonn("result", 1) . ",";
   echo jsons("message", "confirmed");
   echo "}";
   return;
}

function addassignment() {
   include_once './classes/teacher_login_class.php';
   $p = new teacher_login_class();
   $date_due = get_data("date");
   $teacher_id = get_datan("teacher_id");
   $school_id = get_datan("school_id");
   $class_id = get_datan("class_id");
   $subject_id = get_datan("subject_id");
   $ass = get_data("ass");

   if (!$p->acutalassignment($ass)) {
      echo "{";
      echo jsonn("result", 0) . ",";
      echo jsons("message", "Could not add assigment1");
      echo "}";
      return;
   }

   $assignment_id = $p->get_insert_id();
//   print_r($assignment_id);
//    check this toooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooddday
   if (!$p->addassignment($date_due, $teacher_id, $school_id, $class_id, $subject_id, $assignment_id)) {
      echo "{";
      echo jsonn("result", 0) . ",";
      echo jsons("message", "Could not add assigment2");
      echo "}";
      return;
   }
   echo "{";
   echo jsonn("result", 1) . ",";
   echo jsons("message", "Assignment added");
   echo "}";
}

function get_all_subjects() {
   include_once '../hw_tracker/classes/subject_class.php';

   $schools_obj = new subject_class();
   if (!$schools_obj->get_all_details()) {

      echo "{";
      echo jsonn("result", 0) . ",";
      echo jsons("subjects", "No class found");
      echo "}";
      return;
   }
   $row = $schools_obj->fetch();
   if (!$row) {

      echo "{";
      echo jsonn("result", 0) . ",";
      echo jsons("subjects", "No class found1d");
      echo "}";
      return;
   } else {
      echo "{";
      echo jsonn("result", 1);
      echo ',"subjects":';
      echo "[";

      while ($row) {
         echo "{";
         echo jsonn("id", $row["subject_id"]) . ",";
         echo jsons("subject_name", $row["subject_name"]);
         echo "}";

         $row = $schools_obj->fetch();
         if ($row) {
            echo ",";
         }
      }
      echo "]}";
   }
}

function get_all_classes() {
   include_once '../hw_tracker/classes/class_class.php';

   $schools_obj = new class_class();
   if (!$schools_obj->get_all_details()) {

      echo "{";
      echo jsonn("result", 0) . ",";
      echo jsons("schools", "No class found");
      echo "}";
      return;
   }
   $row = $schools_obj->fetch();
   if (!$row) {

      echo "{";
      echo jsonn("result", 0) . ",";
      echo jsons("classes", "No class found1d");
      echo "}";
      return;
   } else {
      echo "{";
      echo jsonn("result", 1);
      echo ',"classes":';
      echo "[";

      while ($row) {
         echo "{";
         echo jsonn("id", $row["class_id"]) . ",";
         echo jsons("class_number", $row["class_number"]);
         echo "}";

         $row = $schools_obj->fetch();
         if ($row) {
            echo ",";
         }
      }
      echo "]}";
   }
}

function send_message() {
   $data = get_data("conf");
   $phone = get_data("phone_num");
//   $teacher_id = get_datan("teacher_id");
   $url = "https://api.smsgh.com/v3/messages/send?"
           . "From=%2B233244813169"
           . "&To=%2B$phone"
           . "&Content=Your+confirmation+number:+$data"
           . "&ClientId=odfbifrp"
           . "&ClientSecret=rktegnml"
           . "&RegisteredDelivery=true";
// Fire the request and wait for the response
   $response = file_get_contents($url);
   var_dump($response);
}

function get_all_schools() {
//   session_start();
//   $_SESSION['paid']=0;


   include_once '../hw_tracker/classes/school_class.php';

   $schools_obj = new school_class();
   if (!$schools_obj->get_all_details()) {

      echo "{";
      echo jsonn("result", 0) . ",";
      echo jsons("schools", "No school found1d");
      echo "}";
      return;
   }
   $row = $schools_obj->fetch();
   if (!$row) {

      echo "{";
      echo jsonn("result", 0) . ",";
      echo jsons("schools", "No school found1d");
      echo "}";
      return;
   } else {
      echo "{";
      echo jsonn("result", 1);
      echo ',"schools":';
      echo "[";

      while ($row) {
         echo "{";
         echo jsonn("id", $row["school_id"]) . ",";
         echo jsons("school_name", $row["school_name"]);
         echo "}";

         $row = $schools_obj->fetch();
         if ($row) {
            echo ",";
         }
      }
      echo "]}";
   }
}

function transact() {
   session_start();
//   $_SESSION['paid']=0;


   $last_inserted_id = $_SESSION['last_insert_id'];

   $id = get_datan('user_id');
   $new_amount = get_datan('new_amount');
   $amount_before = get_datan('amount_before');
   $fare = get_datan('fare');
   $ticket = get_datan('ticket_num');
   $pick_up_location = get_datan("location");

   if ($id == 0) {
      return;
   }

   include_once './transaction_class.php';
   include_once './user_class.php';
   include_once './details_class.php';

   $p = new user_class();
   $q = new transaction_class();
   $d = new deatils_class();

   $row3 = 0;

//   print($d->get_isert_id($d));


   if ($d->get_details($last_inserted_id)) {
      $row3 = $d->fetch();
   }

   if ($row3 == 0 || $row3['seatsLeft'] == 0) {
      echo "{";
      echo jsonn("result", 0) . ",";
      echo jsons("message", "No seats left");
      echo "}";
      return;
   }

//   $already_reserved = 0;
   if ($q->search_transactions($id)) {
      $already_reserved = $q->fetch();
   }
//   print_r( $already_reserved);
   if ($already_reserved['c'] != 0) {
      echo "{";
      echo jsonn("result", 0) . ",";
      echo '"trans":{';
      echo jsons("message", "Already Reserved") . ",";
      echo jsons("ticket_num", $already_reserved['c']);
      echo "}";
      echo "}";
//      $_SESSION['paid'] = 1;
      return;
   }

   $row = $p->deduction($id, $new_amount);
   $row2 = $q->transaction($id, $fare, $ticket, $new_amount, $pick_up_location);

   $row4 = $d->update_info($row3['info_id'], $row3['seatsLeft'] - 1, $row3['numOfPssngrsReserved'] + 1, $row3['numOfSeats'], $row3['numOfPssngrsBus'], $row3['longitude'], "\"" . $row3['locationAddress'] . "\"", $row3['latitude']);

   if (!$row || !$row2 || !$row4) {
      echo "{";
      echo jsonn("result", 0) . ",";
      echo jsons("message", "Not saved");
      echo "}";
      return;
   }

   echo "{";
   echo jsonn("result", 1) . ",";
   echo '"user":{';
   echo jsons("tran", "transaction successful");
   echo "}";
   echo "}";

//    $_SESSION['paid'] = 1;
//    print $_SESSION['paid'];
}

function login() {
   include_once './classes/login_class.php';
//   include_once './details_class.php';
//   $details_obj = new deatils_class();
//   if (!$details_obj->get_all_details()) {
//      
//   } else {
//      $details_row = $details_obj->fetch();
//   }
//   session_start();
   $user = get_data('user');
   $pass = get_data('pass');
   $p = new login_class();
   $val = $p->login($user, $pass);
//   $row = 0;
   if ($val) {
      $row = $p->loadProfile($user, $pass);
      if ($row) {
         echo "{";
         echo jsonn("result", 1);
         echo ',"user":';
         echo "{";
         echo jsons("id", $row["user_id"]) . ",";
         echo jsons("username", $row["email"]) . ",";
         echo jsons("firstname", $row["firstname"]) . ",";
         echo jsons("lastname", $row["lastname"]);
         echo "}";
         print "}";
         return;
      }
   } else {
      echo "{";
      echo jsonn("result", 0) . ",";
      echo jsons("message", "error, no record retrieved");
      echo "}";
   }
//   if it's a new day - reset all values
//   include_once './details_class.php';
//   $det_obj = new deatils_class();
//   if (!$det_obj->get_all_details()) {
//      echo "{";
//      echo jsonn("result", 0) . ",";
//      echo jsons("message", "error, no record retrieved2");
//      echo "}";
//      return;
//   }
//   $last_inserted_id = 0;
//   $row2 = $det_obj->fetch();
////   print_r($row2);
//   $row3 = $row2;
//   while ($row2) {
////      $row3 = $row2;
//
//      $last_inserted_id = $row2['info_id'];
//      $_SESSION['last_insert_id'] = $last_inserted_id;
//
//      $row2 = $det_obj->fetch();
//   }
//   print_r($_SESSION);
//
//   $det_obj2 = new deatils_class();
//
////   print_r ($row3);
////   print $row3['date_created'];
//
//   $dt = new DateTime($row3['date_created']);
//
//   $dt1 = $dt->format('d-m-Y');
////   print "---------------" . ($row3['date_created']);
//   $dt2 = date('d-m-Y');
////           
////   print "dt1 " . ($dt1);
////   print "dt2 " . ($dt2);
////   print ($dt1 === $dt2);
////   
////exit();
//
//   if ($dt1 == $dt2) {
////      print "here";
//      return;
//   } else {
////      exit();
//      // create a new info row
//      if (!$det_obj->add_info($row3['numOfSeats'], 0, $row3['numOfSeats'], 0, $row3['longitude'], $row3['locationAddress'], $row3['latitude'])) {
////       this should be concatenated witht the top
//         echo "{";
//         echo jsonn("result", 0) . ",";
//         echo jsons("message", "error, could not create new tuple");
//         echo "}";
////         exit();
//      }
//      $_SESSION['last_insert_id'] = $det_obj->get_insert_id($det_obj);
////      print "created";
//   }
//   echo jsons("last_insert_id", $_SESSION['last_insert_id']);
//   echo "}";
//   print "}";
//   return;
}

function diver_update_bus_location() {
   $info_id = 1;
   $longitude = get_data('long');
   $latitude = get_data('lat');

   include_once './details_class.php';
   $update = new deatils_class();

   if (!$update->update_location($longitude, $latitude, $info_id)) {
      echo "{";
      echo jsonn("result", 0) . ",";
      echo jsons("message", "error, Unsuccesful");
      echo "}";
      return;
   }
   echo "{";
   echo jsonn("result", 1) . ",";
   echo jsons("message", "Succesful");
   echo "}";
}

function get_bus_loca() {
   include_once './details_class.php';
   $det = new deatils_class();
   if (!$det->get_all_details()) {
      echo "{";
      echo jsonn("result", 0) . ",";
      echo jsons("message", "error, Unsuccesful");
      echo "}";
      return;
   }
   $row = $det->fetch();
   echo "{";
   echo jsonn("result", 1) . ",";
   echo jsons("x", $row['longitude']) . ",";
   echo jsons("y", $row['latitude']);
   echo "}";
   return;
}

function increase() {

   session_start();
   $last_inserted_id = $_SESSION['last_insert_id'];
   $seats_left = get_data("seats_left");
   $pass_res = get_data('pass_res');
   $pass_on = get_data('pass_on');

   include_once './details_class.php';
   $d = new deatils_class();
//exit();
   $row4 = $d->update_pass($seats_left, $pass_res, $pass_on, $last_inserted_id);

   if (!$row4) {
      echo "{";
      echo jsonn("result", 0) . ",";
      echo jsons("message", "error, Unsuccesful");
      echo "}";
      return;
   }
   echo "{";
   echo jsonn("result", 1) . ",";
   echo jsons("message", "Successful");
   echo "}";
}

function decrease() {
   session_start();
//   $_SESSION['paid']=0;


   $last_inserted_id = $_SESSION['last_insert_id'];
}

function register_for_meeting() {
   include_once './classes/user_has_meetings_class.php';

   $user_id = get_datan("user_id");
   $met_id = get_datan("meeting_id");
   $tick = get_datan("code");

   $obj = new user_has_meetings_class();
   if (!$obj->reg_for_meeting($user_id, $met_id, $tick)) {
      echo "{";
      echo jsonn("result", 0) . ",";
      echo jsons("message", "Could not register you for meeting");
      echo "}";
      return;
   }
   echo "{";
   echo jsonn("result", 1) . ",";
   echo jsons("message", "You have been registerd for this event. Please don't be late.");
   echo "}";
   return;
}

function check_register_for_meeting() {
   include_once './classes/user_has_meetings_class.php';

   $user_id = get_datan("user_id");
   $met_id = get_datan("meeting_id");

   $obj = new user_has_meetings_class();
   if (!$obj->check_reg_for_meeting($user_id, $met_id)) {
      print($obj->check_reg_for_meeting($user_id, $met_id));
      echo "{";
      echo jsonn("result", 0) . ",";
      echo jsons("message", "Not registered");
      echo "}";
      return;
   }
   echo "{";
   echo jsonn("result", 1) . ",";
   echo jsons("message", "You are already registerd for this event. Here is your ticket.");
   echo "}";
   return;
}

function get_ticket() {
   include_once './classes/user_has_meetings_class.php';

   $user_id = get_datan("user_id");
   $met_id = get_datan("meeting_id");

   $obj = new user_has_meetings_class();
   if (!$obj->get_ticket_reg_for_meeting($user_id, $met_id)) {
      echo "{";
      echo jsonn("result", 0) . ",";
      echo jsons("message", "Not registered");
      echo "}";
      return;
   }
   $row = $obj->fetch();
   echo "{";
   echo jsonn("result", 1) . ",";
   echo jsons("user_id", $row['user_id']) . ",";
   echo jsons("checked_in", $row['checked_in']) . ",";
   echo jsonn("ticket", $row['ticket']) . ",";
   echo jsons("message", "You are already registerd for this event. Here is your ticket.");
   echo "}";
   return;
}

function get_meetings() {
   include_once './classes/meetings_class.php';

//   $prof_id = get_datan("prof_id");

   $schools_obj = new meetings_class();
   if (!$schools_obj->get_all_meetings()) {
      echo "{";
      echo jsonn("result", 0) . ",";
      echo jsons("message", "No meeting found");
      echo "}";
      return;
   }
   $row = $schools_obj->fetch();
   if (!$row) {

      echo "{";
      echo jsonn("result", 0) . ",";
      echo jsons("message", "No meeting found1d");
      echo "}";
      return;
   } else {
      echo "{";
      echo jsonn("result", 1);
      echo ',"meetings":';
      echo "[";

      while ($row) {
         echo "{";
         echo jsons("meeting_id", $row["meeting_id"]) . ",";
         echo jsons("title", $row["title"]) . ",";
         echo jsons("start_time", $row["start_time"]) . ",";
         echo jsons("end_time", $row["end_time"]) . ",";
         echo jsons("venue", $row["venue"]) . ",";
         echo jsons("date", $row["date"]);
         echo "}";

         $row = $schools_obj->fetch();
         if ($row) {
            echo ",";
         }
      }
      echo "]}";
   }
}
