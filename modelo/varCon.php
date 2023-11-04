<?php

function varCon($dato){

$server = $_SERVER['HTTP_HOST'];

if($server == "localhost"){
	
	$user = "root"; //database username
	$pass = "101299"; //database password
	$db = "csetpro"; //database name	
	$host = "localhost"; //database location		
	
	}else if($server == "www.csetpro.16mb.com" or $server == "csetpro.16mb.com"){
		
	$user = "u156335646_root"; //database username
	$pass = "csetpro"; //database password
	$db = "u156335646_cp"; //database name	
	$host = "mysql.hostinger.co"; //database location		

	}else if($server == "10.71.252.80"){
		
	$user = "root"; //database username
	$pass = "root123"; //database password
	$db = "csetpro"; //database name	
	$host = "10.71.252.80"; //database location	

	}else {
		
	$user = "root"; //database username
	$pass = "101299"; //database password
	$db = "csetpro"; //database name	
	$host = "localhost"; //database location	

	}
	
	switch ($dato) {
		case "user":
			return $user;
		break;
			
		case "pass":
			return $pass;
		break;
			
		case "db":
			return $db;
		break;
			
		case "host":
			return $host;
		break;
			
		default:
			return "error en el dato ";
		break;
		}
	}
?>