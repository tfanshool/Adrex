<?php
    require_once('../includes/headers.php');

?>

<body>
<div class="main-wrapper">
    <div class="page-wrapper full-page">
        <div class="page-content d-flex align-items-center justify-content-center">

            <div class="row w-100 mx-0 auth-page">
                <div class="col-md-8 col-xl-6 mx-auto">
                    <div class="card">
                        <div class="row">
                            <div class="col-md-4 pr-md-0">
                                <div class="auth-side-wrapper auth-left-wrapper">

                                </div>
                            </div>
                            <div class="col-md-8 pl-md-0">
                                <div class="auth-form-wrapper px-4 py-5">
                                    <a href="../index.php" class="noble-ui-logo d-block mb-2">Adr<span>eX</span></a>
                                    <h5 class="text-muted font-weight-normal mb-4">Welcome back! Log in to your
                                        account.</h5>
                                    <form class="forms-sample">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Email address</label>
                                            <input type="email" class="form-control" id="exampleInputEmail1"
                                                   placeholder="Email">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Password</label>
                                            <input type="password" class="form-control" id="exampleInputPassword1"
                                                   autocomplete="current-password" placeholder="Password">
                                        </div>

                                        <div class="mt-3">
                                            <a href="../../dashboard-one.html"
                                               class="btn btn-primary mr-2 mb-2 mb-md-0 text-white">Login</a>

                                        </div>
                                        <a href="register.php" class="d-block mt-3 text-muted">Not a user? Sign up</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php
    require_once('../includes/footer.php');

?>