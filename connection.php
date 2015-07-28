<?php   
     error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED ^ E_WARNING);     
     $connect = mysql_connect('localhost', 'ticketsystem', 'Pcd&03021980');     
     mysql_select_db('ticketsystem', $connect);
?>