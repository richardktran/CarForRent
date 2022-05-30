<main role="main">
    <div class="container">

        <h4 class="mt-5">Create your new car</h4>
        <p>An example of the extended form with typical checkout inputs.</p>
        <form action="/store" method="post">
            <!-- 2 column grid layout with text inputs for the first and last names -->
            <div class="row mb-4">
                <div class="col">
                    <div class="form-outline">
                        <label class="form-label" for="form6Example1">Name</label>
                        <input type="text" name="name" id="form6Example1" class="form-control"/>
                    </div>
                </div>
            </div>

            <!-- Text input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="form6Example3">Type</label>
                <input type="text" name="type" id="form6Example3" class="form-control"/>
            </div>

            <!-- Text input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="form6Example4">Brand</label>
                <input type="text" name="brand" id="form6Example4" class="form-control"/>
            </div>

            <!-- Email input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="form6Example5">Production Year</label>
                <input type="number" name="production_year" min="1900" max="2099" step="1" value="2022"
                       class="form-control"/>
            </div>

            <!-- Number input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="form6Example6">Price</label>
                <input type="number" name="price" id="form6Example6" class="form-control"/>
            </div>

            <!-- Message input -->
            <div class="form-outline mb-4">
                <label class="form-label" for="form6Example7">Description</label>
                <textarea class="form-control" name="description" id="form6Example7" rows="4"></textarea>
            </div>

            <!--            <div class="form-group">-->
            <!--                <label for="exampleFormControlFile1">Image</label>-->
            <!--                <input type="file" class="form-control-file" id="exampleFormControlFile1">-->
            <!--            </div>-->

            <!-- Submit button -->
            <button type="submit" class="btn btn-primary btn-block mb-4">Create</button>
        </form>
    </div>
</main>
