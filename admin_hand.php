<?php
require_once 'db.php';
require_once 'function.php';

if (isset($_POST['show'])) {
    $sql = 'UPDATE taskList SET ok = 0 WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $_POST['show']]);

    redirect();
}

if (isset($_POST['skip'])) {
    $sql = 'UPDATE taskList SET ok = 1 WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $_POST['skip']]);

    redirect();
}

if (isset($_POST['delete'])) {
    $sql = 'DELETE FROM taskList WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $_POST['delete']]);

    redirect();
}