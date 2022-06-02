<header>
    <div class=" d-flex flex-column flex-md-row align-items-center p-3 px-md-4 border-bottom box-shadow">
        <h5 class="my-0 mr-md-auto font-weight-normal">
            <a href="/">
                <img src="/assets/images/logo.jpg" height="50" alt="logo" class="logo">
            </a>
            <a href="/" style="text-decoration: none; color: #2DB9CC">
                Car for rent
            </a>

        </h5>

        <nav class="my-2 my-md-0 mr-md-3">
            <?php if ($data != null && $data['isLogin'] == true) { ?>
                <a class="btn btn-primary" href="/create">Create car</a>
            <?php } ?>

        </nav>
        <?php if ($data != null && $data['isLogin'] == true) { ?>
            <form action="/logout" method="post">
                <button class="btn btn-outline-danger">Logout</button>
            </form>
        <?php } else { ?>
            <a href="/login" class="btn btn-primary">Login</a>
        <?php } ?>
    </div>
</header>
