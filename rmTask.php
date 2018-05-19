<?php

include 'init-secure.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    removeUserTask(currentUser(), $id);
}

redirect('index.php');

?>