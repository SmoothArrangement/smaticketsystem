<?php
     session_start();
     include 'header.php';
     include 'connection.php';
     if(!isset($_SESSION['uid']) || $_SESSION['uid'] == "") {
          echo "<script type='text/javascript'>window.top.location='login.php';</script>";
     }
     if(!isset($_SESSION['utype']) || $_SESSION['utype'] != "1") {
          if($_SESSION['utype'] != "3") {
               echo "<script type='text/javascript'>window.top.location='account.php';</script>";
          }
     }
     if(isset($_REQUEST['did']) && $_REQUEST['did'] != ""){
          $uid = $_REQUEST['did'];
          $uid = base64_decode($uid);
          $query = "DELETE FROM user_mst WHERE iId='".$uid."'"; 
          mysql_query($query);
          $_SESSION['sucess'] = "Der Benutzer wurde erfolgreich gelöscht.";
          echo "<script type='text/javascript'>window.top.location='user.php';</script>"; 
     }
     if(isset($_REQUEST['edit'])){
          $fname = $_REQUEST['d2_fname'];
          $lname = $_REQUEST['d2_lname'];
          $email = $_REQUEST['d2_email'];
          $type = $_REQUEST['status'];
          $pass = $_REQUEST['d2_pass'];
          $uid = $_REQUEST['uid'];
          if($fname != "" && $lname != "" && $email != "" && $uid != ""){
               $upQuery = "UPDATE user_mst SET vFname='".$fname."',vLname='".$lname."',vEmail='".$email."',vUserType='".$type."'";
               if($pass != ""){
                    $pass = base64_encode($pass);
                    $upQuery .= " ,vPassword='".$pass."'";
               }
               $upQuery .= " WHERE iId='".$uid."'";
               mysql_query($upQuery);
               $_SESSION['sucess'] = "Die Daten wurden erfolgreich geändert..";
          }
          echo "<script type='text/javascript'>window.top.location='user.php';</script>";
     }
     if(isset($_REQUEST['add'])){
          $fname = $_REQUEST['d2_fname'];
          $lname = $_REQUEST['d2_lname'];
          $email = $_REQUEST['d2_email'];
          $type = $_REQUEST['status'];
          $pass = $_REQUEST['d2_pass'];
          $date = date("Y-m-d H:i:s");
          if($fname != "" && $lname != "" && $email != "" && $pass != ""){
               $pass = base64_encode($pass);
               $inQuery = "INSERT INTO user_mst (vFname,vLname,vEmail,vUserType,vPassword,dLastLogin) VALUES ('".$fname."','".$lname."','".$email."','".$type."','".$pass."','".$date."')";
               mysql_query($inQuery);
               $_SESSION['sucess'] = "Der Benutzer wurde erfolgreich erstellt.";
               $seltamplate1 = "SELECT * FROM email_template WHERE iId='6'";
               $temresult1 = mysql_query($seltamplate1);
               $template1 = mysql_fetch_assoc($temresult1);
               $msg = $template1['tMessage'];
               $msg = str_replace("{newusername}",$fname." ".$lname,$msg);
               $msg = str_replace("{neuerbenutzername}",$fname." ".$lname,$msg);
               $msg = str_replace("{ticketlogin}",'<a href="http://ticket.smootharrangement.de/login.php">Click Here</a>',$msg);
               $msg = str_replace("{neuebenutzeremail}",$email,$msg);
               if($type == "2"){
                    $msg = str_replace("{benutzerstatus}","User",$msg);
               } else {
                    $msg = str_replace("{benutzerstatus}","Admin",$msg);
               }
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
          }
          echo "<script type='text/javascript'>window.top.location='user.php';</script>";
     }
     $select = "SELECT * FROM user_mst";
     $result = mysql_query($select);
