<?php
    require_once('../includes/headers.php');
    require_once('../includes/RegisterUser.php');




    $register = new RegisterUser();
    if(isset($_POST["login_button"]))
    {
        $username= $_POST["username"];
        $email= $_POST["email"];
        $password= $_POST["password"];
        $register->setVariables($username,$email,$password);
        if($register->getBetaMode())
        {
            echo "<br>[login_button is <b>on</b> issetMode]";
            echo " [<b>Username : </b>".$username."]";
            echo " [<b>E-mail : </b>".$email."]";
            echo " [<b>Password : </b>".$password."]";
        }

        if($register->RegisterValidation())        // seems like something is wrong with inputs
        {
            if($register->getBetaMode())
                echo "<br>[Error Triggered : <b>True</b>] [Found : <b>".count($register->RegisterValidation())."</b>] [Error Code(s) : <b>".json_encode($register->RegisterValidation())."</b>]";
        }
        else                                        // Wohhooo No error in input
        {
            if($register->getBetaMode())
                echo "<br>[Error Triggered : <b>False</b>]";

        }


    }
    else
    {
        if($register->getBetaMode())
        {
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
                                <div class="auth-form-wrapper px-4 py-5">
                                    <a href="../index.php" class="noble-ui-logo d-block mb-2">Adr<span>ex</span></a>
                                    <h5 class="text-muted font-weight-normal mb-4">Create a free account.</h5>

                                    <?php
                                            if(isset($_POST["login_button"])) {
                                                $register->putErrorCode($register->RegisterValidation());
                                            }


                                    ?>



                                    <form action="register.php" method="post"   class="forms-sample">
                                        <div class="form-group">
                                            <label for="exampleInputUsername1">Username</label>
                                            <input type="text" class="form-control " id="username" name="username"
                                                   autocomplete="Username" placeholder="Username" value="<?php if(isset($_POST["login_button"])) echo $_POST["username"];  ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Email address</label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                   placeholder="Email" value="<?php if(isset($_POST["login_button"])) echo $_POST["email"];  ?>" >
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Password</label>
                                            <input type="password" class="form-control" id="password" name="password"
                                                   autocomplete="current-password" placeholder="Password" >
                                        </div>

                                        <div class="mt-3">

                                            <button class="btn btn-primary" name="login_button" type="submit">Sign up</button>

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