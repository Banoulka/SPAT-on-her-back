<?php

// Bootstrap
session_start();
spl_autoload_register(function ($className) {
    require_once "Models/lib/$className.php";
});

require_once "Models/Role.php";
require_once "Models/Group.php";
require_once "Models/User.php";

//$input = [
//    "currentFilter" => "username",
//    "currentOrder" => "desc",
//];
//
//var_dump(SessionLog::sortLogs($input));
//die();

if (Authentication::isLoggedIn() && Authentication::User()->isAdmin()) {

    if (isset($_POST["uid"])) {
        $user = User::findByID($_POST["uid"]);
        $data = [
            "username" => htmlentities($_POST["username"]),
            "userID" => htmlentities($_POST["uid"]),
            "roleID" => htmlentities($_POST["role"]),
            "groupIDs" => htmlentities($_POST["gids"])
        ];
        $user->updateDetails($data);
        Route::redirect("adminDashboard.php?tab=manageUsers#users");
    }

    $users = User::getAllusers();

    $page = "manageRoles";
    if (isset($_GET["tab"])) {
        $page = $_GET["tab"];
    }
    if (isset($_POST["createGroup"])) {
        Group::addGroup(htmlentities($_POST["group_name"]));
    } elseif (isset($_POST["createRole"])) {
        Role::addRole(htmlentities($_POST["role_name"]));
    } elseif (isset($_POST["deleteGroup"]) && isset($_POST["groupID"])) {
        Group::removegroup($_POST["groupID"]);
    } elseif (isset($_POST["deleteRole"]) && isset($_POST["roleID"])) {
        Role::removeRole($_POST["roleID"]);
    } elseif (isset($_POST["addUser"])) {
        $formData = [
            "username" => htmlentities($_POST["username"]),
            "password" => htmlentities($_POST["password"]),
        ];

        //TODO:: Validation
        User::createUser($formData);
        $message = "User created successfully";

    } elseif (isset($_POST["group-change"])) {
        // Manage change
        $group = Group::groupByID($_POST["team-id"]);
        if ($group) {
            $group->updateGroup(htmlentities($_POST["team-name"]));
        }
        Route::redirect("adminDashboard.php?tab=manageTeams");
    }

    require_once "Views/adminDashboard.phtml";
} else {
    require_once "Views/errorPage.phtml";
}