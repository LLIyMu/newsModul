<?php require_once 'header.php'; ?>

<?php $paginator = paginator($pdo);?>


<main class="py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <!-- сообщение об успешной авторизации -->
                    <?php if (isset($_SESSION['success'])) : ?>
                        <div class="alert alert-success" role="alert">
                            <?= $_SESSION['success'];
                            unset($_SESSION['success']);
                            ?>
                        </div>
                    <?php endif; ?>
                    <div class="card-header">
                        <h3>Новости</h3>
                    </div>

                    <div class="card-body">
                        <!-- Если сессия пустая добавляю класс d-none для скрытия этого флеш сообщения -->
                        <div class="alert alert-success <? if (empty($_SESSION['alert'])) : echo 'd-none' ?><? endif; ?>" role="alert">
                            <?= //Добавляю сообщение о добавлении комментария
                                $_SESSION['alert'];
                            unset($_SESSION['alert']);
                            ?>

                        </div>
                        <?php
                        //вывод коментариев
                        $comments = getComments($pdo); //функция вывода коментариев 
                        ?>
                        <?php foreach ($comments as $comment) :  if ($comment['skip'] !== 1) : ?>
                                <div class="media">
                                    <img src="img/<?= $comment['image'] ?>" class="mr-3" alt="..." width="64" height="64">
                                    <div class="media-body">
                                        <h5 class="mt-0"><?= $comment['header'] ?></h5>
                                        <span><small><?= date('d/m/Y', strtotime($comment['date'])) ?></small></span>
                                        <p>
                                            <?= $comment['text'] ?>
                                        </p>
                                    </div>
                                </div>
                        <?php endif;
                        endforeach; ?>

                        
                        <?php if ($paginator['comments'] && $paginator['pageCount'] > 1) : ?>
                            <div class="col-md-12" id="comments-pagination">
                                <ul class="pagination justify-content-center">
                                    <?php if ($paginator['currentPage'] > 1) : ?>
                                        <li class="page-item">
                                            <span class="page-link" href="<?= $paginator['link'] ?>1">&laquo;</span>
                                        </li>
                                        <li class="page-item">
                                            <span class="page-link" href="#" data-href="<?= $paginator['link'] ?><?= $paginator['currentPage'] - 1 ?>">&lsaquo;</span>
                                        </li>
                                    <?php endif; ?>

                                    <?php for ($i = $paginator['start']; $i <= $paginator['end']; $i++) : ?>
                                        <li class="page-item <?php if ($i == $paginator['currentPage']) : ?>active <?php endif; ?>">
                                            <span class="page-link" href="#" data-href="<?= $paginator['link'] . $i ?>"><?= $i ?></span>
                                        </li>
                                    <?php endfor; ?>

                                    <?php if ($paginator['currentPage'] < $paginator['pageCount']) : ?>
                                        <li class="page-item">
                                            <span class="page-link" href="#" data-href="<?= $paginator['link'] ?><?= $paginator['currentPage'] + 1 ?>">&rsaquo;</span>
                                        </li>
                                        <li class="page-item">
                                            <span class="page-link" href="#" data-href="<?= $paginator['link'] ?><?= $paginator['pageCount'] ?>">&raquo;</span>
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