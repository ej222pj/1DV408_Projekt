<?php

require_once("./HTMLView.php");
require_once("Controller.php");

//Skapar ny controller
$c = new Controller();
$HTMLBody = $c->doLogin();

//Skapar ny HTMLView
$view = new HTMLView();
$view->echoHTML($HTMLBody);

