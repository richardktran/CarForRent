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
                                <div class="rent-price">
                                    <strong>$<?= $car['price'] ?></strong><span class="mx-1">/</span>day
                                </div>
                                <div class="d-block d-md-flex mb-3 border-bottom pb-3">
                                    <div class="listing-feature pr-4">
                                        <span class="caption"><strong>Type:</strong></span>
                                        <span class="number"><?= $car['type'] ?></span>
                                    </div>
                                    <div class="listing-feature pr-4">
                                        <span class="caption"><strong>Brand:</strong></span>
                                        <span class="number"><?= $car['brand'] ?></span>
                                    </div>
                                    <div class="listing-feature pr-4">
                                        <span class="caption"><strong>Year:</strong></span>
                                        <span class="number"><?= $car['productYear'] ?></span>
                                    </div>
                                </div>
                                <p class="card-text"><?= $car['description'] ?></p>
                                <p><a href="#" class="btn btn-primary btn-sm">Rent Now</a></p>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</main>
