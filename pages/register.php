<?php
    require_once('../includes/headers.php');
    require_once('../includes/RegisterUser.php');


    $register = new RegisterUser();
    if (isset($_POST["login_button"])) {
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $register->setVariables($username, $email, $password);
        $error_Codes = $register->RegisterValidation();
        $filter_error_code = $register->filterErrorCodes($error_Codes);

        if ($error_Codes) {

        }

        if ($register->getBetaMode()) {
            echo "<br>[Login_button is <b>on</b> issetMode]";
            echo " [<b>Username : </b>" . $username . "]";
            echo " [<b>E-mail : </b>" . $email . "]";
            echo " [<b>Password : </b>" . $password . "]";
        }

        if ($register->getBetaMode()) {
            if ($error_Codes != null)        // seems like something is wrong with inputs
                echo "<br>[Error Triggered : <b>True</b>] [Found : <b>" . count($error_Codes) . "</b>] [Error Code(s) : <b>" . json_encode($error_Codes) . "</b>]";
            else                                        // Wohhooo No error in input
                echo "<br>[Error Triggered : <b>False</b>]";

            if ($filter_error_code != null)        // seems like something is wrong with inputs
                echo "<br>[Filtered error Triggered : <b>True</b>] [Found : <b>" . count($filter_error_code) . "</b>] [Error Code(s) : <b>" . json_encode($filter_error_code) . "</b>]";
            else                                        // Wohhooo No error in input
                echo "<br>[Filtered error Triggered : <b>False</b>]";
        }


    } else {
        if ($register->getBetaMode()) {
            echo "<br>[login_button is <b>not on</b> issetMode]";
        }
    }
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
                                <div class="auth-left-wrapper">

                                </div>
                            </div>
                            <div class="col-md-8 pl-md-0">
                                <div class="auth-form-wrapper px-4 py-4">
                                    <div class="col-md-6 col-lg-5 d-none d-md-block py-1">
                                        <img src="../assets/images/Adrex%20Logo.png"
                                             alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
                                    </div>

                                    <!--  <a href="../index.php" class="noble-ui-logo d-block mb-2">Adr<span>ex</span></a>a-->
                                     <h5 class="text-muted font-weight-normal mb-4 ">Create a free account.</h5>

                                    <?php
                                        if (isset($_POST["login_button"])) {
                                            $register->putErrorCode($register->RegisterValidation());
                                        }


                                    ?>


                                    <form action="register.php" method="post" class="forms-sample ">
                                        <div class="form-group">
                                            <label for="username">Username</label>
                                            <input type="text"
                                                   class="form-control  <?php if ($filter_error_code != null && isset($_POST["login_button"])) if (in_array(0, $filter_error_code)) echo "is-invalid"; else echo "is-valid"; ?>"
                                                   id="username" name="username"
                                                   autocomplete="Username" placeholder="Username"
                                                   value="<?php if (isset($_POST["login_button"])) echo $_POST["username"]; ?>">
                                            <?php
                                                if (isset($_POST["login_button"]) && $username == "chirag")
                                                    echo "<div class='valid-feedback'>Aur Maderchod</b> </div>";
                                            ?>

                                        </div>

                                        <div class="form-group">
                                            <label for="email">Email address</label>
                                            <input type="email"
                                                   class="form-control <?php if ($filter_error_code != null && isset($_POST["login_button"])) if ($filter_error_code != null && in_array(1, $filter_error_code)) echo "is-invalid"; else echo "is-valid"; ?>"
                                                   id="email" name="email"
                                                   placeholder="Email"
                                                   value="<?php if (isset($_POST["login_button"])) echo $_POST["email"]; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password"
                                                   class="form-control <?php if ($filter_error_code != null && isset($_POST["login_button"])) if (in_array(2, $filter_error_code)) echo "is-invalid"; ?>"
                                                   id="password" name="password"
                                                   autocomplete="current-password" placeholder="Password" value="">
                                        </div>

                                        <div class="mt-3">

                                            <button class="btn btn-primary" name="login_button" type="submit">Sign up
                                            </button>

                                        </div>
                                        <a href="login.php" class="d-block mt-3 text-muted">Already a user? Sign in</a>


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