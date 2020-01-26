<?php error_reporting(-1); ?>
<?php
require_once 'db.php';
require_once 'function.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Новости</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Styles -->
    <link href="css/app.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>

<body class="bg-dark">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="index.php">
                    Новостной блог
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">                    
                        <a class="btn btn-success" href="admin.php">Админ панель</a>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4 bg-dark">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3>Добавить новость</h3>
                            </div>

                            <div class="card-body">
                                <div class="alert alert-success <? if (empty($_SESSION['newsSucces'])) : echo 'd-none' ?><? endif; ?>" role="alert">
                                    <?= //Добавляю сообщение о добавлении комментария
                                        $_SESSION['newsSucces'];
                                    unset($_SESSION['newsSucces']);
                                    ?>

                                </div>
                                <form action="createHand.php" method="post" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="exampleFormControlInput1">Заголовок</label>
                                                <input type="text" class="form-control <? if (isset($_SESSION['titleErr'])) : ?> is-invalid<? endif; ?>" name="title" id="exampleFormControlInput1">
                                                <!-- вызываю функцию вывода сообщений о ошибке валидации
                                                         принимает строку с названием ошибки -->
                                                <?php errMessage('titleErr'); ?>
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleFormControlInput1">Дата</label>
                                                <input type="date" class="form-control <? if (isset($_SESSION['datelErr'])) : ?>is-invalid<? endif; ?>" name="date"">
                                                <!-- вызываю функцию вывода сообщений о ошибке валидации
                                                         принимает строку с названием ошибки -->
                                                <?php errMessage('dateErr'); ?>
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleFormControlInput1">Анонс</label>
                                                <input type="text" class="form-control <? if (isset($_SESSION['anonsErr'])) : ?>is-invalid<? endif; ?>" name="anons">
                                                <!-- вызываю функцию вывода сообщений о ошибке валидации
                                                         принимает строку с названием ошибки -->
                                                <?php errMessage('anonsErr'); ?>
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleFormControlInput1">Добавить картинку</label>
                                                <input type="file" class="form-control <? if (isset($_SESSION['errImg'])) : ?>is-invalid<? endif; ?>" name="image" id="exampleFormControlInput1">
                                                <!-- вызываю функцию вывода сообщений о ошибке валидации
                                                         принимает строку с названием ошибки -->
                                                <?php errMessage('errImg'); ?>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleFormControlInput1">Добавить текст</label>
                                                <textarea type="text" class="form-control <? if (isset($_SESSION['textErr'])) : ?>is-invalid<? endif; ?>" name="text" id="exampleFormControlInput1"></textarea>
                                                <!-- вызываю функцию вывода сообщений о ошибке валидации
                                                         принимает строку с названием ошибки -->
                                                <?php errMessage('textErr'); ?>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-12">
                                            <button class="btn btn-success">Добавить новость</button>
                                            <a class="btn btn-primary" href="http://newsmodul/index.php">На главную</a>
                                        </div>
                                           
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>