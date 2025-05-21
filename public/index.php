<?php
session_start();
define("WEBROOT", "http://mouhamed.sy.ecole221.sn:8000/");
require_once "../app/route/route.web.php";
loadController($controllers);
