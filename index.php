<?php require_once 'header.php'; ?>

<?php $paginator = paginator($pdo); //dd($paginator);?>


<main class="py-4 bg-dark">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Новости</h3>
                    </div>

                    <div class="card-body">
                       
                        <?php $news = $paginator['news']; //функция вывода новостей ?>
                        <?php foreach ($news as $itemNews) :  if ($itemNews['skip'] !== 1) : ?>
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <a href="show.php/?id=<?= $itemNews['id'] ?>" class=""><?= $itemNews['title'] ?></a>
                                    </div>
                                        <div class="card-body  h-100px">
                                            
                                            <?php if (!empty($itemNews['image'])): ?>
                                            <img src="img/<?= $itemNews['image'] ?>" class="mr-3 float-left" alt="..." width="64" height="64">
                                            <?php endif; ?>

                                            <span><small><?= date('d/m/Y', strtotime($itemNews['date'])) ?></small></span>
                                            
                                            <p class="">
                                                <?= $itemNews['anons'] ?>
                                            </p>
                                            <a href="show.php/?id=<?= $itemNews['id'] ?>" class="btn btn-outline-primary m-5px">Читать далее</a>
                                        </div>
                                    
                                </div>

                        <?php endif;
                        endforeach; ?>

                        <?php if ($paginator['news'] && $paginator['pageCount'] > 1) : ?>
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