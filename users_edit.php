<?php
     if(!isset($_REQUEST['uid']) || $_REQUEST['uid'] == "") {
          echo "<script type='text/javascript'>window.top.location='logout.php';</script>";
     }
     include 'connection.php';
     session_start();
     if(!isset($_SESSION['uid']) || $_SESSION['uid'] == "") {
          echo "<script type='text/javascript'>window.top.location='login.php';</script>";
     }
     $select = "SELECT * FROM user_mst WHERE iId='".$_REQUEST['uid']."'";
     $result = mysql_query($select);
     $row = mysql_fetch_assoc($result);
     //echo "<pre>";
     //print_r($row);exit;
?>
<form action="" class="full validate" method="post">
     <fieldset>
          <div class="row">
                <label for="d2_username">
                    <strong>Vorname</strong>
                </label>
                <div>
                    <input required value="<?=$row['vFname']?>" type=text name=d2_fname id=d2_fname />
                </div>
            </div>
            <input type="hidden" value="<?=$_REQUEST['uid']?>" id="uid" name="uid" />
            <div class="row">
                <label for="d2_username">
                    <strong>Nachname</strong>
                </label>
                <div>
                    <input required value="<?=$row['vLname']?>" type=text name=d2_lname id=d2_lname />
                </div>
            </div>
            <div class="row">
                <label for="d2_email">
                    <strong>E-Mail-Adresse</strong>
                </label>
                <div>
                    <input required value="<?=$row['vEmail']?>" type=email name=d2_email id=d2_email />
                </div>
            </div>
            <div class="row">
                <label for="d2_email">
                    <strong>Passwort</strong>
                </label>
                <div>
                    <input type=password name=d2_pass id=d2_pass />
                </div>
            </div>
            <div class="row">
		        <label for="status">
	                   <strong>Benutzerstatus</strong>
		        </label>
			<div>
				<select name=status id=status >
					<option value="2" <?=$row['vUserType']=="2"?"Selected":""?>>User</option>
                         <option value="3" <?=$row['vUserType']=="3"?"Selected":""?>>Admin</option> 
				</select>
			</div>
		  </div>
            <div class="actions">
                <div class="left">
                    <button class="grey cancel">stornieren</button>
                </div>
                <div class="right">
                    <button type="submit" id="edit" name="edit">registrieren</button>
                </div>
            </div><!-- End of .actions -->
	</fieldset><!-- End of fieldset -->
</form>