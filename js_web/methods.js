// created because database structure changed the last minute
var global_drop_off = 0;

// $_SESSION['username'] = $username;
//      $_SESSION['role_id'] = $result['role_role_id'];
//      $_SESSION['amount_left'] = $result['amount_left'];
//      $_SESSION['id'] = $result['user_id'];

var user_id = 0;
var user_name = 0;
var user_role_id = 0;
var amount_left = 0;
//      alert(amount_left);


var seats_left = 0;
var res_seats = 0;
var pass_on_bus = 0;
var num_of_seats = 0;

$(document).ready(function () {
//   var amount_left = $('#amount_left').text();
//   alert(amount_left);
//   login();
});


function syncAjax(u) {
   var obj = $.ajax({url: u, async: false});
   return $.parseJSON(obj.responseText);
}


var id = 0;

function publish_ass() {

   $(function () {
      $("input[name*=radio-choice-2]:checked").each(function () {
         school_id = $(this).val();
//         alert("school " + school_id);
      });
   });

   $(function () {
      $("input[name*=radio-choice-3]:checked").each(function () {
         class_id = $(this).val();
//         alert("class " + class_id);
      });
   });

   $(function () {
      $("input[name*=radio-choice-4]:checked").each(function () {
         subject_id = $(this).val();
//         alert("subject " + subject_id);
      });
   });


   var date1 = $("#due_date").val();
   var date2 = new Date(date1);
   var date = getFormattedDate(date2);

   var ass = $("#actual_ass").val();

//   alert(id);
//   alert(ass);

   if (date === null) {
      alert("please select a data");
      return;
   }

   var u = "action_1.php?cmd=3&school_id=" + school_id + "&class_id=" + class_id + "&subject_id=" + subject_id + "&date=" + date + "&teacher_id=" + id + "&ass=" + ass;

//   prompt("URL", u);

   r = syncAjax(u);

   if (r.result === 1) {
      alert("Added Assignment");
   }
   else {
      alert("Could not add");
      return;
   }

   // if it added 

   // send message

   var u = "action_1.php?cmd=4" + "&date=" + date + "&teacher_id=" + id;
   r = syncAjax(u);

   if (r.result === 1) {
      alert("Message send");
   }
   else {
      alert("Could not send");
   }
}

function getFormattedDate(date) {
   var year = date.getFullYear();
   var month = (1 + date.getMonth()).toString();
   month = month.length > 1 ? month : '0' + month;
   var day = date.getDate().toString();
   day = day.length > 1 ? day : '0' + day;
   return year + '-' + month + '-' + day;
}

function logout() {
   window.open("logout.php", "_self");
}

function register() {
   var pass1 = document.getElementById("password1").value;
   var pass2 = document.getElementById("password2").value;

   if (pass1 !== pass2) {
      alert("Your passwords don't match. Please try again");
      return;
   }

   var fname = document.getElementById("firstname").value;

   var lname = document.getElementById("lastname").value;
   var email = document.getElementById("email").value;
   var pass = pass1;
   var org = document.getElementById("org").value;
   var phone_num = document.getElementById("phone").value;
   phone_num = phone_num.replace("+", "");
//   if (phone_num.indexOf(0) === "0") {
//      phone_num = phone_num.replace("+", "");
//   }

   if (fname.length === 0) {
      alert("Please enter your firstname");
      return;
   }
   else if (lname.length === 0) {
      alert("Please enter your lastname");
      return;
   }
   else if (email.length === 0) {
      alert("Please enter your email");
      return;
   }
   else if (pass.length === 0) {
      alert("Please enter a password");
      return;
   }
   else if (org.length === 0) {
      alert("Please enter an organization");
      return;
   } else if (phone_num.length === 0) {
      alert("Please enter a phone number");
      return;
   }

   var conf_num = Math.floor(Math.random() * 9000) + 1000;



   var url = "action_1.php?cmd=1&firstname=" + fname + "&lastname=" + lname + "&email=" + email + "&password=" + pass + "&org=" + org + "&phone_num=" + phone_num + "&conf=" + conf_num;

//   prompt("url", url);

   var r = syncAjax(url);
   if (r.result === 0) {
      alert(r.message);
      return;
   }

   id = r.id;

   var url_send_msg = "action_1.php?cmd=4&conf=" + conf_num + "&phone_num=" + phone_num;
//   prompt("url", url_send_msg);
//   debugger;
   try {
      var sms = syncAjax(url_send_msg);
   }
   catch (err) {

   }
//   aler
//   if(sms.result === 0){
//      alert(r.message);
//      return;
//   }
//   alert(conf_num);
   var verification = prompt(r.message + ". Please enter verification number sent to your below to complete the process", "");

//   alert(verification);
//   alert(conf_num);

   if (verification != conf_num) {
      verification = prompt(r.message + ". Please enter verification number sent to your below to complete the process. Attempt 2", "");
   }

   if (verification != conf_num) {
      alert("You have to register again");
      return;
   }

   // confirm person
   var url_confirm = "action_1.php?cmd=3&id=" + id;
//   prompt("d", url_confirm);
   var con = syncAjax(url_confirm);

   window.open("index_web.php#login_page", "_self");
}

