<?php
require_once 'db.php';
require_once 'function.php';

//вызываю функцию которая принимает и обрабатывает массив $_POST применяется htmlentities и trim,
// туда попадает $name, $email а потом меняются в БД если проходят валидацию 
$data = requestData($_POST);

//dd(requestData($_POST));
$image = $_FILES['image']; // записываю в переменную данные о полученной картинке
$image_user = $_SESSION['user_img'];

$validate = 1; // переменная состояния валидации

if (empty($data['title'])) {
    $_SESSION['titleErr'] = 'поле не должно быть пустым';
    $validate = 0;
    redirect('create.php');
}

if (empty($data['date'])) {
    $_SESSION['dateErr'] = 'укажите дату';
    $validate = 0;
    redirect('create.php');
}

if (empty($data['text'])) {
    $_SESSION['textErr'] = 'введите текст';
    $validate = 0;
    redirect('create.php');
}

if (empty($data['anons'])) {
    $_SESSION['anonsErr'] = 'введите анонс';
    $validate = 0;
    redirect('create.php');
}

if (false === $img_data = imgUpload($image, $image_user, $validate))  {
    
    $validate = 0;
} else {
    $data['image'] = $img_data;
}

if($validate == 1) { //если валидация пройдена (true)
    
    //dd($data);
    $sql = 'INSERT INTO `newsmodul` (`title`, `anons`, `text`, `image`, `date`) VALUES (:title, :anons, :text, :image, :date)';
    $values = ['title' => $data['title'], 'anons' => $data['anons'], 'text' => $data['text'], 'image' => $data['image'], 'date' => $data['date']]; //подготавливаю запрос к БД и меняю name или email
    $stmt_up = $pdo->prepare($sql);                 //подготавливаю запрос (защита от sql-инъекций)
    $stmt_up->execute($data);                       //выполнение запроса
    
    $_SESSION['newsSucces'] = 'Новость добавлена';  

    }
redirect('create.php');
