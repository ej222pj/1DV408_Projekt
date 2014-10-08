<?php

require_once("./HTMLView.php");
require_once("BlogController.php");

//Skapar ny controller
$bc = new BlogController();
$HTMLBody = $bc->BlogControl();

//Skapar ny HTMLView
$view = new HTMLView();
$view->echoHTML($HTMLBody);