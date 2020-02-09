<?php
require_once 'header.php';

$paginator = paginator($pdo, 'admin'); //dd($paginator);
$paginator['link'] = 'admin.php?page=';?>



        <main class="py-4 bg-dark">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3>Админ панель</h3>
                            </div>

                            <div class="col-md-12" style="margin-top: 20px;">
                            <div class="card-header d-flex">
                            <form action="#" method="/">
                                
                                    <h3 class="ml-auto">Добавить задачу</h3>
                                    <a href="/create.php" class="btn btn-primary mr-auto" aria-pressed="true">добавить</a>
                                
                            </form>
                            </div>

                            </div>

                            <div class="card-body">

                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Картинка</th>
                                            <th>Заголовок</th>
                                            <th>Дата</th>
                                            <th>Анонс</th>
                                            <th>Действия</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        
                                        <?php foreach ($paginator['task'] as $itemTask) : //вывод новостей?>

                                            <tr>
                                                
                                                <td><textarea class="mt-2"><?= $itemTask['text'] ?></textarea></td>
                                                
                                                <td>
                                                    <?php if ($itemTask['ok'] == 1) : ?>
                                                        <form action="/admin_hand.php" method="post">
                                                            <button type="submit" name="show" value="<?php echo $itemTask['id']; ?>" class="btn btn-success">Не выполнено</button>
                                                        </form>
                                                    <?php else : ?>
                                                        <form action="/admin_hand.php" method="post">
                                                            <button type="submit" name="skip" value="<?php echo $itemTask['id']; ?>" class="btn btn-warning">Выполнено</button>
                                                        </form>
                                                    <?php endif; ?>
                                                        <form action="/admin_hand.php" method="post">
                                                            <button onclick="return confirm('are you sure?')" name="delete" value="<?php echo $itemTask['id']; ?>" class="btn btn-danger">
                                                                Удалить</button>
                                                        </form>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                        
                                    </tbody>
                                </table>
                                <?php if ($paginator['task'] && $paginator['pageCount'] > 1) : ?>
                                            <div class="col-md-12" id="comments-pagination">
                                                <ul class="pagination justify-content-center">
                                                    <?php if ($paginator['currentPage'] > 1) : ?>
                                                        <li class="page-item">
                                                            <a class="page-link" href="<?= $paginator['link'] ?>1">&laquo;</a>
                                                        </li>
                                                        <li class="page-item">
                                                            <a class="page-link" href="<?= $paginator['link'] ?><?= $paginator['currentPage'] - 1 ?>">&lsaquo;</a>
                                                        </li>
                                                    <?php endif; ?>

                                                    <?php for ($i = $paginator['start']; $i <= $paginator['end']; $i++) : ?>
                                                        <li class="page-item <?php if ($i == $paginator['currentPage']) : ?>active <?php endif; ?>">
                                                            <a class="page-link" href="<?= $paginator['link'] . $i ?>"><?= $i ?></a>
                                                        </li>
                                                    <?php endfor; ?>

                                                    <?php if ($paginator['currentPage'] < $paginator['pageCount']) : ?>
                                                        <li class="page-item">
                                                            <a class="page-link" href="<?= $paginator['link'] ?><?= $paginator['currentPage'] + 1 ?>">&rsaquo;</a>
                                                        </li>
                                                        <li class="page-item">
                                                            <a class="page-link" href="<?= $paginator['link'] ?><?= $paginator['pageCount'] ?>">&raquo;</a>
                                                        </li>
                                                    <?php endif; ?>
                                                </ul>
                                            </div>
                                        <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>