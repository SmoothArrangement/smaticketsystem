<?php
     if(!isset($_REQUEST['tid']) || $_REQUEST['tid'] == "") {
          echo "<script type='text/javascript'>window.top.location='logout.php';</script>";
     }
     include 'connection.php';
     session_start();
     if(!isset($_SESSION['uid']) || $_SESSION['uid'] == "") {
          echo "<script type='text/javascript'>window.top.location='login.php';</script>";
     }
     $select = "SELECT tm.*,um1.vFname as sendfname,um1.vLname as sendlname FROM ticket_mst tm
               LEFT JOIN user_mst um1 ON tm.iSenderId=um1.iId WHERE tm.iId='".$_REQUEST['tid']."'";
     $result = mysql_query($select);
     $row = mysql_fetch_assoc($result);
     $priority = "Undefine";
     if($row['vPriority'] == "Low"){
         $priority = "Niedrig";
     } else if($row['vPriority'] == "Normal"){
         $priority = "Normal";
     } else if($row['vPriority'] == "High"){
         $priority = "Hoch";
     } else if($row['vPriority'] == "Emeregncy"){
         $priority = "Notfall";
     }
     $status = "Undefine";
     if($row['vStatus'] == "Open"){
         $status = "Offen";
     } else if($row['vStatus'] == "Close"){
         $status = "Geschlossen";
     }
     $upque = "UPDATE ticket_mst SET vView='YES' WHERE iId='".$_REQUEST['tid']."'";
     mysql_query($upque);
     $description = "";
     $selectthread = "SELECT * FROM tick_ans ta LEFT JOIN user_mst um ON um.iId=ta.iUserId WHERE ta.iTickId='".$_REQUEST['tid']."' ORDER BY ta.tCreateOn DESC";
     $threadresult = mysql_query($selectthread);
     $file = "";
     while($threadrow = mysql_fetch_assoc($threadresult)){
          $description .= $threadrow['vFname']." ".$threadrow['vLname']." schrieb am ".date("d.m.Y",strtotime($threadrow['tCreateOn']))." um ".date("H:m",strtotime($threadrow['tCreateOn']))." :&#13;&#10;&#13;&#10;";
          $description .= $threadrow['vAnswer'];
          $description .= "&#13;&#10;_____________________________________________________________&#13;&#10;&#13;&#10;";
          if($threadrow['vFile'] != ""){
               $file .= "<a href='tickuploadfile/".$threadrow['vFile']."' target='_blank'>".$threadrow['vFile']."</a>";
          }    
     }
     $description .= $row['sendfname']." ".$row['sendlname']." schrieb am ".date("d.m.Y",strtotime($row['tCreateDate']))." um ".date("H:m",strtotime($row['tCreateDate']))." :&#13;&#10;&#13;&#10;";
     $description .= $row['tMatterConcern'];
     //$file = "<a href='javascript:void(0);'>Kein Anhang</a>";
     if($row['vAttechedFile'] != ""){
          if($file == ""){
               $file = "<a href='tickuploadfile/".$row['vAttechedFile']."' target='_blank'>".$row['vAttechedFile']."</a>";
          } else {
               $file .= "<a href='tickuploadfile/".$row['vAttechedFile']."' target='_blank'>".$row['vAttechedFile']."</a>";
          }
     }
     if($file == ""){
          $file = "<a href='javascript:void(0);'>Kein Anhang</a>";
     }
     if($row['dDate'] != "0000-00-00"){
          $row['dDate'] = date("d.m.Y",strtotime($row['dDate']));    
     } else {
          $row['dDate'] = "";
     }
     //echo "<pre>";
     //print_r($row);exit;
?>
<form action="" class="full validate">
     <fieldset>
		<legend>Ticket von <?=$row['sendfname']." ".$row['sendlname']?> erstellt am <?=date("d.m.Y",strtotime($row['tCreateDate']))?> zuletzt bearbeitet am <?=date("d.m.Y",strtotime($row['dEditDate']))?></legend>
		<div class="row">
			<label for="betreff">               
				<strong>Betreff</strong>
			</label>
			<div>
				<input type="text" disabled placeholder="Subject" value="<?=$row['vSubject']?>" name="betreff" id="betreff" />
			</div>
		</div>
					
		<div class="row">
			<label for="anliegen">
				<strong>Anliegen</strong>
			</label>
			<div>
				<textarea rows=7 disabled placeholder="Description" name="anliegen" id="anliegen" style="resize: both;"><?=$description?></textarea>
			</div>
		</div>
		
		<div class="row">
			<label for="datum">
				<strong>Antwort bis</strong>
			</label>
			<div>
				<input disabled placeholder="Date" value="<?=$row['dDate']?>" type="text" name="date" id="date" />
			</div>
		</div>		

		<div class="row">
			<label for="prioritaet">
				<strong>Priorit&auml;t</strong>
										</label>
			<div>
				<input disabled placeholder="CONTENT FROM DB" value="<?=$priority?>" type="text" name="prioritaet" id="prioritaet" />
			</div>
		</div>
						<div class="row not-on-phone">
			<label for="f6_file">
				<strong>Anhang</strong>
			</label>
			<div>
				<?=$file?>
			</div>
		</div>
		<div class="row">
			<label for="status">
				<strong>Ticket Status</strong>
			</label>
			<div>
			    <input disabled placeholder="CONTENT FROM DB" value="<?=$status?>" type="text" name="status" id="status" />
			</div>
		</div>
		<?php
               if($row['vStatus'] == "Open"){
          ?>
               <div class="actions">
      			<div class="right">
      				<input type="button" class="treply" id="<?=$_REQUEST['tid']?>" value="Antworten" name=send />
      			</div>
      		</div><!-- End of .actions -->
          <?php
               }
          ?> 
     </fieldset><!-- End of fieldset -->
</form>