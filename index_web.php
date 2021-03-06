<!DOCTYPE html>
<html>
   <head>
      <title></title>
      <script src="js_web/jquery-1.11.1.min.js"></script>
      <link rel="stylesheet" href="css_web/jquery.mobile-1.4.4.css">
      <script src="js_web/jquery.mobile-1.4.4.min.js"></script>
      <script src="js_web/jquery.qrcode.min.js" type="text/javascript"></script>
      <script src="js_web/qrcode.js" type="text/javascript"></script>

      <link rel="stylesheet" href="css_web/delcss.css">
      <link rel="stylesheet" href="css_web/images/ajax-loader.gif">
      <meta name="viewport" content="width-device-width, initial-scale=1">
   </head>
   <body>
      <!-- ---------------------------------------------------- -->
      <div data-role="page" id="login_page" data-theme="b">
         <div data-role="header">
            <h1>Login</h1>
         </div>
         <!-- ---------------------------------------------------- -->
         <div role="main" class="ui-content">
            <p>Please Login</p>

            <div data-role="fieldcontain">
               <label for="username"> Email:</label>
               <input type="text" name="username" id="username" placeholder="email@domain.com">
               <div> &nbsp; </div>
               <label for="password"> Password:</label>
               <input type="password" name="password" id="password" placeholder="* * * * * * * * * *">
               <div> &nbsp; </div><label></label>

               <input type="submit" id="login" value="Login" onclick="login()">
               <div> &nbsp; </div><label></label>
               <a href="#register_page" data-transition="slidedown">Register?</a>
            </div>
            <!--</form>-->
         </div>
         <!-------------------------------------------------------->
         <div data-role="footer">
            <h1>Del Works</h1>
         </div>
         <!--<a href="#pageone" data-transition="pop">Slide to Page</a>-->
      </div>
      <!----------------------------------------------------------------------------------------------------------------->
      <div data-role="page" id="register_page" data-theme="b">
         <div data-role="header">
            <h1>Register</h1>
         </div>
         <!-------------------------------------------------------->
         <div role="main" class="ui-content">
            <p>Please Register</p>

            <div data-role="fieldcontain">
               <label for="firstname">First Name</label>
               <input type="text" name="firstname" id="firstname" placeholder="first name">
               <div> &nbsp; </div>

               <label for="lastname"> Last Name:</label>
               <input type="text" name="lastname" id="lastname" placeholder="last name">
               <div> &nbsp; </div>

               <label for="email"> Email:</label>
               <input type="text" name="email" id="email" placeholder="email@domain.com">
               <div> &nbsp; </div>

               <label for="password1"> Password:</label>
               <input type="password" name="password1" id="password1" placeholder="* * * * * * * * * *">
               <div> &nbsp; </div>

               <label for="password2"> Confirm Password:</label>
               <input type="password" name="password2" id="password2" placeholder="* * * * * * * * * *">
               <div> &nbsp; </div>

               <label for="org"> Organization:</label>
               <input type="text" name="org" id="org" placeholder="Food & Agricultural Organization">
               <div> &nbsp; </div>

               <label for="phone"> Phone Number:</label>
               <input type="text" name="phone" id="phone" placeholder="233244813169">
               <div> &nbsp; </div><label></label>

               <input type="submit" id="register" value="Register" onclick="register()">
               <div> &nbsp; </div><label></label>
               <a href="#login_page" data-transition="slideup">Login</a>
            </div>
            <!--</form>-->
         </div>
         <!-------------------------------------------------------->
         <div data-role="footer">
            <h1>Del Works</h1>
         </div>
         <!--<a href="#pageone" data-transition="pop">Slide to Page</a>-->
      </div>
      <!----------------------------------------------------------------------------------------------------------------->
      <div data-role="page" id="meetings_page" data-theme="b">
         <div data-role="header">
            <h1>Meetings</h1>
            <a href="#pageone" data-role="button" data-icon="" data-iconpos="right" class="ui-btn-left">Hi there <div class="user"></div></a>
            <a href="#pageone" data-role="button" data-icon="arrow-u" data-iconpos="right" class="ui-btn-right"  onclick="logout()">Logout</a>
            <div data-role="navbar"> 
               <ul>

                  <li><a href="#meetings_page" data-icon="home" data-iconpos="left" data-transition="pop"  class="ui-btn-active ui-state-persist" onclick='get_meetings()'> View Meetings</a></li>
                  <li><a href="#ticket" data-icon="arrow-d" data-iconpos="left" data-transition="slideup"> Ticket</a></li>
               </ul>
            </div>
            <!--classs="ui-btn-active ui-state-persist"-->
         </div>
         <!----------------------------------------------------------->
         <div role="main" class="ui-content">
            <h1> The Meetings</h1>

            <div data-role="" id="ass_list">
               <fieldset data-role="controlgroup">
                  <h4> Meetings:</h4>
                  <ol data-role="listview" data-inset="true" data-filter="true" id="assignments">
                     <li>
                        <a href='#' onclick='get_meetings()'>template</a>
                     </li>
                  </ol>
               </fieldset>
            </div>
         </div>
         <!------------------------------------------------------------->
         <div data-role="footer">
            <div data-role="controlgroup" data-type="horizontal">
               <!--<Caption of group:</p>-->
               <a href="#" data-icon="arrow-l"  data-role="button" data-rel="back">Go Back</a>
            </div>
         </div>
      </div>
      <!----------------------------------------------------------------------------------------------------------------->
      <div data-role="page" id="ticket" data-theme="b">
         <div data-role="header">
            <h1>Meetings</h1>
            <a href="#pageone" data-role="button" data-icon="" data-iconpos="right" class="ui-btn-left">Hi there <div class="user"></div></a>
            <a href="#pageone" data-role="button" data-icon="arrow-u" data-iconpos="right" class="ui-btn-right"  onclick="logout()">Logout</a>
            <div data-role="navbar"> 
               <ul>

                  <li><a href="#meetings_page" data-icon="home" data-iconpos="left" data-transition="pop" onclick='get_meetings()'>View Meetings</a></li>
                  <li><a href="#ticket" data-icon="arrow-d" data-iconpos="left" data-transition="slideup"  class="ui-btn-active ui-state-persist">Ticket</a></li>
               </ul>
            </div>
         </div>
         <!----------------------------------------------------------->
         <div role="main" class="ui-content">
            <h1> Your Ticket</h1>
            <div id="qrcode"></div>
         </div>
         <!------------------------------------------------------------->
         <div data-role="footer">
            <div data-role="controlgroup" data-type="horizontal">
               <a href="#" data-icon="arrow-l"  data-role="button" data-rel="back">Go Back</a>
            </div>
         </div>
      </div>
      <!----------------------------------------------------------->

   </body>
   <script src="js_web/methods2.js"></script>
</html>