<?php
     session_start();
     include 'connection.php';
     include 'header.php';
     if(!isset($_SESSION['uid']) || $_SESSION['uid'] == "") {
          echo "<script type='text/javascript'>window.top.location='login.php';</script>";
     }
     if(isset($_REQUEST['send']) && $_REQUEST['send'] != ""){
          $tid = $_REQUEST['tid'];
          $ans = $_REQUEST['antwort'];
          $status = $_REQUEST['status'];
          if($ans != ""){
               $file = "";
               if(isset($_FILES["f6_file"]["name"]) && $_FILES["f6_file"]["name"] != ""){
                    $datep = new DateTime();
                    $file = $datep->getTimestamp();
                    $arr = explode(".",$_FILES["f6_file"]["name"]);
                    $file = $file."_".$arr[0].".".end($arr);
                    move_uploaded_file($_FILES["f6_file"]["tmp_name"], "tickuploadfile/" . $file);
               }
               $date = date("Y-m-d H:i:s");
               $tinfo = "SELECT * FROM ticket_mst WHERE iId='".$tid."'";
               $tinforesult = mysql_query($tinfo);
               $tinforow = mysql_fetch_assoc($tinforesult);
               $to = $tinforow['iReceiverId'];
               $subject = $tinforow['vSubject'];
               $description = $_REQUEST['anliegen'];
               $description = $_SESSION['uname']." schrieb am ".date("d.m.Y")." um ".date("H:m")." : ".$ans."<hr>".$description;
               $description = str_replace("_____________________________________________________________","<hr>",$description);
               $etickstatus = $tinforow['vStatus'];
               
               if($to == $_SESSION['uid']){
                    $to = $tinforow['iSenderId'];
               }
               $ruser = "SELECT * FROM user_mst WHERE iId='".$to."'";
               $rresult = mysql_query($ruser);
               $rrow = mysql_fetch_assoc($rresult);
               $email = $rrow['vEmail'];
               $fname = $rrow['vFname'];
               $lname = $rrow['vLname'];
               $_SESSION['sucess'] = "Deine Antwort wurde erfolgriech an ".$fname." ".$lname." gesendet";
               
               if($status != $etickstatus){
                    $seltamplate = "SELECT * FROM email_template WHERE iId='4'";
                    $temresult = mysql_query($seltamplate);
                    $template = mysql_fetch_assoc($temresult);
                    $msg = $template['tMessage'];
                    $msg = str_replace("{benutzername}",$fname." ".$lname,$msg);
                    $msg = str_replace("{absender}",$_SESSION['uname'],$msg);
                    $msg = str_replace("{tickettext}",$description,$msg);
                    if($etickstatus == "Open"){
                        $_SESSION['sucess'] = "Das Ticket wurde geschlossen"; 
                        $msg = str_replace("{ticketstatus}","Close",$msg);
                    } else {
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
               $status = mysql_real_escape_string($status);
               $date = mysql_real_escape_string($date);
               $tid = mysql_real_escape_string($tid);
               $tickupdate = "UPDATE ticket_mst SET vStatus='".$status."',dEditDate='".$date."' WHERE iId='".$tid."'";
               mysql_query($tickupdate);
               $ans = mysql_real_escape_string($ans);
               $file = mysql_real_escape_string($file);
               $insquery = "INSERT INTO tick_ans (iTickId,vAnswer,iUserId,vFile) VALUES ('".$tid."','".$ans."','".$_SESSION['uid']."','".$file."')";
               mysql_query($insquery);
               
               $seltamplate = "SELECT * FROM email_template WHERE iId='3'";
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
          }
          echo "<script type='text/javascript'>window.top.location='tickets_offen.php';</script>";
     }
     $select = "SELECT tm.*,um1.vFname as sendfname,um1.vLname as sendlname,um2.vFname as recfname,um2.vLname as reclname FROM ticket_mst tm
               LEFT JOIN user_mst um1 ON tm.iSenderId=um1.iId
               LEFT JOIN user_mst um2 ON tm.iReceiverId=um2.iId WHERE tm.iReceiverId='".$_SESSION['uid']."' OR tm.iSenderId='".$_SESSION['uid']."' ORDER BY tCreateDate DESC";
     $result = mysql_query($select);
     $new = 0;
     $close = 0;
     $open = 0;
     $overdue = 0;
     $data = array();
     while($row = mysql_fetch_assoc($result)){
          $data[] = $row;
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
          if($row['dDate'] != "0000-00-00"){
               $date1 = date("Y-m-d",strtotime($row['dDate']));
               if($date > $date1 && $row['vStatus'] != "Close"){
                    $overdue++;
               }
          }     
     }
     //echo "<pre>";
     //print_r($_SESSION);exit;
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

        <!-- Here goes the content. -->
          <h1 class="grid_12 margin-top no-margin-top-phone">Offene Tickets</h1>
			<div class="grid_12">
				<div class="box">
				
					<div class="header">
						<h2>Offene Tickets</h2>
					</div>
					
					<div class="content">
					
						<div class="tabletools">
							<div class="left">
								<a href="tickets_neu.html"><i class="icon-plus"></i>Neues Ticket</a>
							</div>
							<div class="right"></div>
						</div>
						<table class="dynamic styled with-prev-next" data-show-Filter-Bar="true" data-table-tools='{"display":false}'>
							<thead>
								<tr>
									<th>Er&ouml;ffnet </th>
									<th>Zuletzt bearbeitet </th>
									<th>Beschreibung</th>
									<th>Ticket von</th>
									<th>Ticket an</th>
									<th>Priorit&auml;t</th>
									<th>Ticket Status</th>
									<th>Aktion</th>
								</tr>
							</thead>
							<tbody>
								<?php
                                             for($i=0; $i < count($data); $i++){
                                                  $priority = "Undefine";
                                                  if($data[$i]['vPriority'] == "Low"){
                                                       $priority = "Niedrig";
                                                  } else if($data[$i]['vPriority'] == "Normal"){
                                                       $priority = "Normal";
                                                  } else if($data[$i]['vPriority'] == "High"){
                                                       $priority = "Hoch";
                                                  } else if($data[$i]['vPriority'] == "Emeregncy"){
                                                       $priority = "Notfall";
                                                  }
                                                  $status = "Undefine";
                                                  if($data[$i]['vStatus'] == "Open"){
                                                       $status = "Offen";
                                                  } else if($data[$i]['vStatus'] == "Close"){
                                                       $status = "Geschlossen";
                                                  }
                                                  if($data[$i]['vStatus'] == "Open"){
                                      ?>
          								<tr>
          									<td><?=date("d.m.Y",strtotime($data[$i]['tCreateDate']))?></td>
          									<td><?=date("d.m.Y",strtotime($data[$i]['dEditDate']))?></td>
          									<td><?=$data[$i]['vSubject']?></td>
          									<td><?=$data[$i]['sendfname']." ".$data[$i]['sendlname']?></td>
          									<td><?=$data[$i]['recfname']." ".$data[$i]['reclname']?></td>
          									<td class="center"><?=$priority?></td>
          									<td class="center"><?=$status?></td>
          									<td class="center">
          									      <a href="tickets_view.php"><span class="icon tview" id="<?=$data[$i]['iId']?>"><img src="img/icons/packs/fugue/16x16/eye.png" alt="Ticket ansehen" title="Ticket ansehen" height=16 width=16></span></a>&nbsp;
									                <a href="tickets_reply.php"><span class="icon treply" id="<?=$data[$i]['iId']?>"><img src="img/icons/packs/fugue/16x16/arrow-return-180-left.png" alt="Ticket beantworten" title="Ticket beantworten" height=16 width=16></span></a>&nbsp;
          									</td>
          								</tr>
					             <?php
					                         }
                                             }
                                      ?>								
							</tbody>
						</table>
									<div id="Legende" style="float:right;">
									<p><b>Legende:</b></p>
									<p>
									<span class="icon"><img src="img/icons/packs/fugue/16x16/eye.png" alt="Ticket ansehen" title="Ticket ansehen" height=16 width=16></span> = Ticket ansehen&nbsp;
									<span class="icon"><img src="img/icons/packs/fugue/16x16/arrow-return-180-left.png" alt="Ticket beantworten" title="Ticket beantworten" height=16 width=16></span> = Ticket beantworten&nbsp;
									</p>
									</div>
					</div><!-- End of .content -->
					
				</div><!-- End of .box -->
			</div><!-- End of .grid_12 -->

        </section><!-- End of #content -->

			
			
			
        </section><!-- End of #content -->
        
    </div><!-- End of #main -->
    <div style="display: none;" id="dialog_view_ticket" title="Ticket ansehen"></div>
    <div style="display: none;" id="dialog_reply_ticket" title="Ticket beantworten"></div>
    <script>
		$$.ready(function() {
		    $("#f6_file").live("change",function(){
                    $(".customfile-feedback").html($(this).val());
                    var val = $(this).val().split(".");
                    var val = val[val.length-1];
                    $(".customfile-feedback").attr('class', 'customfile-feedback');
                    $(".customfile-feedback").addClass("customfile-feedback-populated");
                    $(".customfile-feedback").addClass("customfile-ext-"+val);
                    $(".customfile-button").html("Change");  
              });
              $( "#dialog_view_ticket" ).dialog({
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
              
              $( ".tview" ).live("click",function() {
                  var id = $(this).attr('id');
                  $.post( "tickets_view.php", { tid: id }).done(function( data ) {
                         $( "#dialog_view_ticket" ).html(data);
                         $( "#dialog_view_ticket" ).dialog( "open" );
                  });
                  return false;
              });
              
              $( "#dialog_reply_ticket" ).dialog({
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
              
              $( ".treply" ).live("click",function() {
                  var id = $(this).attr('id');
                  $.post( "tickets_reply.php", { tid: id }).done(function( data ) {
                         $( "#dialog_reply_ticket" ).html(data);
                         $( "#dialog_reply_ticket" ).dialog( "open" );
                  });
                  return false;
              });
          });
    </script>
    <!-- The footer -->
    <?php
          include 'foooter.php';     
    ?>