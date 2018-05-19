<?php

include 'init.php';
if (!is_logged()) {
    redirect('login.php');
}

?>