<?php
     include 'connection.php';
     session_start();
     if(isset($_SESSION['uid']) && $_SESSION['uid'] != "") {
          if($_SESSION['utype'] == "1"){
               echo "<script type='text/javascript'>window.top.location='tickets_alle.php';</script>";
          } else {
               echo "<script type='text/javascript'>window.top.location='tickets_offen.php';</script>";
          }
     }
     function rand_string( $length ) {
          $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
          return substr(str_shuffle($chars),0,$length);
     }
     if(isset($_REQUEST['forgote'])){
          $password = rand_string(6);
          $email = $_REQUEST['email'];
          $checkemail = "SELECT * FROM user_mst WHERE vEmail='".$email."'";
          $emailresult = mysql_query($checkemail);
          if(mysql_num_rows($emailresult) == 0){
               $emsg = "Die E-Mail ist mir nicht bekannt. Bitte erstelle ein Account.";   
          } else {
               $smsg = "Please check email and password.";
               $erow = mysql_fetch_assoc($emailresult);
               $password = base64_encode($password); 
               $upQuery = "UPDATE user_mst SET vPassword='".$password."' WHERE iId='".$erow['iId']."'";
               mysql_query($upQuery);
               $email = $erow['vEmail'];
               $fname = $erow['vFname'];
               $lname = $erow['vLname'];
               $password = base64_decode($password);
               
               $seltamplate = "SELECT * FROM email_template WHERE iId='5'";
               $temresult = mysql_query($seltamplate);
               $template = mysql_fetch_assoc($temresult);
               $msg = $template['tMessage'];
               $msg = str_replace("{benutzername}",$fname." ".$lname,$msg);
               $msg = str_replace("{ticketlogin}",'<a href="http://it.bikearena-benneker.de">Ticketsystem</a>',$msg);
               $msg = str_replace("{benutzeremail}",$email,$msg);      
               $msg = str_replace("{passwort}",$password,$msg);
               $html = '<html lang="en" dir="ltr" style="border: 0 none;font: inherit;margin: 0;padding: 0;vertical-align: baseline;">
                             <head>
                                  <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
                                  <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
                                  <meta content="width=device-width" name="viewport">
                                  
                             </head>
                             <body style="background: #FFFFFF;color: #333333;font-family: Helvetica,Arial,sans-serif;font-size: 14px;line-height: 1.5em;margin: 0;padding: 40px 0;">
                                    '.$msg.'    
                             </body>
                        </html>';
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                // Additional headers
                
                $headers .= 'From: Ticket System <'.$template['vSender'].'>' . "\r\n";
                $sub = $template['vSubject'];
                mail($email, $sub, $html, $headers);
          }
     }
     if(isset($_REQUEST['login_btn']) && $_REQUEST['login_btn'] != ""){
          $email = $_REQUEST['login_name'];
          $pass = $_REQUEST['login_pw'];
          $emsg = "";
          if($email != "" && $pass != ""){
               $pass = base64_encode($pass);
               $checklogin = "SELECT * FROM user_mst WHERE vEmail='".$email."' AND vPassword='".$pass."'";
               $checkloginresult = mysql_query($checklogin);
               if(mysql_num_rows($checkloginresult) == 0){
                    $emsg = "Unzulässige Daten.";
               } else {
                    $row = mysql_fetch_assoc($checkloginresult);
                    $_SESSION['id'] = $row['iId'];
                    $_SESSION['uid'] = $row['iId'];
                    $_SESSION['uname'] = $row['vFname']." ".$row['vLname'];
                    $_SESSION['utype'] = $row['vUserType'];
                    $_SESSION['sucess'] = "Du wurdest erfolgreich angemeldet als ".$_SESSION['uname'];
                    $date = date("Y-m-d H:i:s");
                    $uplogin = "UPDATE user_mst SET dLastLogin='".$date."' WHERE iId='".$row['iId']."'";
                    mysql_query($uplogin);
                    if($row['vUserType'] == "1"){
                         echo "<script type='text/javascript'>window.top.location='tickets_alle.php';</script>";
                    } else {
                         echo "<script type='text/javascript'>window.top.location='tickets_offen.php';</script>";
                    }
               }      
          } else {
               $emsg = "Unzulässige Daten.";
          }
     }
     if(isset($_REQUEST['d2_email']) && $_REQUEST['d2_email'] != ""){
          $fname = $_REQUEST['d2_fname'];
          $lname = $_REQUEST['d2_lname'];    
          $email = $_REQUEST['d2_email'];
          $email1 = $_REQUEST['d2_email1'];
          $pass = $_REQUEST['d2_pass'];
          $pass1 = $_REQUEST['d2_pass1'];
          $checkemail = "SELECT vEmail FROM user_mst WHERE vEmail='".$email."'";
          $emailresult = mysql_query($checkemail);
          $emsg = "";
          $smsg = "";
          if(mysql_num_rows($emailresult) == 0){
               if($email == $email1){
                   if($pass1 == $pass){
                        if($fname != "" && $lname != "" && $email != "" && $pass != ""){
                             $pass = base64_encode($pass);
                             $date = date("Y-m-d H:i:s");
                             $insquery = "INSERT INTO user_mst (`vFname`,`vLname`,`vEmail`,`vPassword`,`vUserType`,`dLastLogin`) VALUES ('".$fname."','".$lname."','".$email."','".$pass."','2','".$date."')";
                             mysql_query($insquery);
                             $seltamplate = "SELECT * FROM email_template WHERE iId='1'";
                             $temresult = mysql_query($seltamplate);
                             $template = mysql_fetch_assoc($temresult);
                             $msg = $template['tMessage'];
                             $msg = str_replace("{benutzername}",$fname." ".$lname,$msg);
                             $msg = str_replace("{ticketlogin}",'<a href="http://it.bikearena-benneker.de">Ticketsystem</a>',$msg);
                             $msg = str_replace("{benutzeremail}",$email,$msg);
                             $html = '<html lang="en" dir="ltr" style="border: 0 none;font: inherit;margin: 0;padding: 0;vertical-align: baseline;">
                                           <head>
                                                <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
                                                <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
                                                <meta content="width=device-width" name="viewport">
                                                
                                           </head>
                                           <body style="background: #FFFFFF;color: #333333;font-family: Helvetica,Arial,sans-serif;font-size: 14px;line-height: 1.5em;margin: 0;padding: 40px 0;">
                                                  '.$msg.'    
                                           </body>
                                      </html>';
                              $headers  = 'MIME-Version: 1.0' . "\r\n";
                              $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                              // Additional headers
                              $headers .= 'From: Ticket System <'.$template['vSender'].'>' . "\r\n";
                              $sub = $template['vSubject'];
                              $sub = str_replace("{benutzername}",$fname." ".$lname,$sub);
                              mail($email, $sub, $html, $headers);
                              
                              $seltamplate1 = "SELECT * FROM email_template WHERE iId='6'";
                              $temresult1 = mysql_query($seltamplate1);
                              $template1 = mysql_fetch_assoc($temresult1);
                              
                              $msg = $template1['tMessage'];
                              $msg = str_replace("{newusername}",$fname." ".$lname,$msg);
                              $msg = str_replace("{neuerbenutzername}",$fname." ".$lname,$msg);
                              $msg = str_replace("{ticketlogin}",'<a href="http://it.bikearena-benneker.de">Ticketystem.</a>',$msg);
                              $msg = str_replace("{neuebenutzeremail}",$email,$msg);
                              $msg = str_replace("{benutzerstatus}","User",$msg);
                              $html = '<html lang="en" dir="ltr" style="border: 0 none;font: inherit;margin: 0;padding: 0;vertical-align: baseline;">
                                           <head>
                                                <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
                                                <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
                                                <meta content="width=device-width" name="viewport">
                                                
                                           </head>
                                           <body style="background: #FFFFFF;color: #333333;font-family: Helvetica,Arial,sans-serif;font-size: 14px;line-height: 1.5em;margin: 0;padding: 40px 0;">
                                                  '.$msg.'    
                                           </body>
                                      </html>';
                              $sub = $template1['vSubject'];
                              $sub = str_replace("{newusername}",$fname." ".$lname,$sub);
                              $adminssql = "SELECT * FROM user_mst WHERE vUserType='1' OR vUserType='3'";
                              $adminsresult = mysql_query($adminssql);
                              while($row = mysql_fetch_assoc($adminsresult)){
                                   $headers  = 'MIME-Version: 1.0' . "\r\n";
                                   $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                                   // Additional headers
                                   $headers .= 'From: Ticket System <'.$template1['vSender'].'>' . "\r\n";
                                   mail($row['vEmail'], $sub, $html, $headers);
                              }
                             $smsg = "Erfolgreich erstellt";     
                        } else {
                             $emsg = "Bitte alle erforderlichen Felder ausfüllen";
                        }     
                   } else {
                        $emsg = "Die Passwörter sind nicht gleich";
                   }
               } else {
                    $emsg = "Die E-Mail Adressen stimmen nicht überein";
               }
          } else {
               $emsg = "Diese E-Mail exestiert berreits. Hast Du Dein Passwort vergessen?";
          }
     }
      
