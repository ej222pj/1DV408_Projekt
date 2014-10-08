<?php

require_once('/Register_Login/LoginHTMLView.php');

//HTML basklass
class HTMLView {
	
	private $loginView;
	
	public function __construct(){
		$this->loginView = new LoginHTMLView();
	}
	
	public function echoHTML($login) {
		echo "
				<!DOCTYPE html>
				<html>
				<head>
					<meta charset=UTF-8>
					<title>EJ222PJ Register</title>
				</head>
				<body>
					$login
					$this->loginView
				</body>
				</html>
		";
	}
}