<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
	  <meta charset="utf-8"/>
	  <link rel="stylesheet" type="text/css" href="css/style.css"/>
          <script language="JavaScript" type="text/javascript" src="inc/js/jquery-1.3.2.min.js"></script> 
	  <script language="JavaScript" type="text/javascript" src="inc/js/jquery-ui-1.7.2.custom.min.js"></script>

          <script language="JavaScript" type="text/javascript" src="inc/js/jquery.form.js"></script>
          <script language="JavaScript" type="text/javascript" src="inc/js/jquery.validate.js"></script>
          <script language="JavaScript" type="text/javascript" src="inc/js/additional-methods.js"></script>
          <script language="JavaScript" type="text/javascript" src="inc/js/loginModal.js"></script>
	  <script type="text/javascript" src="js/script.js"></script>
          <script type="text/javascript">
		<?php
		$loginout = isset($_SESSION['userid']) ? "true" : "false";
		echo "var loggedIn = $loginout;";
		?>
	  </script> 	
          <link type="text/css" href="inc/css/ui-lightness/jquery-ui-1.7.2.custom.css" rel="stylesheet" />
          <link type="text/css" href="inc/css/generic-base.css" rel="stylesheet" />

	  <title>Mario & Lugi's Pizza Palace</title>
	</head>

	<body id="body">
	 <div id="wrapper">
	   
	  <div id="logo">
		<span>
		<img src="images/mariomushroom.png" rel="Mario Mushroom" />
			<div id="logoText">Mario and Lugi's Pizza Palace</div>
		<img src="images/mariomushroom.png" rel="Mario Mushroom" />
	  	</span>
	  </div>
	  <div class="clear"></div>
	  <div id="nav">
	        <ul>
                  <li onClick="getMenu();">Menu</li>
                  <li onClick="getOrder();">Order</li>
                  <li onClick="getAbout();">About</li>
		</ul>

	   </div><!--end nav -->
	  <div class="clear"></div>
	  <?php
			$loginout = isset($_SESSION['userid']) ? "Logout" : "Login";
	  ?>
	  <div class="login" id="login"><?php echo $loginout; ?></div>

          <!-- =========== Login Container Stuff ========================= -->

          <!--  generic container -->
          <div class="login-container">

	      <!--  our return message block -->
	      <div class="ui-widget ui-helper-hidden" style="width: 50%; margin: 0 auto; text-align: center;" id="client-script-return-msg"></div>

	      <!--  our return target block -->
	      <div id="client-script-return-data"></div>

	      <!--  our modal window -->
	      <div id="my-modal-form" title="Login / Registration"></div>

	      <!--  our modal registration window -->
	      <div id="my-modal-registration-form" title="Registration"></div>

          </div>

          <!-- =========================================================== -->

	  <div class="clear"></div>
	  <hr style="background-color: black; color: black;" />
	   <div id="content">
		<?php
			include('about.php');
		?>	
	  </div> <!--end content -->
	 </div> <!--end wrapper -->
	</body>


</html>