?>
<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!-- Consider adding a manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <link rel="dns-prefetch" href="http://fonts.googleapis.com" />
    <link rel="dns-prefetch" href="http://themes.googleusercontent.com" />
    <link rel="dns-prefetch" href="http://ajax.googleapis.com" />
    <link rel="dns-prefetch" href="http://cdnjs.cloudflare.com" />
    <link rel="dns-prefetch" href="http://agorbatchev.typepad.com" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Login - Bike Arena Banneker Ticket System</title>
    <meta name="description" content="Workflow System | Bikearena Benneker OHG">
    <meta name="author" content="Smootharrangement | Philipp Dallmann">
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;"> 
    <meta name="format-detection" content="telephone=no">
    <link rel="shortcut icon" href="favicon.ico" />
    
<!-- CSS -->

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/grid.css">
    <link rel="stylesheet" href="css/layout.css">
    <link rel="stylesheet" href="css/icons.css">
    <link rel="stylesheet" href="css/fonts/font-awesome.css">
    <!--[if IE 8]><link rel="stylesheet" href="css/fonts/font-awesome-ie7.css"><![endif]-->
    <link rel="stylesheet" href="css/external/jquery-ui-1.9.1.custom.css">
    <link rel="stylesheet" href="css/external/jquery.chosen.css">
    <link rel="stylesheet" href="css/external/jquery.cleditor.css">
    <link rel="stylesheet" href="css/external/jquery.colorpicker.css">
    <link rel="stylesheet" href="css/external/jquery.elfinder.css">
    <link rel="stylesheet" href="css/external/jquery.fancybox.css">
    <link rel="stylesheet" href="css/external/jquery.jgrowl.css">
    <link rel="stylesheet" href="css/external/jquery.plupload.queue.css">
    <link rel="stylesheet" href="css/external/syntaxhighlighter/shCore.css" />
    <link rel="stylesheet" href="css/external/syntaxhighlighter/shThemeDefault.css" />
    <link rel="stylesheet" href="css/elements.css">
    <link rel="stylesheet" href="css/forms.css">
    <link rel="stylesheet" href="css/print-invoice.css">
    <link rel="stylesheet" href="css/typographics.css">
    <link rel="stylesheet" href="css/media-queries.css">
    <link rel="stylesheet" href="css/ie-fixes.css">
    
 <!-- JavaScript -->
 
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.js"></script>
    <script>window.jQuery || document.write('<script src="js/libs/jquery-1.8.2.js"><\/script>')</script>
    <script src="http://code.jquery.com/ui/1.9.1/jquery-ui.js"></script>
    <script>window.jQuery.ui || document.write('<script src="js/libs/jquery-ui-1.9.1.js"><\/script>')</script>
    <!--[if gt IE 8]><!-->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/lodash.js/0.8.2/lodash.js"></script>
    <script>window._ || document.write('<script src="js/libs/lo-dash.js"><\/script>')</script>
    <!--<![endif]-->
    <!--[if lt IE 9]><script src="http://documentcloud.github.com/underscore/underscore.js"></script><![endif]-->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/require.js/2.0.6/require.js"></script>
    <script>window.require || document.write('<script src="js/libs/require-2.0.6.min.js"><\/script>')</script>
    <script type="text/javascript">
        window.WebFontConfig = {
            google: { families: [ 'PT Sans:400,700' ] },
            active: function(){ $(window).trigger('fontsloaded') }
        };
    </script>
    <script defer async src="https://ajax.googleapis.com/ajax/libs/webfont/1.0.28/webfont.js"></script>
    <script src="js/mylibs/polyfills/modernizr-2.6.1.min.js"></script>
    <script src="js/mylibs/polyfills/respond.js"></script>
    <script src="js/mylibs/polyfills/matchmedia.js"></script>
    <!--[if lt IE 9]><script src="js/mylibs/polyfills/selectivizr.js"></script><![endif]-->
    <!--[if lt IE 10]><script src="js/mylibs/polyfills/excanvas.js"></script><![endif]-->
    <!--[if lt IE 10]><script src="js/mylibs/polyfills/classlist.js"></script><![endif]-->
    <script src="js/mylibs/jquery.hashchange.js"></script>
    <script src="js/mylibs/jquery.idle-timer.js"></script>
    <script src="js/mylibs/jquery.plusplus.js"></script>
    <script src="js/mylibs/jquery.scrollTo.js"></script>
    <script src="js/mylibs/jquery.ui.touch-punch.js"></script>
    <script src="js/mylibs/jquery.ui.multiaccordion.js"></script>
    <script src="js/mylibs/number-functions.js"></script>
    <script src="js/mylibs/fullstats/jquery.css-transform.js"></script>
    <script src="js/mylibs/fullstats/jquery.animate-css-rotate-scale.js"></script>
    <script src="js/mylibs/forms/jquery.validate.js"></script>
    <script src="js/mango.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/script.js"></script>
    <script src="js/app.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/signup.js"></script>

