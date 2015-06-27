<?php
     include 'connection.php';
     session_start();
     $pass = $_REQUEST['val'];
     $pass = base64_encode($pass);
     $select = "SELECT * FROM user_mst WHERE iId='".$_SESSION['id']."' AND vPassword='".$pass."'";
     $result = mysql_query($select); 
     if(mysql_num_rows($result) >= 1){
          $row = mysql_fetch_assoc($result);
          $_SESSION['uid'] = $row['iId'];
          $_SESSION['uname'] = $row['vFname']." ".$row['vLname'];
          $_SESSION['utype'] = $row['vUserType'];
          echo "Yes";
     } else {
          echo "No";
     }  
?>