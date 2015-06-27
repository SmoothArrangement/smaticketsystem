<?php
     if(!isset($_REQUEST['tid']) || $_REQUEST['tid'] == "") {
          echo "<script type='text/javascript'>window.top.location='logout.php';</script>";
     }
     include 'connection.php';
     session_start();
     if(!isset($_SESSION['uid']) || $_SESSION['uid'] == "") {
          echo "<script type='text/javascript'>window.top.location='login.php';</script>";
     }
     $upque = "UPDATE ticket_mst SET vView='YES' WHERE iId='".$_REQUEST['tid']."'";
     mysql_query($upque);
     $select = "SELECT tm.*,um1.vFname as sendfname,um1.vLname as sendlname FROM ticket_mst tm
               LEFT JOIN user_mst um1 ON tm.iSenderId=um1.iId WHERE tm.iId='".$_REQUEST['tid']."'";
     $result = mysql_query($select);
     $row = mysql_fetch_assoc($result);
     $description = "";
     $selectthread = "SELECT * FROM tick_ans ta LEFT JOIN user_mst um ON um.iId=ta.iUserId WHERE ta.iTickId='".$_REQUEST['tid']."' ORDER BY ta.tCreateOn DESC";
     $threadresult = mysql_query($selectthread);
     while($threadrow = mysql_fetch_assoc($threadresult)){
          $description .= $threadrow['vFname']." ".$threadrow['vLname']." schrieb am ".date("d.m.Y",strtotime($threadrow['tCreateOn']))." um ".date("H:m",strtotime($threadrow['tCreateOn']))." :&#13;&#10;&#13;&#10;";
          $description .= $threadrow['vAnswer'];
          $description .= "&#13;&#10;_____________________________________________________________&#13;&#10;&#13;&#10;";    
     }
     $description .= $row['sendfname']." ".$row['sendlname']." schrieb am ".date("d.m.Y",strtotime($row['tCreateDate']))." um ".date("H:m",strtotime($row['tCreateDate']))." :&#13;&#10;&#13;&#10;";
     $description .= $row['tMatterConcern'];
     //echo "<pre>";
     //print_r($row);exit;
?>
<form action="" class="full validate" method="post" enctype="multipart/form-data">
     <fieldset>
          <legend>Ticket von <?=$row['sendfname']." ".$row['sendlname']?> erstellt am <?=date("d.m.Y",strtotime($row['tCreateDate']))?> zuletzt bearbeitet am <?=date("d.m.Y",strtotime($row['dEditDate']))?></legend>
		<div class="row">
			<label for="betreff">
				<strong>Betreff</strong>
			</label>
			<div>
				<input type="text" readonly placeholder="CONTENT FROM DB" value="<?=$row['vSubject']?>" name="betreff" id="betreff" />
			</div>
		</div>
		<input type="hidden" value="<?=$row['iId']?>" name="tid" id="tid" />
		<div class="row">
			<label for="anliegen">
				<strong>Anliegen</strong>
			</label>
			<div>
				<textarea rows=6 readonly placeholder="CONTENT FROM DB" name="anliegen" id="anliegen"><?=$description?></textarea>
			</div>
		</div>
		<div class="row">
			<label for="antwort">
				<strong>Antwort</strong>
			</label>
			<div>
				<textarea required rows=5 placeholder="Bitte gib Deine Antwort in dieses Feld ein......" name="antwort" id="antwort"></textarea>
			</div>
		</div>					

		<div class="row not-on-phone">
			<label for="f6_file">
				<strong>Anhang</strong>
			</label>
			<div class="customfile">
				<!--<input type="file" id=f6_file name=f6_file />-->
				<div class="customfile customfile-hover">
				<input data-buttontext="Durchsuchen" type="file" id="f6_file" name="f6_file" class="customfile-input-hidden ready" style="left: 0; margin: 0px;z-index: 20000;width: 100%;">
				<div class="customfile-input">
					<span class="customfile-button" aria-hidden="true">Durchsuchen</span>
					<span class="customfile-feedback" aria-hidden="true">Keien Datei ausgewählt...</span>
				</div>
			</div>
			</div>
		</div>
		<div class="row">
			<label for="status">
				<strong>Ticket Status</strong>
			</label>
			<div>
				<select name=status id=status >
					<option selected value="Open" <?=$row['vStatus']=="Open"?"Selected":""?>>Offen</option> 
					<option value="Close" <?=$row['vStatus']=="Close"?"Selected":""?>>Geschlossen</option> 
				</select>
			</div>
		</div>
		<div class="actions">
			<div class="left">
				<button class="grey cancel">abbrechen</button>
			</div>
			<div class="right">
				<input type="submit" value="Antworten" name=send />
			</div>
		</div><!-- End of .actions -->
	</fieldset><!-- End of fieldset -->
</form>