</head>

<body class=login>

	<!-- Some dialogs etc. -->

	<!-- The loading box -->
	<div id="loading-overlay"></div>
	<div id="loading">
		<span>Lade...</span>
	</div>
	<!-- End of loading box -->
	
	<!--------------------------------->
	<!-- Now, the page itself begins -->
	<!--------------------------------->
	
	<!-- The toolbar at the top -->
	<section id="toolbar">
		<div class="container_12">
		
			<!-- Left side -->
			<div class="left">
	
			</div>
			<!-- End of .left -->
			
			<!-- Right side -->
			<div class="right">

			</div><!-- End of .right -->
			
			<!-- Phone only items -->
			<div class="phone">
				

			
			</div><!-- End of .phone -->
			
		</div><!-- End of .container_12 -->
	</section><!-- End of #toolbar -->
	
	<!-- The header containing the logo -->
	<header class="container_12">
		
		<div class="container">
		
			<!-- Your logos -->
			<a href="index.php"><img src="img/logo-light.png" alt="BAB" width="210" height="67"></a>
			<a class="phone-title" href="index.php"><img src="img/logo-mobile.png" alt="BAB" height="22" width="70" /></a>
			
			<!-- Right link -->
			<div class="right">
			</div>
			
		</div><!-- End of .container -->
	
	</header><!-- End of header -->
	
	<!-- The container of the sidebar and content box -->
	<section id="login" class="container_12 clearfix">
	
		<form action="" method="post" class="box validate">
		
			<div class="header">
				<h2><span class="icon icon-lock"></span>Login</h2>
			</div>
			
			<div class="content">
				
				<!-- Login messages -->
				<div class="login-messages" style="height: 46px;">
				      <?php
                              if($emsg != ""){
                          ?>
					     <div class="message welcome" style="display:none;">Willkommen zurück</div>
					<?php
                              } else {
                                   if($smsg != ""){
                         ?>
                                        <div class="message welcome" style="display:block;"><?=$smsg?></div>
                         <?php
                                   } else {
                         ?>
                                        <div class="message welcome" style="display:block;">Willkommen zurück</div>
                         <?php
                                   }
                              }
                         ?>
                         <?php
                              if($emsg != ""){
                          ?>
					     <div class="message failure" style="display:block;"><?=$emsg?></div>
					<?php
                              } else {
                         ?>
                              <div class="message failure" style="display:none;">Unzul&auml;ssige Login Daten</div>
                         <?php
                              }
                         ?>
				</div>
			
				<!-- The form -->
				<div class="form-box">
				
					<div class="row">
						<label for="login_name">
							<strong>Benutzername</strong>
							<small>(E-Mail Addresse)</small>
						</label>
						<div>
							<input tabindex=1 type="text" class="required noerror" name=login_name id=login_name />
						</div>
					</div>
					
					<div class="row">
						<label for="login_pw">
							<strong>Passwort</strong>
							<a style="border-bottom:1px dotted black;" href="javascript:void(0);" class="open-forget-password-dialog">Passwort vergessen?</a>
							<small><a href="javascript:void(0);" id=""></a></small>
						</label>
												<div>
							<input tabindex=2 type="password" class="required noerror" name=login_pw id=login_pw />
													</div>
					</div>
					
				</div><!-- End of .form-box -->
				
			</div><!-- End of .content -->
			
			<div class="actions">
				<div class="left">
					<div class="rememberme">
						<input tabindex=4 type="checkbox" name="login_remember" id="login_remember" /><label for="login_remember">Zugangsdaten speichern?</label>
					</div>
				</div>
				<div class="right">
					<input tabindex=3 type="button" class="open-add-client-dialog" value="Neuer Benutzer" name="login_btn" />
					<input tabindex=3 type="submit" value="Login" name="login_btn" />
				</div>
				
			</div><!-- End of .actions -->
			
		</form><!-- End of form -->

	</section>
	
	<!-- Add User Dialog -->
    <div style="display: none;" id="dialog_add_client" title="Anmelden">
        <form action="" class="full validate" method="post" id="signup_form" name="signup_form">
            <div class="row">
                <label for="d2_username">
                    <strong>Vorname</strong>
                </label>
                <div>
                    <input class="required" type=text name=d2_fname id=d2_fname />
                </div>
            </div>
            <div class="row">
                <label for="d2_username">
                    <strong>Nachname</strong>
                </label>
                <div>
                    <input class="required" type=text name=d2_lname id=d2_lname />
                </div>
            </div>
            <div class="row">
                <label for="d2_email">
                    <strong>E-Mail Addresse</strong>
                </label>
                <div>
                    <input class="required email" type=text name=d2_email id=d2_email />
                </div>
            </div>
            <div class="row">
                <label for="d2_email">
                    <strong>E-Mail Addresse bestätigen</strong>
                </label>
                <div>
                    <input class="required email" type=text name=d2_email1 id=d2_email1 />
                </div>
            </div>
            <div class="row">
                <label for="d2_email">
                    <strong>Passwort</strong>
                </label>
                <div>
                    <input class="required" type=password name=d2_pass id=d2_pass />
                </div>
            </div>
            <div class="row">
                <label for="d2_email">
                    <strong>Passwort bestätigen</strong>
                </label>
                <div>
                    <input class="required" type=password name=d2_pass1 id=d2_pass1 />
                </div>
            </div>
        
            <div class="actions">
                <div class="left">
                    <button class="grey cancel">Abbrechen</button>
                </div>
                <div class="right">
                    <button type="submit">Anmelden</button>
                </div>
            </div>
        </form>
    </div><!-- End if #dialog_add_client -->
    <!-- Forgot Password Dialog -->
    <div style="display: none;" id="dialog_forget_password" title="Passwort vergessen">
        <form action="" class="full validate" method="post">
            <div class="row">
                <label for="email">
                    <strong>E-mail Addresse</strong>
                </label>
                <div>
                    <input class="required email" type=text name=email id=email />
                </div>
            </div>
            <div class="actions">
                <div class="left">
                    <button class="grey cancel">Abbrechen</button>
                </div>
                <div class="right">
                    <button type="submit" name="forgote">Neues Passwort anfordern</button>
                </div>
            </div>
          </form>
    </div><!-- End if #dialog_add_client -->
	<!-- Spawn $$.loaded -->
	<script>
		$$.loaded();
          $$.ready(function() {
              $( "#dialog_add_client" ).dialog({
                  autoOpen: false,
                  modal: true,
                  width: 400,
                  open: function(){ $(this).parent().css('overflow', 'visible'); $$.utils.forms.resize() }
              }).find('button.submit').click(function(){
                  var $el = $(this).parents('.ui-dialog-content');
                  if ($el.validate().form()) {
                      $el.find('form')[0].reset();
                      $el.dialog('close');
                  }
              }).end().find('button.cancel').click(function(){
                  var $el = $(this).parents('.ui-dialog-content');
                  $el.find('form')[0].reset();
                  $el.dialog('close');;
              });
              
              $( ".open-add-client-dialog" ).click(function() {
                  $( "#dialog_add_client" ).dialog( "open" );
                  return false;
              });
              
              $( "#dialog_forget_password" ).dialog({
                  autoOpen: false,
                  modal: true,
                  width: 400,
                  open: function(){ $(this).parent().css('overflow', 'visible'); $$.utils.forms.resize() }
              }).find('button.submit').click(function(){
                  var $el = $(this).parents('.ui-dialog-content');
                  if ($el.validate().form()) {
                      $el.find('form')[0].reset();
                      $el.dialog('close');
                  }
              }).end().find('button.cancel').click(function(){
                  var $el = $(this).parents('.ui-dialog-content');
                  $el.find('form')[0].reset();
                  $el.dialog('close');;
              });
              
              $( ".open-forget-password-dialog" ).click(function() {
                  $( "#dialog_forget_password" ).dialog( "open" );
                  return false;
              });
              
               $("#d2_email1").keydown(function(event) {
                    if (event.ctrlKey==true && (event.which == '118' || event.which == '86')) {
                         event.preventDefault();
                    }
               });
          });
    </script>
	
	<!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
	   chromium.org/developers/how-tos/chrome-frame-getting-started -->
	<!--[if lt IE 7 ]>
	<script defer src="http://ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
	<script defer>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
	<![endif]-->

</body>
</html>