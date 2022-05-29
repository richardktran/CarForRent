<main role="main">
    <div class="album py-5 bg-light">
        <div class="container">
            <div class="row">
                <?php foreach ($data['cars'] as $car) { ?>

                    <div class="col-md-4 mb-4">
                        <div class="card" style="width: 18rem;">
                            <img src="<?= $car['image'] ?>" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title"><?= $car['name'] ?></h5>
                                <h6 class="card-subtitle mb-2 text-muted">Richard K Tran</h6>
                                <p class="card-text"><?= $car['description'] ?></p>
                                <a href="#" class="btn mr-2"><i class="fas fa-link"></i> Visit Site</a>
                                <a href="#" class="btn"><i class="fab fa-github"></i> Github</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</main>
