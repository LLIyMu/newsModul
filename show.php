<?php require_once 'header.php'; ?>

<?php
$id = (int)$_GET['id'];
$news = getOneNews($pdo, $id);?>


<main class="py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Новости</h3>
                    </div>

                    <div class="card-body">
                        
                        <div class="media mt-20px">

                            <?php if (!empty($news['image'])): ?>   
                                <img src="/img/<?= $news['image'] ?>" class="mr-3" alt="..." width="500">
                            <?php endif; ?>    

                            <div class="media-body">
                                <h5 class="mt-0"><?= $news['title'] ?></h5>
                                <span><small><?= date('d/m/Y', strtotime($news['date'])) ?></small></span>
                                
                                <p>
                                    <?= $news['text'] ?>
                                </p>
                                
                            </div>
                                    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
</div>
</body>

</html>