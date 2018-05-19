<?php

session_start();

define('USERS_FILE', 'users.csv');
// define('DATA_FILE', 'data.txt');
define('DATA_SEPARATOR', ';;;');




// verifica se esta logado
function is_logged() {
    return isset($_SESSION['user']);
}

// salva os dados em um array e guarda a variável $user na session
function login($user, $pw) {
    $usersData = file(USERS_FILE);
    $usersData = array_map(function($el) {
        return trim($el);
    },
    $usersData);
    $pw = md5($pw);

    if (in_array($user . ':' . $pw, $usersData)) {
        $_SESSION['user'] = $user;
        return true;
    }
    return false;
}

// encerra a session
function logout() {
    unset($_SESSION['user']);
}

// retorna a variavel se ela existir
function currentUser() {
    if (isset($_SESSION['user'])) {
        return $_SESSION['user'];
    }
    return false;
}




// redireciona para uma página
function redirect($page) {
    header('location: ' . $page);
    exit();
}





function flash($msg) {
    $_SESSION['flash'] = $msg;
    $_SESSION['setFlash'] = true;
}

function getFlash() {
    $msg = false;
    if (isset($_SESSION['flash']) && !empty($_SESSION['flash'])) {
        $msg = $_SESSION['flash'];
    }
    return $msg;
}

register_shutdown_function(function() {
    if (isset($_SESSION['setFlash'])) {
        unset($_SESSION['setFlash']);
        return;
    }
    if (isset($_SESSION['flash'])) {
        unset($_SESSION['flash']);
    }
});






function getUsers() {
    $fileData = file(USERS_FILE);
    $users = array_map(function($el) {
        return explode(':', $el)[0];
    }, $fileData);
    return $users;
}

function addUser($user, $pw) {
    $data = $user . ':' . md5($pw);
    addRegister(USERS_FILE, $data);
}



function filename($prefix, $user) {
    $fileName = $prefix . $user . '.csv';
    if (!file_exists($fileName)) {
        touch($fileName);
    }
    return $fileName;
}

function tasksFilename($user) {
    return fileName('data/', $user);
}

function categoriesFilename($user) {
    return fileName('categories/', $user);
}



function getFileData($fileData) {
    if (!$fileData) {
        $fileData = array();
    }
    return array_map(function($el) {
        return trim($el);
    }, $fileData);
}

function getUserTasks($user) {
    $fileData = file(tasksFilename($user));
    return getFileData($fileData);
}

function getUserCategories($user) {
    $fileData = file(categoriesFilename($user));
    return getFileData($fileData);
}



function addUserTask($user, $data) {
    addRegister(tasksFilename($user), $data);
}

function addUserCategory($user, $data) {
    addRegister(categoriesFilename($user), $data);
}

function addRegister($fileName, $data) {
    if (!file_exists($fileName)) {
        touch($fileName);
    }

    $fileData = file($fileName);
    $fileData[] = $data . "\n";
    file_put_contents($fileName, implode('', $fileData));
}



function setUserTaskDone($user, $id) {
    $fileName = tasksFilename($user);

    $fileData = file($fileName);

    $fileData[$id] = explode(DATA_SEPARATOR, $fileData[$id]);
    $fileData[$id][2] = "done\n";
    $fileData[$id] = implode(DATA_SEPARATOR, $fileData[$id]);

    file_put_contents($fileName, implode('', $fileData));
}



function removeUserTask($user, $id) {
    $fileData = file(tasksFilename($user));
    unset($fileData[$id]);
    file_put_contents(tasksFilename($user), implode('', $fileData));
}



?>