<?php
     session_start();
     $_SESSION['uid'] = NULL;
     $_SESSION['uname'] = NULL;
     $_SESSION['utype'] = NULL;
     $_SESSION['view'] = NULL;
     unset($_SESSION['uid']);
     unset($_SESSION['uname']);
     unset($_SESSION['utype']);
     unset($_SESSION['view']);
     header("location:login.php");
?>