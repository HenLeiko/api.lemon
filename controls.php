<?php
function getOptions($function, $select, $connection)
{
    if ($function == 'users') {
        if (isset($select)) {
            getUser($select, $connection);
        } else {
            getUsers($connection);
        }

    }
    if ($function == 'data') {
        if (isset($select)) {
            getData($select, $connection);
        } else {
            getDats($connection);
        }
    }
}

function postOptions($function, $select, $data, $connection)
{
    if ($function == 'users') {
        if (isset($select)) {
            $response = [
                'status' => 404,
                'response' => '404 page not found'
            ];
            die(json_encode($response));
        } else {
            $data = $_POST;
            addUser($data, $connection);
        }
    }
}

function getDats($connection){
    $dats = mysqli_query($connection, "SELECT * FROM `data`");
    if (isset($dats)) {
        while ($data = mysqli_fetch_assoc($dats)) {
            $allDats[] = $data;
        }
        die(json_encode($allDats));
    } else {
        http_response_code(404);
        $response = [
            'status' => 404,
            'response' => '404 page not found'
        ];
        die(json_encode($response));
    }
}

function getUser($select, $connection)
{
    $user = mysqli_query($connection, "SELECT * FROM `users` WHERE `login` = '$select'");
    if (!isset($user)) {
        http_response_code(404);
        $response = [
            'status' => 404,
            'response' => '404 page not found'
        ];
        die(json_encode($response));
    } else {
        $user = mysqli_fetch_assoc($user);
        echo json_encode($user);
    }
}

function getUsers($connection)
{
    $allUsers = [];
    $users = mysqli_query($connection, "SELECT * FROM `users`");
    if (isset($users)) {
        while ($user = mysqli_fetch_assoc($users)) {
            $allUsers[] = $user;
        }
        die(json_encode($allUsers));
    } else {
        http_response_code(404);
        $response = [
            'status' => 404,
            'response' => '404 page not found'
        ];
        die(json_encode($response));
    }
}

function addUser($data, $connection)
{
    header("Content-type: application/json");
    // $data = json_decode(file_get_contents('php://input'), true);
    $login = $_POST['login'];
    $password = $_POST['password'];
    $result = mysqli_query($connection, "INSERT INTO `users` (`login`, `password`) VALUES ('$login', '$password')");
    http_response_code(201);
    $response = [];
    $response['success'] = true;
    die(json_encode($response));
}

