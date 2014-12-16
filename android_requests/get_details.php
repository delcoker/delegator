<?php

include_once '../classes/user_has_meetings_class.php';
include_once '../classes/meetings_class.php';
include_once '../classes/user_class.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


if ((isset($_REQUEST["get_events"]))) {
   $del_obj = new meetings_class();
   if ($del_obj->get_all_meetings()) {
      $dataset = $del_obj->fetch();

      while ($dataset) {
         print ($dataset['meeting_id']);
         print "#";
         print $dataset["title"];
         print "#,";

         $dataset = $del_obj->fetch();
      }
   }
}

// get children (students) that belong to parent
else if (isset($_REQUEST["check_in_delelegate"])) {
   $meeting_id = ($_REQUEST["meeting_id"]);
   $delegate_id = ($_REQUEST["delegate_id"]);
   $del_obj = new user_has_meetings_class();
   if ($del_obj->check_in_delegate($meeting_id, $delegate_id)) {

      print true;
   } else {
      print false;
   }
} 
// get children (students) that belong to parent
else if (isset($_REQUEST["get_total"])) {
   $meeting_id = ($_REQUEST["get_total"]);
   $del_obj = new user_has_meetings_class();
   if ($del_obj->get_count($meeting_id)) {
      $row = $del_obj->fetch();
      print $row["total"];
   } else {
      print 0;
   }
} 
else if (isset($_REQUEST["add_user_android"])) {
   $first = ($_REQUEST["first"]);
   $last = ($_REQUEST["last"]);
   $email = ($_REQUEST["email"]);
   $pass = ($_REQUEST["password"]);
   $org = ($_REQUEST["organization"]);
   $phone = ($_REQUEST["phone"]);
   $meeting_id = $_REQUEST["meeting_id"];
   $ticket = $_REQUEST["ticket"];
   $del_obj = new user_class();
   if ($del_obj->add_user_android($first, $last, $email, $pass, $org, $phone)) {
      $user_id = $del_obj->get_insert_id();
      $reg_for_meet = new user_has_meetings_class();
      if(!$reg_for_meet->reg_for_meeting($user_id, $meeting_id, $ticket)){
         print false;
         return;
      }

      print true;
   } else {
      print false;
   }
} 
else if ((isset($_REQUEST["get_delegates"]))) {
   $meeting_id = $_REQUEST["meeting_id"];
   $del_obj = new user_has_meetings_class();
   if ($del_obj->get_all_details($meeting_id)) {
      $dataset = $del_obj->fetch();

      while ($dataset) {
         print ($dataset['user_id']);
         print "#";
         print $dataset["firstname"] . " " . $dataset["lastname"];

         print "#";
         print $dataset["meeting_id"];

         print "#";
         print $dataset["checked_in"];
         print "#";
         print $dataset["ticket"];
         print "#,";

         $dataset = $del_obj->fetch();
      }
   }
} else if (isset($_REQUEST["scan_checkin"])) {
   $ticket_id = ($_REQUEST["ticket"]);
   $meeting_id = ($_REQUEST["meeting_id"]);
   $del_obj = new user_has_meetings_class();
   if ($del_obj->check_in_delegate_with_ticket($meeting_id, $ticket_id)) {

      print true;
   } else {
      print false;
   }
} else if (isset($_REQUEST["get_del"])) {
   $ticket_id = ($_REQUEST["ticket"]);
   $meeting_id = ($_REQUEST["meeting_id"]);
   $del_obj = new user_has_meetings_class();
   if ($del_obj->get_delegate_with_ticket($meeting_id, $ticket_id)) {
      $dataset = $del_obj->fetch();

//      while ($dataset) {
//         print ($dataset['user_id']);
//         print "#";
         print $dataset["firstname"] . " " . $dataset["lastname"];

//         print "#";
//         print $dataset["meeting_id"];
//
//         print "#";
//         print $dataset["checked_in"];
//         print "#";
//         print $dataset["ticket"];
//         print "#,";

//         $dataset = $del_obj->fetch();
//      }
   }
} else // get assignment due tomorrow
if (isset($_REQUEST["pid2"]) && isset($_REQUEST["cid"]) && isset($_REQUEST["date"])) {
   $pid = ($_REQUEST["pid2"]);
   $cid = ($_REQUEST["cid"]);
   $date = ($_REQUEST["date"]);

   $hw_obj = new given_hw_class();
   if ($hw_obj->get_details_w_parent_due_tomorrow($pid, $cid, $date)) {
      $dataset_hw = $hw_obj->fetch();
//      print_r($dataset_children);
      while ($dataset_hw) {
         print $dataset_hw["subject_name"];
         print "#";
         print $dataset_hw["assignment_title"];
         print "#";
         print $dataset_hw["date_due"];
         print "#,";
//         print $dataset_children["firstname"] . " " . $dataset_children["lastname"];
//         print "here";
         $dataset_hw = $hw_obj->fetch();
      }
   } else {
      print false;
   }
} // get assingments due the week
else if (isset($_REQUEST["pid3"]) && isset($_REQUEST["cid"]) && isset($_REQUEST["date"])) {
   $pid = ($_REQUEST["pid3"]);
   $cid = ($_REQUEST["cid"]);
   $date = ($_REQUEST["date"]);

   $hw_obj = new given_hw_class();
   if ($hw_obj->get_details_w_parent_due_week($pid, $cid, $date)) {
      $dataset_hw = $hw_obj->fetch();
//      print_r($dataset_children);
      while ($dataset_hw) {
         print $dataset_hw["subject_name"];
         print "#";
         print $dataset_hw["assignment_title"];
         print "#";
         print $dataset_hw["date_due"];
         print "#,";
//         print $dataset_children["firstname"] . " " . $dataset_children["lastname"];
//         print "here";
         $dataset_hw = $hw_obj->fetch();
      }
   } else {
      print false;
   }
} else if (isset($_REQUEST["item"]) && isset($_REQUEST["amount"]) && isset($_REQUEST["date"])) {
   $item = $_REQUEST["item"];
   $amount = $_REQUEST["amount"];
   $date = $_REQUEST["date"];
   $amount_left = $_REQUEST["amount_left"];
   $amount_start = $_REQUEST["amount_start"];


   $query = "insert into mw_susu_exp (item, date_spent, amount_spent, amount_left, amount_start) values ('$item', '$date', '$amount', '$amount_left', '$amount_start')";
   if (mysql_query($query, $link)) {
      print "true";

      $url = "https://api.smsgh.com/v3/messages/send?"
              . "From=%2B233244813169"
              . "&To=%2B233502128010"
              . "&Content=You+spent+$amount+on+$item+on+$date"
              . "&ClientId=odfbifrp"
              . "&ClientSecret=rktegnml"
              . "&RegisteredDelivery=true";
      // Fire the request and wait for the response
      $response = file_get_contents($url);
      var_dump($response);
   } else {
      print "false";
   }
}
// retrieving expenditures
else if (isset($_REQUEST["getall"])) {
   $query = mysql_query("select * from mw_susu_exp ORDER BY item", $link);
   $queryData = mysql_fetch_assoc($query);
   $queryResult = "";
   $queryArray = Array();

   while ($queryData) {
      $queryId = $queryData["susu_exp_id"];
      $queryItem = $queryData["item"];
      // $queryDate = $queryData["date_spent"];
      $querySpent = $queryData["amount_spent"];
      // $queryLeft = $queryData["amount_left"];

      print ("$queryId" . "#");
      print ("$queryItem" . "#");
      print ("$querySpent" . "#,");

      $queryData = mysql_fetch_assoc($query);
   }

   // print json_encode($queryArray);
}
