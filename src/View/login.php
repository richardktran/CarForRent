<section>
    <div class="bg-white border rounded-5">


        <section class="w-100 p-4 p-xl-5"
                 style="background-color: #eee; border-radius: .5rem .5rem 0 0;">
            <style>
                .gradient-custom-2 {
                    /* fallback for old browsers */
                    background: #fccb90;

                    /* Chrome 10-25, Safari 5.1-6 */
                    background: -webkit-linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);

                    /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
                    background: linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);
                }

                @media (min-width: 768px) {
                    .gradient-form {
                        height: 100vh !important;
                    }
                }

                @media (min-width: 769px) {
                    .gradient-custom-2 {
                        border-top-right-radius: .3rem;
                        border-bottom-right-radius: .3rem;
                    }
                }
            </style>
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col-12">
                        <div class="card rounded-3 text-black">
                            <div class="row g-0">
                                <div class="col-lg-6">
                                    <div class="card-body p-md-5 mx-md-4">

                                        <div class="text-center">
                                            <img src="/assets/images/logo.jpg" alt="logo" class="img-fluid"
                                                 style="width: 185px;" alt="logo">
                                            <h4 class="mt-1 mb-5 pb-1">Car For Rent</h4>
                                        </div>

                                        <form
                                                action="<?php echo htmlspecialchars($_SERVER["REQUEST_URI"]); ?>"
                                                method="post"
                                        >
                                            <p>Please login to your account</p>

                                            <div class="form-outline mb-4">
                                                <label class="form-label" for="form2Example11"
                                                       style="margin-left: 0px;">Username</label>
                                                <input type="text" name="username" id="username" class="form-control"
                                                       placeholder="Username"
                                                       value="<?= $data['username'] ?? '' ?>"
                                                       required
                                                       autofocus>
                                                <div class="form-notch">
                                                    <div class="form-notch-leading" style="width: 9px;"></div>
                                                    <div class="form-notch-middle" style="width: 67.2px;"></div>
                                                    <div class="form-notch-trailing"></div>
                                                </div>
                                                <div style="color: red; font-style: italic;">
                                                    <?php
                                                    $error = array_key_exists('error', $data) ? $data['error'] : "";
                                                    $usernameError = $error != "" && array_key_exists('username',
                                                        $error) ? $error['username'] : "";
                                                    echo $usernameError;
                                                    ?>
                                                </div>
                                            </div>

                                            <div class="form-outline mb-4">
                                                <label class="form-label" for="form2Example22"
                                                       style="margin-left: 0px;">Password</label>
                                                <input type="password" name="password" id="inputPassword"
                                                       class="form-control" placeholder="Password"
                                                       value="<?= $data['password'] ?? '' ?>" required>
                                                <div class="form-notch">
                                                    <div class="form-notch-leading" style="width: 9px;"></div>
                                                    <div class="form-notch-middle" style="width: 64px;"></div>
                                                    <div class="form-notch-trailing"></div>
                                                </div>
                                                <div style="color: red; font-style: italic;">
                                                    <?php
                                                    $error = array_key_exists('error', $data) ? $data['error'] : "";
                                                    $usernameError = $error != "" && array_key_exists('password',
                                                        $error) ? $error['password'] : "";
                                                    echo $usernameError;
                                                    ?>
                                                </div>
                                            </div>
                                            <input type="hidden" name="token" value="<?= $_SESSION['token'] ?? '' ?>">
                                            <?php

                                            if ($data != null && array_key_exists('error',
                                                    $data) && array_key_exists('incorrect', $data["error"])) {
                                                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        ' . $data["error"]["incorrect"] . '
    </div>';
                                            }

                                            ?>

                                            <div class="text-center pt-1 mb-5 pb-1">
                                                <button class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3"
                                                        type="submit">Sign in
                                                </button>
                                                <a class="text-muted" href="#!">Forgot password?</a>
                                            </div>

                                            <div class="d-flex align-items-center justify-content-center pb-4">
                                                <p class="mb-0 me-2">Don't have an account? &nbsp;</p>
                                                <button type="button" class="btn btn-outline-danger"> Create new
                                                </button>
                                            </div>

                                        </form>

                                    </div>
                                </div>
                                <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                                    <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                                        <h4 class="mb-4">We are more than just a company</h4>
                                        <p class="small mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                                            sed
                                            do eiusmod tempor
                                            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                                            nostrud exercitation
                                            ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


    </div>
</section>
