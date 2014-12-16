<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once("adb.php");

class user_class extends adb {

   function user_class() {
      adb::adb();
   }

   /**
    * query all religion in the table and store the dataset in $this->result	
    * @return if successful true else false
    */
   function get_all_details() {
      $query = "select * from mw_delegator_user";
      $res = $this->query($query);
//        print("--------------------------------------------------------------------------------");
//        print($res);
      return $res;
   }

   /**
    * get the children (students) of this parent
    * @return if successful true else false
    */
   function get_conf($user_id) {
      $query = "select count(*) as c mw_delegator_user from mw_delegator_user where user_id = $user_id";
      $this->query($query);
      $result = $this->fetch();
      if ($result['c'] > 0) {
         return true;
      } else {
         return false;
      }
   }

   function set_conf($user_id) {
      $query = "update mw_delegator_user set confirmed=1 where user_id = $user_id";
//      print($query);
      $res = $this->query($query);
//        print("--------------------------------------------------------------------------------");
//        
      return $res;
   }

   function add_user_android($first, $last, $email, $pass, $org, $phone) {
      //write the SQL query and call $this->query()
      $query = "insert into mw_delegator_user(firstname, lastname, email, password, organization, phone_number, confirmation_num, confirmed) values('$first', '$last', '$email', '$pass', '$org', '$phone', 0000, 1)";
//        print $query;
//        print mysql_error();
      return $this->query($query);
   }
   
   function add_user($first, $last, $email, $pass, $org, $phone, $conf) {
      //write the SQL query and call $this->query()
      $query = "insert into mw_delegator_user(firstname, lastname, email, password, organization, phone_number, confirmation_num, confirmed) values('$first', '$last', '$email', '$pass', '$org', '$phone', $conf, 0)";
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
