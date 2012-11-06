<?php session_start(); ?>

<script type="text/javascript">
    jQuery(function() {
        var stringMsg = "<strong>Success!</strong> This will disappear in 10 seconds."
        $("#client-script-return-msg-rtn").html(stringMsg);
    });
</script>
<!--
// File: loginBackEnd.php
//
// This is the php server side processing associated with the client side
// login/registration modal window.
//
// When a form is submitted, this script checks to see if the street attribute
// has been submitted.  If the street attribute is not submitted then the submission
// is from a login form, if present then it must be a registration form. 
//
// When attempting to login in a database query is made to match the email address
// and the password entered by the user.  If there is a match the user is considered
// to be logged in, if no match a message is displayed saying please try again.
//
// When attempting a registration, a database query is made using the user entered
// email and password to see if the customer already exists.  If the DB entry 
// does exist, the user told that email address is already in use, please try again.
// If the entry does not exist, the registration form data is used to create a row in
// the database containing, first name, last name, email, password, street, city, state
// zip, and phone number.  A message is returned indicating a successful login.
//
-->
<?php

function postStatus($msgToPost) {
?>

<script type="text/javascript">
    jQuery(function() {
        var stringMsg = "<?php echo $msgToPost; ?>"
        $("#client-script-return-msg-rtn").html(stringMsg);
    });
</script>

<?php
}


function doDBQuery($query) {
         // Connect to Class Project Database
         if ( !( $database = mysql_connect(
            "csci7136.db.7591836.hostedresource.com",      // sql server hostname
            "csci7136",                                    // user
            "NEWpass7136" ) ) )                            // password
            die( "Could not connect to database </body></html>" );

         // print("<p> Connection to DBServer Successful.</p>" );

         // open  Class project database
         if ( !mysql_select_db( "csci7136", $database ) )
            die( "Could not open csci7136 database </body></html>" );

         // print("<p> Database Open Successful.</p>" );

         // query Customer  database
         if ( !( $result = mysql_query( $query, $database ) ) )
         {
            // print( "<p>Could not execute query!</p>" );
            die( mysql_error() . "</body></html>" );
         } // end if

         // print( "<p>Query Successful!</p>" );
         // print("<p> Closing Database.</p>" );
         mysql_close( $database );
         return($result);
}

function registerUser() {
         // // print( "<p>registerUser - '$query'</p>" );
         $qStmt = "INSERT INTO Customer (Email, Password, Street, City, State, zip, FName, LName, Phone) VALUES
                 ('$_POST[email]','$_POST[password]','$_POST[street]','$_POST[city]','$_POST[state]', '$_POST[zipcode]','$_POST[firstname]', '$_POST[lastname]', '$_POST[phonenumber]')";
         $dbRegisterResult = doDBQuery($qStmt);
         return($dbRegisterResult);
}

$emailContent = $_POST["email"];
$passwordContent = $_POST["password"];

// Check to see if street input field is set.  If so it must be
// a registration because street is not in the login form.

if ( isset( $_POST["street"] ) ) {
    // print("<p>Registration Form</p>");

     // See if user login already exists.
     // Look for email only.  If it exists, return alread exists.

         // build SELECT query for user entered email.
         $queryStmt = "SELECT  Email FROM Customer WHERE Email='$emailContent' ";
         $dbResult = doDBQuery($queryStmt);
         $numRowsInResult = mysql_num_rows($dbResult);
         if ( $numRowsInResult == 1 ) {   // Found Entry - User by this name already exists.
             // print( "<p>User with email already exists</p>");
             postStatus("<p>User with that email already exists - Try again.</p>");
             die( "User already exists" . "</body></html>" );
         }
         // User does not exist so register this bad boy.
         // print( "<p>User with email does NOT exist!!! Registering User.</p>");
         postStatus("<p>User Registered.</p>");
         $registrationStatus = registerUser();

} else {
    // print("<p>Login Form</p>");

    // Lookup Email and Password
    // If a row is returned then we have a match.
    // No row, no match.. return no matching entry.
    // build SELECT query for user entered email and password.
         $queryStmt = "SELECT id  FROM Customer WHERE Email='$emailContent' AND Password='$passwordContent' ";
         $dbResult = doDBQuery($queryStmt);

         $numRowsInResult = mysql_num_rows($dbResult);
         // print( "<p>Number Rows In Result is $numRowsInResult</p>");
         // print("<p> Closing Database.</p>" );
         //mysql_close( $database ); <-- closed in doDBQuery()

         if ( $numRowsInResult == 1 ) {
             // print("<p>User Logged In, Welcome Back.</p>");
	     $result = mysql_fetch_object($dbResult);
	     $_SESSION['userid'] = $result->id;
             postStatus("<p>User Logged In.</p>");
         } else {
             // print("<p>User NOT found, Please try again or register.</p>");
             postStatus("<p>User NOT Logged In.</p>");
            die( mysql_error() . "</body></html>" );
         }
}
?>

