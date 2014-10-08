<?php

//HTML basklass
class HTMLView {
	
	public function echoHTML($body) {
		echo "
				<!DOCTYPE html>
				<html>
				<head>
					<meta charset=UTF-8>
					<link rel='stylesheet' type='text/css' href='css/style.css'>
					<title>EJ222PJ Projekt</title>
				</head>
				<body>
					$body
				</body>
				</html>
		";
	}
}