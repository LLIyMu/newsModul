<?php
require_once 'db.php';
require_once 'function.php';

//вызываю функцию которая принимает и обрабатывает массив $_POST применяется htmlentities и trim,
// туда попадает $name, $email а потом меняются в БД если проходят валидацию 
$data = requestData($_POST);

//dd(requestData($_POST));

$validate = 1; // переменная состояния валидации

if (empty($data['name'])) {
    $_SESSION['nameErr'] = 'введите ваше имя';
    $validate = 0;
    redirect('create.php');
}

if (!preg_match('#^([a-z0-9_.-]{1,20}+)@([a-z0-9_.-]+)\.([a-z\.]{2,10})$#', $data['email'])) {

    $_SESSION['emailErr'] = 'Укажите правильный email'; //зписываю сообщение об ошибке в сессию
    $validate = 0;                                      //валидация не пройдена(false)
}

if (empty($data['email'])) {
    $_SESSION['emailErr'] = 'введите ваш email';
    $validate = 0;
    redirect('create.php');
}

if (empty($data['text'])) {
    $_SESSION['textErr'] = 'введите текст задачи';
    $validate = 0;
    redirect('create.php');
}

if($validate == 1) { //если валидация пройдена (true)
    
    //dd($data);
    $sql = 'INSERT INTO `taskList` (`name`, `email`, `text`) VALUES (:name, :email, :text)';
    $values = ['name' => $data['name'], 'email' => $data['email'], 'text' => $data['text']]; //подготавливаю запрос к БД и меняю name или email
    $stmt_up = $pdo->prepare($sql);                 //подготавливаю запрос (защита от sql-инъекций)
    $stmt_up->execute($data);                       //выполнение запроса
    
    $_SESSION['taskSucces'] = 'Задача добавлена';  
    }
redirect('create.php');
