<?php
     session_start();
     include 'header.php';
     include 'connection.php';
     if(!isset($_SESSION['uid']) || $_SESSION['uid'] == "") {
          echo "<script type='text/javascript'>window.top.location='login.php';</script>";
     }
     $uid = $_SESSION['uid'];
     $emsg = "";
     if(isset($_REQUEST['send']) && $_REQUEST['send'] != ""){
          $subject = $_REQUEST['betreff'];
          $description = $_REQUEST['anliegen'];    
          $to = $_REQUEST['empfaenger'];
          $date = $_REQUEST['datum'];
          if($date != ""){
               $exdate = explode('/',$date);
               if(isset($exdate[2])){
                    $date = $exdate[2]."-".$exdate[1]."-".$exdate[0];
               } else {
                    $exdate = explode('.',$date);
                    $date = $exdate[2]."-".$exdate[1]."-".$exdate[0];
               }  
          }
          $priority = $_REQUEST['prioritaet'];
          $status = $_REQUEST['status'];
          $cdate = date("Y-m-d H:i:s");
          $uid = $_SESSION['uid'];
          $file = "";
          if(isset($_FILES["f6_file"]["name"]) && $_FILES["f6_file"]["name"] != ""){
               $datep = new DateTime();
               $file = $datep->getTimestamp();
               $arr = explode(".",$_FILES["f6_file"]["name"]);
               $file = $file."_".$arr[0].".".end($arr);
               move_uploaded_file($_FILES["f6_file"]["tmp_name"], "tickuploadfile/" . $file);
          }
          if($subject != "" && $description != "" && $to != "" && $priority != ""){
               $subject = mysql_real_escape_string($subject);
               $description = mysql_real_escape_string($description);
               $file = mysql_real_escape_string($file);
               $ticketInsert = "INSERT INTO ticket_mst (vSubject,tMatterConcern,iSenderId,iReceiverId,tCreateDate,dEditDate,dDate,vPriority,vAttechedFile,vStatus) VALUES ('".$subject."','".$description."','".$uid."','".$to."','".$cdate."','".$cdate."','".$date."','".$priority."','".$file."','".$status."')";
               mysql_query($ticketInsert);
               $ruser = "SELECT * FROM user_mst WHERE iId='".$to."'";
               $rresult = mysql_query($ruser);
               $rrow = mysql_fetch_assoc($rresult);
               $email = $rrow['vEmail'];
               $fname = $rrow['vFname'];
               $lname = $rrow['vLname'];
               $_SESSION['sucess'] = "Dein Ticket wurde erfolgreich an ".$fname." ".$lname." gesendet";
               
               $seltamplate = "SELECT * FROM email_template WHERE iId='2'";
               $temresult = mysql_query($seltamplate);
               $template = mysql_fetch_assoc($temresult);
               $msg = $template['tMessage'];
               $msg = str_replace("{benutzername}",$fname." ".$lname,$msg);
               $msg = str_replace("{absender}",$_SESSION['uname'],$msg);
               $msg = str_replace("{tickettext}",$description,$msg);
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
                $sub = str_replace("{absender}",$_SESSION['uname'],$sub);
                $sub = str_replace("{ticketbeschreibung}",$subject,$sub);
                mail($email, $sub, $html, $headers);
               echo "<script type='text/javascript'>window.top.location='tickets_alle.php';</script>";
          } else {
               $emsg = "Bitte füllen Sie alle benötigten Felder aus.";
          }
     }
     if(isset($_REQUEST['edit']) && $_REQUEST['edit'] != ""){
          $priority = $_REQUEST['prioritaet'];
          $status = $_REQUEST['status'];
          
          $tinfo = "SELECT * FROM ticket_mst WHERE iId='".$_REQUEST['tid']."'";
          $tinforesult = mysql_query($tinfo);
          $tinforow = mysql_fetch_assoc($tinforesult);
          $to = $tinforow['iReceiverId'];
          $subject = $tinforow['vSubject'];
          $description = $tinforow['tMatterConcern'];
          $etickstatus = $tinforow['vStatus'];
          
          $ruser = "SELECT * FROM user_mst WHERE iId='".$to."'";
          $rresult = mysql_query($ruser);
          $rrow = mysql_fetch_assoc($rresult);
          $email = $rrow['vEmail'];
          $fname = $rrow['vFname'];
          $lname = $rrow['vLname'];
          
          if($status != $etickstatus){
                    $seltamplate = "SELECT * FROM email_template WHERE iId='4'";
                    $temresult = mysql_query($seltamplate);
                    $template = mysql_fetch_assoc($temresult);
                    $msg = $template['tMessage'];
                    $msg = str_replace("{benutzername}",$fname." ".$lname,$msg);
                    $msg = str_replace("{absender}",$_SESSION['uname'],$msg);
                    $msg = str_replace("{tickettext}",$description,$msg);
                    if($etickstatus == "Open"){
                        $_SESSION['sucess'] = "Der Ticketstatus ist: Geöffnet";
                        $msg = str_replace("{ticketstatus}","Close",$msg);
                    } else {
                         $_SESSION['sucess'] = "Der Ticketstatus ist: Geöffnet";
                        $msg = str_replace("{ticketstatus}","Open",$msg);
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
                    $headers  = 'MIME-Version: 1.0' . "\r\n";
                    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                    // Additional headers
                    
                    $headers .= 'From: Ticket System <'.$template['vSender'].'>' . "\r\n";
                    
                    $sub = $template['vSubject'];
                    $sub = str_replace("{absender}",$_SESSION['uname'],$sub);
                    $sub = str_replace("{ticketbeschreibung}",$subject,$sub);
                    mail($email, $sub, $html, $headers);     
               }
          $subject = $_REQUEST['betreff'];
          $description = $_REQUEST['anliegen'];    
          $to = $_REQUEST['empfaenger'];
          $date = $_REQUEST['datum'];
          if($date != ""){
               $exdate = explode('/',$date);
               if(isset($exdate[2])){
                    $date = $exdate[2]."-".$exdate[1]."-".$exdate[0];
               } else {
                    $exdate = explode('.',$date);
                    $date = $exdate[2]."-".$exdate[1]."-".$exdate[0];
               }  
          }
          $cdate = date("Y-m-d H:i:s");
          $file = "";
          if(isset($_FILES["f6_file"]["name"]) && $_FILES["f6_file"]["name"] != ""){
               $datep = new DateTime();
               $file = $datep->getTimestamp();
               $arr = explode(".",$_FILES["f6_file"]["name"]);
               $file = $file."_".$arr[0].".".end($arr);
               move_uploaded_file($_FILES["f6_file"]["tmp_name"], "tickuploadfile/" . $file);
          }
          if($subject != "" && $description != "" && $to != "" && $priority != ""){
               $subject = mysql_real_escape_string($subject);
               $description = mysql_real_escape_string($description);
               $ticketInsert = "UPDATE ticket_mst SET vSubject='".$subject."',tMatterConcern='".$description."',iReceiverId='".$to."',dEditDate='".$cdate."',dDate='".$date."',vPriority='".$priority."',vStatus='".$status."'";
               if($file != ""){
                    $file = mysql_real_escape_string($file);
                    $ticketInsert .= " ,vAttechedFile='".$file."'";
               }
               $ticketInsert .= " WHERE iId='".$_REQUEST['tid']."'";
               mysql_query($ticketInsert);
               echo "<script type='text/javascript'>window.top.location='tickets_alle.php';</script>";
          } else {
               $emsg = "Bitte alle Felder ausfüllen";
          }     
     }
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
     <?php
          if(isset($_REQUEST['tid']) && $_REQUEST['tid'] != ""){
               $tid = $_REQUEST['tid'];
               $selQuery = "SELECT tm.vSubject,tm.tMatterConcern,tm.iSenderId,tm.dDate,tm.vPriority,tm.vStatus,um.iId 
                         FROM ticket_mst tm LEFT JOIN user_mst um ON tm.iReceiverId=um.iId WHERE tm.iId='".$tid."'";
               $tikResult = mysql_query($selQuery);
               $data = mysql_fetch_assoc($tikResult);
               //echo "<pre>";
               //print_r($data);exit;
               if($data['dDate'] != "0000-00-00"){
                    $data['dDate'] = date("d.m.Y",strtotime($data['dDate']));    
               } else {
                    $data['dDate'] = "";
               }
     ?>
               <form action="" class="grid_12" method="post" class="box validate" enctype="multipart/form-data">
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
                         <legend>Ticket bearbeiten</legend>
					<div class="row">
						<label for="betreff">
							<strong>Betreff</strong>
						</label>
						<div>
							<input type="text" value="<?=$data['vSubject']?>" placeholder="Bitte gebe einen Betreff an" name="betreff" id="betreff" />
						</div>
					</div>
					
					<div class="row">
						<label for="anliegen">
							<strong>Anliegen</strong>
						</label>
						<div>
							<textarea rows=5 placeholder="Bitte teile Dein Anliegen detailiert mit" name="anliegen" id="anliegen"><?=$data['tMatterConcern']?></textarea>
						</div>
					</div>
					<div class="row">
						<label for="empfaenger">
							<strong>Empfänger</strong>
						</label>
						<div>
							<select name=empfaenger id=empfaenger class="search" required data-placeholder="Bitte wähle den Empfänger">
								<option value=""></option>
								<?php
                                             $selectuser = "SELECT * FROM user_mst";
                                             $userresult = mysql_query($selectuser);
                                             while($row = mysql_fetch_assoc($userresult)){
                                                  $select = "";
                                                  if($data['iId'] == $row['iId']){
                                                       $select = "selected";
                                                  }
                                        ?>
								       <option value="<?=$row['iId']?>" <?=$select?>><?=$row['vFname']." ".$row['vLname']?></option>
								<?php
                                             }
                                        ?>
							</select>
						</div>
					</div>				
					<div class="row">
						<label for="datum">
							<strong>Zu erledigen bis</strong>
						</label>
						<div>
							<input value="<?=$data['dDate']?>" placeholder="Bitte nur ausfüllen wenn ein Erledigungsdatum erforderlich ist" type="date" name=datum id=datum />
						</div>
					</div>		

					<div class="row">
						<label for="prioritaet">
							<strong>Priorität</strong>
						</label>
						<div>
							<select name=prioritaet id=prioritaet data-placeholder="Wie wichtig ist Dein Anliegen?">
                                        <option value=""></option>
								<option value="Low" <?=$data['vPriority']=="Low"?"Selected":""?>>Niedrig</option> 
								<option value="Normal" <?=$data['vPriority']=="Normal"?"Selected":""?>>Normal</option> 
								<option value="High" <?=$data['vPriority']=="High"?"Selected":""?>>Hoch</option> 
								<option value="Emeregncy" <?=$data['vPriority']=="Emeregncy"?"Selected":""?>>Notfall</option> 
							</select>
						</div>
					</div>
					<div class="row not-on-phone">
						<label for="f6_file">
							<strong>Anhang</strong>
						</label>
						<div>
							<input data-buttonText="Search" type="file" id=f6_file name=f6_file />
						</div>
					</div>
					<div class="row">
						<label for="status">
							<strong>Ticket Status</strong>
						</label>
						<div>
							<select name=status id=status >
								<option selected value="Open" <?=$data['vStatus']=="Open"?"Selected":""?>>Geöffnet</option> 
								<option value="Close" <?=$data['vStatus']=="Close"?"Selected":""?>>Geschlossen</option> 
							</select>
						</div>
					</div>
					<div class="actions">
						<div class="left">
							<input type="reset" value="Abbrechen" />
						</div>
						<div class="right">
							<input type="submit" value="Save" name=edit />
						</div>
					</div><!-- End of .actions -->
				</fieldset><!-- End of fieldset -->
               </form>
     <?php
          } else {
     ?>
          <form action="" class="grid_12" method="post" class="box validate" enctype="multipart/form-data">
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
                    <legend>Neues Ticket</legend>
                         <div class="row">
					     <label for="betreff">
							<strong>Betreff</strong>
						</label>
						<div>
							<input required type="text" placeholder="Bitte gebe einen Betreff an" name="betreff" id="betreff" />
						</div>
					</div>
					
                         <div class="row">
						<label for="anliegen">
							<strong>Anliegen</strong>
						</label>
						<div>
							<textarea required rows=5 placeholder="Bitte teile Dein Anliegen detailiert mit" name="anliegen" id="anliegen"></textarea>
						</div>
					</div>
					<div class="row">
						<label for="empfaenger">
							<strong>Empfänger</strong>
                              </label>
						<div>
							<select name=empfaenger id=empfaenger class="search" required data-placeholder="Bitte wähle den Empfänger">
								<option value=""></option>
								<?php
                                             $selectuser = "SELECT * FROM user_mst WHERE iId <> '".$uid."'";
                                             $userresult = mysql_query($selectuser);
                                             while($row = mysql_fetch_assoc($userresult)){
                                             
                                        ?>
								       <option value="<?=$row['iId']?>"><?=$row['vFname']." ".$row['vLname']?></option>
								<?php
                                             }
                                        ?>
							</select>
						</div>
					</div>				
					<div class="row">
						<label for="datum">
							<strong>Zu erledigen bis</strong>
						</label>
						<div>
							<input placeholder="Bitte nur ausfüllen wenn ein Erledigungsdatum erforderlich ist" type="date" autocomplete="off" name=datum id=datum />
						</div>
					</div>		

					<div class="row">
						<label for="prioritaet">
							<strong>Priorität</strong>
						</label>
						<div>
							<select required name=prioritaet id=prioritaet data-placeholder="Wie wichtig ist Dein Anliegen?">
							    <option value=""></option>
								<option value="Low">Niedrig</option> 
								<option value="Normal">Normal</option> 
								<option value="High">Hoch</option> 
								<option value="Emeregncy">Notfall</option> 
							</select>
						</div>
					</div>
					<div class="row not-on-phone">
						<label for="f6_file">
							<strong>Anhang</strong>
						</label>
						<div>
							<input data-buttonText="Search" type="file" id=f6_file name=f6_file />
						</div>
					</div>
					<div class="row">
						<label for="status">
							<strong>Ticket Status</strong>
						</label>
						<div>
							<select name=status id=status >
								<option selected value="Open">Geöffnet</option> 
								<option value="Close">Geschlossen</option> 
							</select>
						</div>
					</div>
					<div class="actions">
						<div class="left">
							<input type="reset" value="Abbrechen" />
						</div>
						<div class="right">
							<input type="submit" value="Senden" name=send />
						</div>
					</div><!-- End of .actions -->
				</fieldset><!-- End of fieldset -->
               </form>
          <?php
               }
          ?>
		</div><!-- End of content -->
     </section><!-- End of #content -->
</div><!-- End of #main -->
<!-- The footer -->
<?php
     include 'foooter.php';     
?>