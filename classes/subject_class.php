<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once("adb.php");

class subject_class extends adb {

   function subject_class() {
      adb::adb();
   }

   /**
    * query all religion in the table and store the dataset in $this->result	
    * @return if successful true else false
    */
   function get_all_details() {
      $query = "select * from mw_hw_tracker_subject";
      $res = $this->query($query);
//        print("--------------------------------------------------------------------------------");
//        print($res);
      return $res;
   }

   
   /**
    * get the children (students) of this parent
    * @return if successful true else false
    */
   function get_children($parent_id) {
      $query = "select * from mw_hw_tracker_student where parent_id = $parent_id";
      $res = $this->query($query);
//        print("--------------------------------------------------------------------------------");
//        print($query);
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
