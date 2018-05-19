<?php

include 'init-secure.php';

$data = getUserTasks(currentUser());
$data = array_map(function($el) {
    $task = explode(DATA_SEPARATOR, $el);
    return ['name' => $task[0], 'category' => $task[1], 'status' => $task[2]];
}, $data);

$todo_tasks = array_filter($data, function($el) {
    return $el['status'] == 'todo';
});

$done_tasks = array_filter($data, function($el) {
    return $el['status'] == 'done';
});

$categories = getUserCategories(currentUser());
sort($categories);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Minha lista de tarefas</h1>
    <p>Usuário: <?= currentUser() ?> | <a href="logout.php">Sair</a></p>
    <table>
        <tr>
            <th>Tarefa</th>
            <th>Categoria</th>
            <th>Ações</th>
        </tr>
        <?php foreach ($todo_tasks as $id => $task): ?>
            <tr>
                <td class="todo"><?= $task['name'] ?></td>
                <td class="todo"><?= $task['category'] ?></td>
                <td class="action">
                    <a href="taskDone.php?id=<?= $id ?>">&#10004;</a>
                </td>
            </tr>
        <?php endforeach ?>
        <?php foreach ($done_tasks as $id => $task): ?>
            <tr>
                <td class="done"><?= $task['name'] ?></td>
                <td class="done"><?= $task['category'] ?></td>
                <td class="action">
                    <a href="rmTask.php?id=<?= $id ?>">&#10007;</a>
                </td>
            </tr>
        <?php endforeach ?>
        <form action="addTask.php" method="POST">
            <tr>
                <td><input type="text" name="title" placeholder="Tarefa" required></td>
                <td>
                    <select name="category" required>
                        <option disabled="" selected>Categoria</option>
                        <option disabled="">--</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category ?>"><?= $category ?></option>
                        <?php endforeach ?>
                    </select>
                </td>
                <td class="action"><input type="submit" value="ok"></td>
            </tr>
        </form>
    </table>
    <form action="addCategory.php" method="POST">
        <input type="text" name="category" placeholder="Nova Categoria">
        <input type="submit" value="ok">
    </form>
</body>
</html>