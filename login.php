<?php

include 'init.php';

$wrongData = false;

if (isset($_POST['user']) && isset($_POST['pw'])) {
    $user = $_POST['user'];
    $pw = $_POST['pw'];

    if (login($user, $pw)) {
        redirect('index.php');
    } else {
        flash('wrong.data');
        redirect('login.php');
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Login</h1>
    <?php if (getFlash() !== false): ?>
        <?php if (getFlash() == 'wrong.data'): ?>
            <span style="color: red">Dados incorretos.</span>
        <?php elseif (getFlash() == 'user.registered'): ?>
            <span style="color: blue">Usuário registrado com sucesso</span>
        <?php endif ?>
    <?php endif ?>
    <form method="POST">
        <input type="text" name="user" placeholder="User">
        <input type="password" name="pw" placeholder="Password">
        <br>
        <input type="submit">
    </form>
    <a href="register.php">Cadastre-se</a>
</body>
</html>