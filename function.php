<?php
require_once 'db.php';


function dd($var, $die = true) { //функция для выявления ошибок аналог vardump
    echo '<pre>' . print_r($var, true) . '</pre>';
    if ($die) die;
}

function redirect($url) { // функция для редиректа на любую из заданных страниц, получает $url 
    header ('location: /' .$url);
    exit;
}

function requestData($request) {
    //Функцция получает данные из массива $_POST 
        $data = []; //Объявляю пустой массив $data
        foreach ($request as $key => $value) { //Прогоняю данные из массива через цикл, 
                                               //что бы получить динамические данные
            if ($key == 'password') { //Если в $key попадает $password записываю в $data хешированный пароль
                $data['passHash'] = password_hash($value, PASSWORD_DEFAULT);
                //continue;
            }
            $data[$key] = htmlentities(trim($value));//Универсальная переменная содержащая полученные данные через $_POST 
        }
        //dd($data);
    return $data;
}

function errMessage($message) {
    //Функция вывода сообщений из сессии принимает строку записывает её в сессию выводит html вёрстку
    //в нужное для меня поле, используется под полями форм для вывода ошибок
    if (isset($_SESSION[$message])) {
        
        echo "<span class='invalid-feedback' role='alert'><strong> {$_SESSION[$message]} </strong></span>";
        unset($_SESSION[$message]);
    }
    
}

// Функция ззагрузки изображения, принимает $image = $_FILES, $image_user = $_SESSION['image']
function imgUpload($image, $image_user, $validate)
{
    //dd($image);
    if (!$validate) { // Если НЕ валидация
        return false; // Возвращаем false
    }
    if (!empty($image['name'])) { // Если существует $image

        $uploadDir = __DIR__ . '\\img\\'; // Создаю дерикторию файла

        $avialabelExtention = ['jpg', 'svg', 'png', 'gif']; // Массив с допустимыми расширениями

        $extention = pathinfo($image['name'], PATHINFO_EXTENSION); // Получаю расширение файла

        $filename = uniqid() . "." . $extention; // Задаю уникальное имя файла и присваиваю его переменной


        if ($_FILES['image']['error'] > 0 && $_FILES['image']['error'] != 4) {

            $_SESSION['errImg'] = 'При загрузке произошла ошибка';
            return false;
        }

        if (!in_array($extention, $avialabelExtention)) {

            $_SESSION['errImg'] = 'Неверное расширение, для загрузки используйте: ' . implode(', ', $avialabelExtention);
            return false;
        }


        if ($image_user != 'no-user.jpg') {

            unlink($uploadDir . $image_user);
        }
        move_uploaded_file($image['tmp_name'], 'img/' . $filename);

        return $filename;
    }

    return $_SESSION['user_img'];
}

/* function getComments($pdo) {//функция вывода комментариев

    //Объединяю таблицы для вывода имени аторизованного пользователя, текста и даты комментария 
    $comments = $pdo->query('SELECT * FROM `newsmodul` WHERE 1')->fetchAll();

     return $comments;
} */

function paginator($pdo)
{

    $paginator = [];
    // кол-во ссылок по правую и левую сторону от активной
    $numLinks = 2;
    // получаем текущую страницу
    $paginator['currentPage'] = isset($_GET['page']) ? $_GET['page'] <= 0 ? 1 : $_GET['page'] : 1;
    // кол-во записей на одной странице
    $paginator['perPage'] = 2;
    // смещение для запроса в бд
    $paginator['offset'] = ($paginator['perPage'] * $paginator['currentPage']) - $paginator['perPage'];
    // префикс для ссылки
    $paginator['link'] = '/?page=';
    // получить все комменты для пагинации со смещением
    $paginator['comments'] = getAllComsForPaginate($pdo, $paginator['offset'], $paginator['perPage']);
    // полусить кол-во всех комментов в бд
    $paginator['commentsCount'] = count(getAllComments($pdo));
    // получить кол-во страниц
    $paginator['pageCount'] = ceil($paginator['commentsCount'] / $paginator['perPage']);
    // стартовое значения для цикла вывода комментов
    $paginator['start'] = (($paginator['currentPage'] - $numLinks) > 0) ? $paginator['currentPage'] - $numLinks : 1;
    // конечное значения для цикла вывода комментов
    $paginator['end'] = (($paginator['currentPage'] + $numLinks) < $paginator['pageCount']) ? $paginator['currentPage'] + $numLinks : $paginator['pageCount'];

    return $paginator;
}

/**
 * Получение всех комментариев из базы
 *
 * @param [object] $pdo
 * @return array
 */
function getAllComments($pdo)
{
   
    // формируем sql-запрос
    $sql = "SELECT * FROM newsmodul";
    // выполняем sql-запрос
    $stmt = $pdo->query($sql);
    // формируем ассоциативный массив полученных данных
    $row = $stmt->fetchAll();
    // возвращаем массив
    //dd($row);
    return $row;
}


/**
 * Получить все комментарии для пагинации
 *
 * @param [object] $pdo
 * @param [integer] $offset
 * @param [integer] $limit
 * @return array
 */
function getAllComsForPaginate($pdo, $offset, $limit)
{

    
    $sql = "SELECT * FROM newsmodul ORDER BY newsmodul.id DESC LIMIT $offset,$limit";
    //dd($sql);
    // выполняем sql-запрос
    $stmt = $pdo->query($sql);
    // формируем ассоциативный массив полученных данных
    $row = $stmt->fetchAll();
    // возвращаем массив
    
    return $row;
}