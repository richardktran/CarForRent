<?php
$error = array_key_exists('error', $data) ? $data['error'] : [];
$car = array_key_exists('car', $data) ? $data['car'] : [];
$nameError = array_key_exists('car_name', $error) ? $error['car_name'] : "";
$typeError = array_key_exists('car_type', $error) ? $error['car_type'] : "";
$brandError = array_key_exists('car_brand', $error) ? $error['car_brand'] : "";
$yearError = array_key_exists('car_year', $error) ? $error['car_year'] : "";
$priceError = array_key_exists('car_price', $error) ? $error['car_price'] : "";
$descriptionError = array_key_exists('car_description', $error) ? $error['car_description'] : "";
$imageError = array_key_exists('image', $error) ? $error['image'] : "";

$name = array_key_exists('name', $car) ? $car['name'] : "";
$type = array_key_exists('type', $car) ? $car['type'] : "";
$brand = array_key_exists('brand', $car) ? $car['brand'] : "";
$year = array_key_exists('productYear', $car) ? $car['productYear'] : "";
$price = array_key_exists('price', $car) ? $car['price'] : "";
$description = array_key_exists('description', $car) ? $car['description'] : "";
$image = array_key_exists('image', $car) ? $car['image'] : "";
?>
<main role="main" class="bg-light">
    <div class="container py-3 rounded-lg ">

        <div class="my-3 p-3 px-5 rounded shadow-lg bg-white ">

            <h4 class="mt-5">Create your new car</h4>
            <p>An example of the extended form with typical checkout inputs.</p>
            <form action="/create" method="post" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="form-label" for="form6Example1">Name</label>
                        <input type="text" value="<?= $name ?>" name="name" id="form6Example1" class="form-control"/>
                        <div style="color: red; font-style: italic;">
                            <?php echo $nameError; ?>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label" for="form6Example3">Type</label>
                        <input type="text" value="<?= $type ?>" name="type" id="form6Example3" class="form-control"/>
                        <div style="color: red; font-style: italic;">
                            <?php echo $typeError; ?>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="form-label" for="form6Example4">Brand</label>
                        <input type="text" value="<?= $brand ?>" name="brand" id="form6Example4" class="form-control"/>
                        <div style="color: red; font-style: italic;">
                            <?php echo $brandError; ?>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label" for="form6Example5">Production Year</label>
                        <input type="number" value="<?= $year ?>" name="production_year" min="1900" max="2099" step="1"
                               value="2022"
                               class="form-control"/>
                        <div style="color: red; font-style: italic;">
                            <?php echo $yearError; ?>
                        </div>
                    </div>
                </div>


                <!-- Number input -->
                <div class="form-outline mb-4">
                    <label class="form-label" for="form6Example6">Price</label>
                    <input type="number" value="<?= $price ?>" name="price" id="form6Example6" class="form-control"/>
                    <div style="color: red; font-style: italic;">
                        <?php echo $priceError; ?>
                    </div>
                </div>

                <!-- Message input -->
                <div class="form-outline mb-4">
                    <label class="form-label" for="form6Example7">Description</label>
                    <textarea class="form-control" name="description" id="form6Example7"
                              rows="4"><?= $description ?></textarea>
                    <div style="color: red; font-style: italic;">
                        <?php echo $descriptionError; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="exampleFormControlFile1">Image</label>
                    <input type="file" name="image" class="form-control-file" id="exampleFormControlFile1">
                    <div style="color: red; font-style: italic;">
                        <?php echo $imageError; ?>
                    </div>
                </div>

                <!-- Submit button -->
                <div class="d-flex align-items-center justify-content-center pb-4">
                    <a href="/" class="btn btn-light fa-lg gradient-custom-2 mr-4">Cancel</a>
                    <button type="submit" class="btn btn-primary ml-4">Create</button>
                </div>
            </form>
        </div>
    </div>
</main>
