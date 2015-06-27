<?php
     session_start();
     include 'header.php';
     include 'connection.php';
     if(!isset($_SESSION['uid']) || $_SESSION['uid'] == "") {
          echo "<script type='text/javascript'>window.top.location='login.php';</script>";
     }
     if(isset($_REQUEST['send']) && $_REQUEST['send'] != ""){
          $name = $_REQUEST['username'];
          $pass = $_REQUEST['newpassword'];
          $oldpass = $_REQUEST['oldpassword'];
          $email = $_REQUEST['useremail'];
          $oldpass = base64_encode($oldpass);
          $select = "SELECT * FROM user_mst WHERE vPassword='".$oldpass."' AND iId='".$_SESSION['uid']."'";
          $result = mysql_query($select);
          if(mysql_num_rows($result) == 1 && $email != ""){
               $name = explode(" ",$name);
               $fname = $name[0];
               $lname = $name[1];
               $fname = mysql_real_escape_string($fname);
               $lname = mysql_real_escape_string($lname);
               $email = mysql_real_escape_string($email);
               $upquery = "UPDATE user_mst SET vFname='".$fname."',vLname='".$lname."',vEmail='".$email."'";
               if($pass != ""){
                    $pass = base64_encode($pass);
                    $upquery .= ",vPassword='".$pass."'";
               }
               $upquery .= " WHERE iId='".$_SESSION['uid']."'";
               mysql_query($upquery);
               $_SESSION['sucess'] = "Deine Daten wurden erfolgreich gespeichert.";
          } else {
               $emsg = "Bitte überprüfe das Passwort";
               $_SESSION['error'] = "Bitte überprüfe das Passwort";
          }
          echo "<script type='text/javascript'>window.top.location='account.php';</script>";
     }
     $select = "SELECT tm.*,um1.vFname as sendfname,um1.vLname as sendlname,um2.vFname as recfname,um2.vLname as reclname FROM ticket_mst tm
               LEFT JOIN user_mst um1 ON tm.iSenderId=um1.iId
               LEFT JOIN user_mst um2 ON tm.iReceiverId=um2.iId WHERE tm.iReceiverId='".$_SESSION['uid']."' OR tm.iSenderId='".$_SESSION['uid']."'";
     $result = mysql_query($select);
     $new = 0;
     $close = 0;
     $open = 0;
     $overdue = 0;
     while($row = mysql_fetch_assoc($result)){
          if($row['vStatus'] == "Open"){
               $open++;
          }
          if($row['vStatus'] == "Close"){
               $close++;
          }
          $date = date("Y-m-d");
          if($row['vView'] == "NO"){
               $new++;
          }
          $date1 = date("Y-m-d",strtotime($row['dDate']));
          if($date > $date1){
               $overdue++;
          }     
     }
     $select = "SELECT * FROM user_mst WHERE iId='".$_SESSION['uid']."'";
     $result = mysql_query($select);
     $data = mysql_fetch_assoc($result);
?>
<!-- End of header -->
    <!-- The container of the sidebar and content box -->
    <div role="main" id="main" class="container_12 clearfix">
    
        <!-- The blue toolbar stripe -->
        <section class="toolbar">
          <div class="userMsg">
               Du bist eingelogt: <?=$_SESSION['uname']?>
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
			<ul class="stats">
				<li>
					<strong><?=$new?></strong>
					<small>Neue Tickets</small>
				</li>
				<li>
					<strong><?=$open?></strong>
					<small>Offene Tickets</small>
				</li>
				<li>
					<strong><?=$close?></strong>
					<small>Geschlossene Tickets</small>
				</li>
				<li>
					<strong><?=$overdue?></strong>
					<small>Überfällige Tickets</small>
				</li>
			</ul><!-- End of ul.stats -->

			<h1 class="grid_12 margin-top no-margin-top-phone">Mein Account</h1>
        <!-- Here goes the content. -->
			<form action="" class="grid_12" method="post">
			       <?php
                              if($emsg != ""){
                      ?>
                              <div class="login-messages" style="height: 15px;padding: 5px;">
                                   <div class="message failure" style="display:block;text-align: center;color: red;"><?=$emsg?></div>
                              </div>
                      <?php
                              }
                      ?>
				<fieldset>
					<legend>Benutzer Daten</legend>
					<div class="row">
						<label for="username">
							<strong>Benutzername</strong>
						</label>
						<div>
							<input type="text" required placeholder="Username" value="<?=$data['vFname']." ".$data['vLname']?>" name="username" id="username" />
						</div>
					</div>
				<div class="row">
						<label for="useremail">
							<strong>E-Mail Adresse</strong>
						</label>
						<div>
							<input type="email" required placeholder="Your Email" value="<?=$data['vEmail']?>" name="useremail" id="useremail" />
						</div>
					</div>
					<div class="row">
						<label for="newpassword">
							<strong>Passwort ändern</strong>
						</label>
						<div>
							<input type="password" placeholder="Um das Passwort zu &auml;ndern, geben Sie bitte ein neues ein." name="newpassword" id="newpassword" />
						</div>
					</div>					
					<div class="row">
						<label for="password">
							<strong>Aktuelles Passwort</strong>
						</label>
						<div>
							<input type="password" placeholder="Um die Daten zu ändern, geben Sie bitte Ihr aktuelles Passwort ein" name="oldpassword" id="oldpassword" />
						</div>
					</div>						
					
										<div class="actions">
						<div class="left">
							<input type="reset" value="Abbrechen" />
						</div>
						<div class="right">
							<input type="submit" value="&Auml;ndern" name=send />
						</div>
					</div><!-- End of .actions -->
				</fieldset><!-- End of fieldset -->
			</form>					
        </section><!-- End of #content -->
        
    </div><!-- End of #main -->
    
    <!-- The footer -->
    <?php
          include 'foooter.php';     
    ?>