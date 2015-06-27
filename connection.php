<?php   
     error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED ^ E_WARNING);     
     $connect = mysql_connect('localhost', 'root', '');     
     mysql_select_db('ticketsystem', $connect);
?>