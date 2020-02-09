<?php
require_once 'db.php';


function dd($var, $die = true) { //функция для выявления ошибок аналог vardump
    echo '<pre>' . print_r($var, true) . '</pre>';
    if ($die) die;
}

function redirect($http = false)
{
    if ($http) {
        $redirect = $http;
    } else {
        $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';
    }
    header("Location: {$redirect}");
    exit();
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



function paginator($pdo, string $page = null)
{

    $paginator = [];
    // кол-во ссылок по правую и левую сторону от активной
    $numLinks = 2;
    // получаем текущую страницу
    $paginator['currentPage'] = isset($_GET['page']) ? $_GET['page'] <= 0 ? 1 : $_GET['page'] : 1;
    // кол-во записей на одной странице
    $paginator['perPage'] = 3;
    // смещение для запроса в бд
    $paginator['offset'] = ($paginator['perPage'] * $paginator['currentPage']) - $paginator['perPage'];
    // префикс для ссылки
    $paginator['link'] = '/?page=';
    if ($page == 'admin') {
        // получить все новости для пагинации со смещением
        $paginator['task'] = getAllComsForPaginate($pdo, $paginator['offset'], $paginator['perPage'] );
        // полусить кол-во всех новостей в бд
        $paginator['taskCount'] = count(getAllComments($pdo));
    } else {
        //условие для index.php
        $paginator['task'] = getAllComsForPaginate($pdo, $paginator['offset'], $paginator['perPage'], 'ok = 0');
        $paginator['taskCount'] = count(getAllComments($pdo, 'ok = 0'));
    }
    
    // получить кол-во страниц
    $paginator['pageCount'] = ceil($paginator['taskCount'] / $paginator['perPage']);
    // стартовое значения для цикла вывода новостей
    $paginator['start'] = (($paginator['currentPage'] - $numLinks) > 0) ? $paginator['currentPage'] - $numLinks : 1;
    // конечное значения для цикла вывода новостей
    $paginator['end'] = (($paginator['currentPage'] + $numLinks) < $paginator['pageCount']) ? $paginator['currentPage'] + $numLinks : $paginator['pageCount'];

    return $paginator;
    
}

function getAllComments($pdo, $where = null)
{   
    $sql = "SELECT * FROM taskList ";
    if ($where) {
        $sql .= "WHERE {$where} ";
    }
    // формируем sql-запрос
    $sql .= "ORDER BY id DESC";
    // выполняем sql-запрос
    $stmt = $pdo->query($sql);
    // формируем ассоциативный массив полученных данных
    $row = $stmt->fetchAll();
    // возвращаем массив
    //dd($row);
    return $row;
}
//dd(getAllComments($pdo, $where = null));

function getAllComsForPaginate($pdo, $offset, $limit, $where = null)
{
    $sql = "SELECT * FROM taskList ";
    if ($where) {
        $sql .= "WHERE {$where} ";
    }
    $sql .= "ORDER BY id DESC LIMIT $offset,$limit";
    //dd($sql);
    // выполняем sql-запрос
    $stmt = $pdo->query($sql);
    // формируем ассоциативный массив полученных данных
    $row = $stmt->fetchAll();
    // возвращаем массив 
    return $row;
}

