<?php

//HTML basklass
class HTMLView {
	public function echoHTML($body) {
		echo "
				<!DOCTYPE html>
				<html>
				<head>
					<meta charset=UTF-8>
					<title>EJ222PJ Register</title>
				</head>
				<body>
					$body
				</body>
				</html>
		";
	}
}