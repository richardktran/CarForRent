<header>
    <div
            class="bg-dark d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
        <h5 class="my-0 mr-md-auto font-weight-normal">Car For Rent Company</h5>
        <nav class="my-2 my-md-0 mr-md-3">
            <a class="p-2 text-dark" href="#">Features</a>
            <a class="p-2 text-dark" href="#">Enterprise</a>
            <a class="p-2 text-dark" href="#">Support</a>
            <a class="p-2 text-dark" href="#">Pricing</a>
        </nav>
        <?php if ($data != null && $data['isLogin'] == true) { ?>
            <form action="/logout" method="post">
                <button class="btn btn-outline-primary">Logout</button>
            </form>
        <?php } else { ?>
            <a href="/login" class="btn btn-outline-primary">Login</a>
        <?php } ?>
    </div>
</header>
