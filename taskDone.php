<?php

include 'init-secure.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    setUserTaskDone(currentUser(), $id);
}

redirect('index.php');

?>