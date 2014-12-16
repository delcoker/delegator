<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once("adb.php");

class meetings_class extends adb {

   function meetings_class() {
      adb::adb();
   }
   
   function reg_for_meeting($user_id, $meeting_id){
      $query = "insert into from mw_user_has_meeting(user_id, meeting_id, checked_id)values($user_id, $meeting_id, 0)";
      $res = $this->query($query);
//        print("--------------------------------------------------------------------------------");
//        print($res);
      return $res;
   }
   
   function get_all_meetings(){
       $query = "select * from mw_delegator_meeting";
      $res = $this->query($query);
//        print("--------------------------------------------------------------------------------");
//        print($res);
      return $res;
   }

   function get_all_assignments_by_prof($prof_id) {
      $query = "SELECT * 
FROM mw_hw_tracker_given_hw
LEFT JOIN mw_hw_tracker_subject ON mw_hw_tracker_given_hw.subject_subject_id = mw_hw_tracker_subject.subject_id
LEFT JOIN mw_hw_tracker_assignment ON mw_hw_tracker_given_hw.assignment_assignment_id = mw_hw_tracker_assignment.assignment_id left join mw_hw_tracker_class on mw_hw_tracker_given_hw.class_class_id = mw_hw_tracker_class.class_id
WHERE mw_hw_tracker_given_hw.teacher_teacher_id  = $prof_id order by date_due desc";
//      print $query;
      $res = $this->query($query);
//        print("--------------------------------------------------------------------------------");
//        print($res);
      return $res;
   }

   function get_all_details() {
      $query = "select * from mw_hw_tracker_given_hw";
      $res = $this->query($query);
//        print("--------------------------------------------------------------------------------");
//        print($res);
      return $res;
   }

   function get_details_w_parent($parent_id, $class_id) {
      $query = "select * from mw_hw_tracker_given_hw left join mw_hw_tracker_student on mw_hw_tracker_given_hw.school_school_id = mw_hw_tracker_student.school_id left join mw_hw_tracker_assignment on mw_hw_tracker_given_hw.assignment_assignment_id = mw_hw_tracker_assignment.assignment_id left join mw_hw_tracker_subject on mw_hw_tracker_subject.subject_id = mw_hw_tracker_given_hw.subject_subject_id where parent_id = $parent_id and mw_hw_tracker_given_hw.class_class_id = $class_id";
      $res = $this->query($query);
//        print("--------------------------------------------------------------------------------");
//        print($res);
      return $res;
   }

   function get_details_w_parent_assign_today($parent_id, $class_id, $date) {
      $query = "select * from mw_hw_tracker_given_hw left join mw_hw_tracker_student on mw_hw_tracker_given_hw.school_school_id = mw_hw_tracker_student.school_id left join mw_hw_tracker_assignment on mw_hw_tracker_given_hw.assignment_assignment_id = mw_hw_tracker_assignment.assignment_id left join mw_hw_tracker_subject on mw_hw_tracker_subject.subject_id = mw_hw_tracker_given_hw.subject_subject_id where parent_id =  $parent_id and mw_hw_tracker_given_hw.class_class_id = $class_id and '$date' = date_assigned";
      $res = $this->query($query);
//        print("--------------------------------------------------------------------------------");
//        print($res);
      return $res;
   }

   function get_details_w_parent_due_tomorrow($parent_id, $class_id, $date) {
      $query = "select * from mw_hw_tracker_given_hw left join mw_hw_tracker_student on mw_hw_tracker_given_hw.school_school_id = mw_hw_tracker_student.school_id left join mw_hw_tracker_assignment on mw_hw_tracker_given_hw.assignment_assignment_id = mw_hw_tracker_assignment.assignment_id left join mw_hw_tracker_subject on mw_hw_tracker_subject.subject_id = mw_hw_tracker_given_hw.subject_subject_id where parent_id = $parent_id and mw_hw_tracker_given_hw.class_class_id = $class_id and DATE_ADD(date_due, INTERVAL -1 DAY) = '$date'";
//      print$query;
      $res = $this->query($query);
//        print("--------------------------------------------------------------------------------");
//        print($res);
      return $res;
   }

