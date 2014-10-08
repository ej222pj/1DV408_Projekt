<?php

//Starta en ny session
session_start();

require_once("LoginHTMLView.php");
require_once("Controller.php");

//Skapar ny controller
$lc = new Controller();
$HTMLBody = $lc->doLogin();

//Skapar ny HTMLView
$view = new LoginHTMLView();
$view->echoHTML($HTMLBody);