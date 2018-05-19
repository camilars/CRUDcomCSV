<?php

include 'init-secure.php';

if (isset($_POST['category'])) {
    $category = $_POST['category'];
    addUserCategory(currentUser(), $category);
}
redirect('index.php');

?>