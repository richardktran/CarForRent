<main role="main">
    <div class="album py-5 bg-light">
        <div class="container">
            <div class="row">
                <?php foreach ($data['cars'] as $car) { ?>
                    <div class="col-sm-3 pt-3">
                        <div class="card shadow-sm" id={id}>
                            <img
                                    alt="adsdsa"
                                    height="170"
                                    src=<?= $car['image'] ?>
                            />
                            <div class="card-body">
                                <h6 data-tip={title}
                                    class="card-title"
                                    style="display: inline-block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width: 100%;"
                                >
                                    <?= $car['name'] ?>
                                </h6>
                                <p class="card-text">
                                    <strong>Brand:</strong>
                                    <span><?= $car['brand'] ?></span>
                                </p>
                                <hr/>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="d-inline p-2" style="color:#F75454">
                                            <strong>$<?= $car['price'] ?>/day</strong>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <a href="#" class="btn btn-primary btn-sm">Rent Now</a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</main>