?>
<!-- End of header -->
    <!-- The container of the sidebar and content box -->
    <div role="main" id="main" class="container_12 clearfix">
    
        <!-- The blue toolbar stripe -->
        <section class="toolbar">
          <div class="userMsg">
               Du bist eingeloggt <?=$_SESSION['uname']?>
          </div><!-- End of .buttons -->
          <!-- <input type="search" data-source="extras/search.php" placeholder="Suche..." autocomplete="off" class="tooltip" title="e.g. Peach" data-gravity=s> -->
        </section><!-- End of .toolbar-->
        
        <!-- The sidebar -->
        <?php
               include 'sidebar.php';     
        ?>
        <!-- End of sidebar -->

        <!-- Here goes the content. -->
        <section id="content" class="container_12 clearfix" data-sort=true>

			<h1 class="grid_12 margin-top no-margin-top-phone">Benutzerverwaltung</h1>
			<div class="grid_12">
				<div class="box">
				
					<div class="header">
						<h2>Benutzer &Uuml;bersicht</h2>
					</div>
					
					<div class="content">
					
						<div class="tabletools">
							<div class="left">
								<a href="#" class="addnewu"><i class="icon-plus"></i>Neuer Benutzer</a>
							</div>
							<div class="right"></div>
						</div>
						<table class="dynamic styled with-prev-next" data-show-Filter-Bar="true" data-table-tools='{"display":false}'>
							<thead>
								<tr>
									<th>Name</th>
									<th>E-Mail</th>
									<th>Passwort</th>
									<th>Offene Tickets</th>
									<th>Geschlossene Tickets</th>
									<th>Überfällige Tickets</th>
									<th>Letztes Login</th>
									<th>Benutzerstatus</th>
									<th>Aktion</th>
								</tr>
							</thead>
							<tbody>
                                        <?php
                                             while($row = mysql_fetch_assoc($result)){
                                                   $selectt = "SELECT * FROM ticket_mst WHERE iReceiverId='".$row['iId']."'";
                                                   $resultt = mysql_query($selectt);
                                                   $close = 0;
                                                   $open = 0;
                                                   $overdue = 0;
                                                   while($row1 = mysql_fetch_assoc($resultt)){
                                                        if($row1['vStatus'] == "Open"){
                                                             $open++; 
                                                        }
                                                        if($row1['vStatus'] == "Close"){
                                                             $close++;
                                                        }
                                                        $date = date("Y-m-d");
                                                        $date1 = date("Y-m-d",strtotime($row1['dDate']));
                                                        if($date > $date1){
                                                             $overdue++;
                                                        }     
                                                   }
                                                  if($row['vUserType'] == "1"){
                                                       $type = "Super Admin";
                                                  } else if($row['vUserType'] == "3"){
                                                       $type = "Admin";
                                                  } else {
                                                       $type = "User";
                                                  }
                                        ?>
    								<tr>
    									<td><?=$row['vFname']." ".$row['vLname']?></td>
    									<td><?=$row['vEmail']?></td>
    									<td>*********</td>
    									<td class="center"><?=$open?></td>
    									<td class="center"><?=$close?></td>
    									<td class="center"><?=$overdue?></td>
    									<td class="center"><?=date("d.m.Y",strtotime($row['dLastLogin']))?></td>
    									<td class="center"><?=$type?></td>
    									<td class="center">
    									  <?php
                                                  if($_SESSION['utype'] == "1" && $row['vUserType'] != '1'){    
                                               ?>
    									       <a href=""><span class="icon euser" id="<?=$row['iId']?>"><img src="img/icons/packs/fugue/16x16/pencil.png" alt="Benutzer bearbeiten" title="Benutzer bearbeiten" height=16 width=16></span></a>&nbsp;
    									       <a href="user.php?did=<?=base64_encode($row['iId'])?>" onclick="return confirm('Möchten Sie den Benutzer wirklich löschen?')"><span class="icon"><img src="img/icons/packs/fugue/16x16/cross-circle-frame.png" alt="Benutzer l&ouml;schen" title="Benutzer l&ouml;schen" height=16 width=16></span></a>&nbsp;
    									  <?php
                                                  }    
                                               ?>
                                             </td>
    					               </tr>
                                        <?php
                                             }
                                        ?>
							</tbody>
						</table>
          				<div id="Legende" style="float:right;">
          				<p><b>Legende:</b></p>
          				<p>
          				<span class="icon"><img src="img/icons/packs/fugue/16x16/pencil.png" alt="Benutzer bearbeiten" title="Benutzer bearbeiten" height=16 width=16></span> = Benutzer bearbeiten&nbsp;
          				<span class="icon"><img src="img/icons/packs/fugue/16x16/cross-circle-frame.png" alt="Benutzer l&ouml;schen" title="Benutzer l&ouml;schen" height=16 width=16></span> = Benutzer l&ouml;schen&nbsp;
          				</p>
          				</div>
			
			
        </section><!-- End of #content -->
        
    </div><!-- End of #main -->
    <div style="display: none;" id="dialog_edit_user" title="Benutzer bearbeiten"></div>
    <div style="display: none;" id="dialog_add_user" title="Neuer Benutzer">
          <form action="" class="full validate" method="post">
               <fieldset>
                    <div class="row">
                          <label for="d2_username">
                              <strong>Vorname</strong>
                          </label>
                          <div>
                              <input required type=text name=d2_fname id=d2_fname />
                          </div>
                      </div>
                      <div class="row">
                          <label for="d2_username">
                              <strong>Nachname</strong>
                          </label>
                          <div>
                              <input required type=text name=d2_lname id=d2_lname />
                          </div>
                      </div>
                      <div class="row">
                          <label for="d2_email">
                              <strong>E-Mail-Adresse</strong>
                          </label>
                          <div>
                              <input required type=email name=d2_email id=d2_email />
                          </div>
                      </div>
                      <div class="row">
                          <label for="d2_email">
                              <strong>Passwort</strong>
                          </label>
                          <div>
                              <input required type=password name=d2_pass id=d2_pass />
                          </div>
                      </div>
                      <div class="row">
          		        <label for="status">
          	                   <strong>Benutzerstatus</strong>
          		        </label>
          			<div>
          				<select name=status id=status >
          					<option value="2">User</option>
                                   <option value="3">Admin</option> 
          				</select>
          			</div>
          		  </div>
                      <div class="actions">
                          <div class="left">
                              <button class="grey cancel">stornieren</button>
                          </div>
                          <div class="right">
                              <button type="submit" id="add" name="add">registrieren</button>
                          </div>
                      </div><!-- End of .actions -->
          	</fieldset><!-- End of fieldset -->
          </form>
    </div>
    <script>
		$$.ready(function() {
              $( "#dialog_edit_user" ).dialog({
                  autoOpen: false,
                  modal: true,
                  width: 1100,
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
              
              $( ".euser" ).click(function() {
                  var id = $(this).attr('id');
                  $.post( "users_edit.php", { uid: id }).done(function( data ) {
                         $( "#dialog_edit_user" ).html(data);
                         $( "#dialog_edit_user" ).dialog( "open" );
                  });
                  return false;
              });
              
              $( "#dialog_add_user" ).dialog({
                  autoOpen: false,
                  modal: true,
                  width: 1100,
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
              
              $( ".addnewu" ).click(function() {
                  $( "#dialog_add_user" ).dialog( "open" );
                  return false;
              });
          });
    </script>
    <!-- The footer -->
    <?php
          include 'foooter.php';     
    ?>