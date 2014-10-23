<?php

//HTML basklass
class HTMLView {
	public function echoHTML($body) {
		echo "
		<!DOCTYPE html>
		<html>
			<head>
				<meta charset=UTF-8>
				<link rel='stylesheet' type='text/css' href='style.css?parameter=1'>
				<title>EJ222PJ Projekt</title>
			</head>
			<body>
				<div id='container'>
					$body
				</div>
			</body>
		</html>
		";
	}
}