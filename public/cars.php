<?php
require_once "config.php";
require_once "controller/Core.php";
require_once "model/Model.php";

$model = new Model();
$model->checkAuthorization();

$core = new Core();
$core->nameOption = $_GET['option'];
$core->getBody();
?>