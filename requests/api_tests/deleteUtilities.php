<?php

// Bootstrap
header("Content-Type: application/json");
require_once "../../Models/Role.php";
session_start();
spl_autoload_register(function ($className) {
    require_once "../../Models/lib/$className.php";
});


if ($succeeded = Authorisation::hasAuth("edit")) {
  //  $data = API::deleteUtilities("5e1602e51c7a63001279fb0b");
    $data = "utilityies deleted";
    echo json_encode($data);
} else {
    $data = new stdClass();
    $data->error = "You do not have authorisation for this";
    echo json_encode($data);
}

SessionLog::createLog([
    "endpoint" => "Utilities - Delete",
    "succeeded" => $succeeded ? 1 : 0
]);

