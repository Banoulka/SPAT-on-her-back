<?php
session_start();
spl_autoload_register(function ($className) {
    require_once "Models/lib/$className.php";
});
require_once "Views/login.phtml";