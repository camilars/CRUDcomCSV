<?php

include 'init-secure.php';

if (isset($_POST['title']) && isset($_POST['category'])) {
    $title = $_POST['title'];
    $category = $_POST['category'];
    $data = implode(DATA_SEPARATOR, [$title, $category, 'todo']);
    addUserTask(currentUser(), $data);
}
redirect('index.php');

?>