   function get_details_w_parent_due_week($parent_id, $class_id, $date) {
      $query = "select * from mw_hw_tracker_given_hw left join mw_hw_tracker_student on mw_hw_tracker_given_hw.school_school_id = mw_hw_tracker_student.school_id left join mw_hw_tracker_assignment on mw_hw_tracker_given_hw.assignment_assignment_id = mw_hw_tracker_assignment.assignment_id left join mw_hw_tracker_subject on mw_hw_tracker_subject.subject_id = mw_hw_tracker_given_hw.subject_subject_id where parent_id = $parent_id and mw_hw_tracker_given_hw.class_class_id = $class_id and '$date' between DATE_ADD(date_due, INTERVAL -4 DAY) and DATE_ADD(date_due, INTERVAL 3 DAY)";
//      print($query);
      $res = $this->query($query);
//        print("--------------------------------------------------------------------------------");
//        print($res);
      return $res;
   }

   function get_details_w_parent_assigned_week($parent_id, $class_id, $date) {
      $query = "select * from mw_hw_tracker_given_hw left join mw_hw_tracker_student on mw_hw_tracker_given_hw.school_school_id = mw_hw_tracker_student.school_id left join mw_hw_tracker_assignment on mw_hw_tracker_given_hw.assignment_assignment_id = mw_hw_tracker_assignment.assignment_id left join mw_hw_tracker_subject on mw_hw_tracker_subject.subject_id = mw_hw_tracker_given_hw.subject_subject_id where parent_id = $parent_id and mw_hw_tracker_given_hw.class_class_id = $class_id and '$date' between date_assigned-4 and date_assigned+3";
      $res = $this->query($query);
//        print("--------------------------------------------------------------------------------");
//        print($res);
      return $res;
   }

   function add_info($seatsLeft, $numOfPssngrsReserved, $numOfSeats, $numOfPssngrsBus, $longitude, $locationAddress, $latitude) {
      //write the SQL query and call $this->query()
      $query = "insert into mw_info(seatsLeft, numOfPssngrsReserved, numOfSeats, numOfPssngrsBus, longitude, locationAddress, latitude, date_modified, date_created) values($seatsLeft, $numOfPssngrsReserved, $numOfSeats, $numOfPssngrsBus, $longitude, '$locationAddress', $latitude, now(), now())";
//        print $query;
//        print mysql_error();
      return $this->query($query);
   }

   /**
    * updates the record identified by id 
    */
   function update_info($info_id, $seatsLeft, $numOfPssngrsReserved, $numOfSeats, $numOfPssngrsBus, $longitude, $locationAddress, $latitude) {
      //write the SQL query and call $this->query()
      $query = "Update mw_info set seatsLeft = $seatsLeft
                                    ,   numOfPssngrsReserved = $numOfPssngrsReserved
                                    ,   numOfSeats = $numOfSeats
                                    ,   numOfPssngrsBus = $numOfPssngrsBus
                                    ,   longitude = $longitude, 
                                       locationAddress = $locationAddress, latitude = $latitude
                                    ,   date_modified = now()
                                     where  info_id = $info_id";
//        print $query;
//        print mysql_error();
      return $this->query($query);
   }

   function update_location($longitude, $latitude, $info_id) {
      //write the SQL query and call $this->query()
      $query = "Update mw_info set longitude = $longitude, 
                                       latitude = $latitude
                                    ,   date_modified = now()
                                     where  info_id = $info_id";
//        print $query;
//        print mysql_error();
      return $this->query($query);
   }

   function update_pass($seatsLeft, $numOfPssngrsReserved, $numOfPssngrsBus, $info_id) {
      $query = "Update mw_info set numOfPssngrsReserved = $numOfPssngrsReserved,   seatsleft = $seatsLeft
                                    ,   numOfPssngrsBus = $numOfPssngrsBus,   date_modified = now()
                                     where  info_id = $info_id";
//        print $query;
//        print mysql_error();
      return $this->query($query);
   }

   function update_pass_decrease() {
      
   }

}
