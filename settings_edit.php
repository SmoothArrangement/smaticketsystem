<?php
     if(!isset($_REQUEST['tid']) || $_REQUEST['tid'] == "") {
          echo "<script type='text/javascript'>window.top.location='logout.php';</script>";
     }
     include 'connection.php';
     session_start();
     if(!isset($_SESSION['uid']) || $_SESSION['uid'] == "") {
          echo "<script type='text/javascript'>window.top.location='login.php';</script>";
     }
     $select = "SELECT * FROM email_template WHERE iId='".$_REQUEST['tid']."'";
     $result = mysql_query($select);
     $row = mysql_fetch_assoc($result);
     echo json_encode($row);
?>