<div class="login-wrapper">
    <form class="form-signin" action="<?php

    echo htmlspecialchars($_SERVER["REQUEST_URI"]); ?>" method="post">
        <h1 class="h3 mb-3 font-weight-normal">Please sign in
            <in></in>
        </h1>
        <label for="inputEmail" class="sr-only">Username</label>
        <input type="text" name="username" id="username" class="form-control" placeholder="Username"
               value="<?= $data['username'] ?? '' ?>"
               required
               autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password"
               value="<?= $data['password'] ?? '' ?>" required>
        <div class="checkbox mb-3">
            <label>
                <input type="checkbox" value="remember-me"> Remember me
            </label>
        </div>
        <input type="hidden" name="token" value="<?= $_SESSION['token'] ?? '' ?>">
        <?php

        if ($data != null && array_key_exists('error', $data)) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        ' . $data["error"] . '
    </div>';
        }

        ?>


        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        <p class="mt-5 mb-3 text-muted">&copy; 2017 - 2022</p>
    </form>
</div>
</body>
