<?php require_once 'header.php'; ?>

<?php $paginator = paginator($pdo); //dd($paginator);?>


<main class="py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Задачи</h3>
                        <a href="http://task/create.php" class="btn btn-success">Добавить задачу</a>
                    </div>

                    <div class="card-body">
    
                        <?php foreach ($paginator['task'] as $itemTask) : ?>  
                            
                                <div class="card mb-3">
                                    
                                        <div class="card-body  h-100px">

                                            <span class="text-primary"><small > <?= $itemTask['name'] ?></small></span></br>
                                            <span class="text-primary"><small><?= $itemTask['email'] ?></small></span>
                                            <h5>
                                                <?= $itemTask['text'] ?>
                                            </h5>
                                            <?php if ($itemTask['ok'] == 1) : ?>
                                                <div class="alert alert-success" role="alert">
                                                    <p>Отредактировано администратором</p>
                                                    
                                                </div>
                                            <?php else : ?>
                                                <div class="alert alert-success" role="alert">
                                                    Выполнено
                                                </div>
                                            <?php endif; ?>
                                            
                                        </div>
                                    
                                </div>

                        <?php endforeach; ?>

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