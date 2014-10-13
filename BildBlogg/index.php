<?php

//Starta en ny session
session_start();

require_once("HTMLView.php");
require_once("controller/BlogController.php");

//Skapar ny controller
$c = new \controller\BlogController();
$HTMLBody = $c->BlogControl();

//Skapar ny HTMLView
$view = new HTMLView();
$view->echoHTML($HTMLBody);