//function pleaseEnter(text)

function login() {

   //complete the url
   var user = document.getElementById("username").value;
   var pass = document.getElementById("password").value;

   var u = "action_1.php?cmd=2&user=" + user + "&pass=" + pass;
//   prompt("URL", u);
   r = syncAjax(u);

//   prompt(r.user);

//                alert(r.result);
   if (r.result === 1) {
      username = r.user.username;
      t_firstname = r.user.firstname;
      t_lastname = r.user.lastname;
      id = r.user.id;

      $(".user").text(t_firstname);

      get_meetings();

      window.open("index_web.php#meetings_page", "_self");
   }
   else {
      alert("username or password wrong\nOr lease register");
      return;
   }
}


function get_meetings() {

   var url = "action_1.php?cmd=8";

//   prompt("url", url);
   var assigns = syncAjax(url);

   if (assigns.result === 1) {
//      console.log(assigns);
      ins4 = "";
      $.each(assigns.meetings, function (key, elem) {

//         console.log(elem.actual_assignment);
         var actual = elem.title;

         actual = actual.replace(/["']/g, "!apostrophe!");
//         debugger;
         ins4 += '<li class="ui-first-child ui-last-child"><a href="#" onclick="popUp(' + elem.meeting_id + ',' + "'Title: " + actual + "\\nVenue: " + elem.venue + "\\nDate: " + elem.date + "\\nStart Time: " + elem.start_time + "\\nEnd Time: " + elem.end_time + "'" + ')" class="ui-btn ui-btn-icon-right ui-icon-carat-r ui-last-child">' + actual + '</a></li>';
      });
      $('#assignments').html(ins4);
   }
}

function popUp(meeting_id, text) {

   // if already registered for meeting
   var url5 = "action_1.php?cmd=6&user_id=" + id + "&meeting_id=" + meeting_id;
//      prompt("u", url1);
//      debugger;
   var r5 = syncAjax(url5);
//   debugger;
//      already registered
   if (r5.result === 1) {
      //get details
      var url1 = "action_1.php?cmd=7&user_id=" + id + "&meeting_id=" + meeting_id;
      var r1 = syncAjax(url1);

      // get ticket

//      debugger;
      alert(r1.message + "\n" + text);
      getTicket(meeting_id);

      return;
   }


   var reg = prompt(text.replace("!apostrophe!", "'") + "\nRegister for event? y / n", "y");

   if (reg === 'y') {

      var url1 = "action_1.php?cmd=6&user_id=" + id + "&meeting_id=" + meeting_id;
//      prompt("u", url1);
//      debugger;
      var r1 = syncAjax(url1);
//debugger;
//      already registered
      if (r1.result === 1) {
         // get ticket
         alert(r1.message);
         getTicket(meeting_id);

         return;
      }


// register
      var code = Math.floor(Math.random() * 900000) + 100000;
      var url = "action_1.php?cmd=5&user_id=" + id + "&meeting_id=" + meeting_id + "&code=" + code;

//      prompt("url", url);
      var r = syncAjax(url);

      getTicket(meeting_id);

      alert(r.message);
   }
}

function getTicket(meeting_id) {
   var url2 = "action_1.php?cmd=7&user_id=" + id + "&meeting_id=" + meeting_id;

   var r2 = syncAjax(url2);

   var ticket = r2.ticket;
   qrgenerate(ticket);

   window.open("index_web.php#ticket", '_self');
}

function qrgenerate(rand) {
   $('#qrcode').text(rand);
   jQuery('#qrcode').qrcode({
      text: rand.toString()
   });
}

function payment() {

//   alert("here");
//   $("#status").text("NOT PAID");
   var fare = $("#fare").val();
   var amount_before = amount_left;
   if (amount_before - $("#fare").val() >= 0) {
      var new_amount = amount_before - $("#fare").val();

      var ticket = Math.floor((Math.random() * 1000) + 1);
//      alert(ticket);

      var url = "login_mobile_action_1.php?cmd=3&user_id=" + user_id + "&new_amount=" + new_amount + "&amount_before=" + amount_before + "&fare=" + $("#fare").val() + "&ticket_num=" + ticket + "&location=" + global_drop_off;
      prompt("url", url);
      r = syncAjax(url);
//      prompt("url", r.result);
      if (r.result === 1) { // signifies update
         alert("Your ticket is available in another tab. Go to payment to view");
//         $("#status").text("PAID");
//         qrgenerate(ticket);
         window.open("mobile_and_passenger.php#view_payment", "_self");
         window.location.reload();
//         window.open("mobile_and_passenger.php#view_payment", "_self");

//         window.reload("mobile_and_passenger.php#view_payment");
//         window.location.href="mobile_and_passenger.php#view_payment";
         global_drop_off = 0;
      }
      else if (r.result === 0 && r.trans.message === "Already Reserved") {
         alert("You have " + r.trans.message);
//         alert(r.trans.ticket_num);
//         $("#status").text("PAID");
//         qrgenerate(r.trans.ticket_num);
         window.open("mobile_and_passenger.php#view_payment", "_self");
//         global_drop_off = 0;
      }
      else {
         alert(r.trans.message);
         alert("unsuccessful");
         global_drop_off = 0;
         return;
      }
   }
   else {
      alert("unsuccessful, not enough funds, you broke");
      global_drop_off = 0;
   }
}

var x = document.getElementById("demo");

function getLocation() {
//   console.log("called");
   if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(showPosition, showError);
   } else {
      x.innerHTML = "Geolocation is not supported by this browser.";
   }
}

function getLocationBus() {
//   console.log("called");
//   if (navigator.geolocation) {
   navigator.geolocation.getCurrentPosition(showPositionBus, showError);
//   } else {
//      x.innerHTML = "Geolocation is not supported by this browser.";
//   }
}

function showPositionBus(position) {

   var url = "login_mobile_action_1.php?cmd=5";
//      prompt("url", url);
   r = syncAjax(url);

   if (r.result === 0) {
      alert(r.message);
      return;
   }

   var a = r.x;
   var b = r.y;

//   alert (a);

   x.innerHTML = "Latitude: " + b +
           "<br>Longitude: " + a;

   showBus(a, b);

}
var gloA = 0;
var gloB = 0;
function showBus(a, b) {
//   debugger;
   gloA = a;
   gloB = b;
   window.open("map.php", "_self");
   /*
    * Google Maps documentation: http://code.google.com/apis/maps/documentation/javascript/basics.html
    * Geolocation documentation: http://dev.w3.org/geo/api/spec-source.html
    */

}

function showPosition(position) {

   x.innerHTML = "Latitude: " + position.coords.latitude +
           "<br>Longitude: " + position.coords.longitude;

//           update database
   var url = "login_mobile_action_1.php?cmd=4&long=" + position.coords.longitude + "&lat=" + position.coords.latitude;
//      prompt("url", url);
   r = syncAjax(url);

   if (r.result === 0) {
      alert(r.message);
   }



   var latlon = position.coords.latitude + "," + position.coords.longitude;

   var img_url = "http://maps.googleapis.com/maps/api/staticmap?center="
           + latlon + "&zoom=14&size=400x300&sensor=false";
   document.getElementById("mapholder").innerHTML = "<img src='" + img_url + "'>";
}

function showError(error) {
   switch (error.code) {
      case error.PERMISSION_DENIED:
         x.innerHTML = "User denied the request for Geolocation.";
         break;
      case error.POSITION_UNAVAILABLE:
         x.innerHTML = "Location information is unavailable.";
         break;
      case error.TIMEOUT:
         x.innerHTML = "The request to get user location timed out.";
         break;
      case error.UNKNOWN_ERROR:
         x.innerHTML = "An unknown error occurred.";
         break;
   }
}

function callEveryHour() {
//   setTimeout(getLocation, 5000);
//   setInterval(getLocation(), 5000);
   getLocation();
//   console.log("called");
//   alert("called");
}



$(document).on("pagecreate", "#map-page", function () {
   var defaultLatLng = new google.maps.LatLng(gloA, gloB);  // Default to Hollywood, CA when no geolocation support
//   debugger;
   if (navigator.geolocation) {

      function success(pos) {
         // Location found, show map with these coordinates
         drawMap(new google.maps.LatLng(pos.coords.latitude, pos.coords.longitude));
//            alert(b);
      }
      function fail(error) {
         drawMap(defaultLatLng);  // Failed to find location, show default map
      }
      // Find the users current position.  Cache the location for 5 minutes, timeout after 6 seconds
      navigator.geolocation.getCurrentPosition(success, fail, {maximumAge: 500000, enableHighAccuracy: true, timeout: 6000});
   } else {
      drawMap(defaultLatLng);  // No geolocation support, show default map
   }
   function drawMap(latlng) {

      var myOptions = {
         zoom: 16,
         center: latlng,
         mapTypeId: google.maps.MapTypeId.ROADMAP
      };
      var map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);
      // Add an overlay to the map of current lat/lng
      var marker = new google.maps.Marker({
         position: latlng,
         map: map,
         title: "Bus is here!"
      });
   }
});