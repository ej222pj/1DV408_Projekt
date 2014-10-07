<?php

//Starta en ny session
session_start();

require_once("HTMLView.php");
require_once("Controller.php");

//Skapar ny controller
$lc = new Controller();
$HTMLBody = $lc->doLogin();

//Skapar ny HTMLView
$view = new HTMLView();
$view->echoHTML($HTMLBody);