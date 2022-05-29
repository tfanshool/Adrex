<?php
    class RegisterUser
    {
        public string $username;
        public string $email;
        public string $password;


        public function __construct()
        {


        }
        public function setVariables($username, $email, $password)
        {
            $this->username = $username;
            $this->email = $email;
            $this->password = $password;

        }

        public function RegisterValidation(): array   // returns 0 if no problem
        {
            $array_codes =array();
            if($this->usernameSizeInvalid())              // returns 2 if username is not as per size
                $array_codes[] = 2;
            if($this->usernamePreExists())                  // returns 1 if username already exists
                $array_codes[] = 1;

            sort($array_codes);
            return $array_codes;
        }

        public function usernameSizeInvalid() : bool    // returns true if username is less then 6 or <12 charachters
        {
            if(strlen($this->username)<6 || strlen($this->username)>12)
                return true;
            return false;
        }

        public function usernamePreExists() : bool    // returns true if username exists already
        {
            return true;
        }





        public function putErrorCode(array $errorCode) : void   //error code
        {
            if(in_array(0,$errorCode))
                return;
            if (in_array(2,$errorCode))
            {
                ?>
                <div class="alert alert-danger" role="alert">
                    Username must be between <b>6</b> to <b>12</b>    characters. <?php   echo "<b>".$this->username."</b>"; ?> must be changed!
                </div>
                <?php
            }
            if (in_array(1,$errorCode))
            {
                ?>
                <div class="alert alert-danger" role="alert">
                    Username already exits! Try another :)
                </div>
                <?php
            }



        }

    }