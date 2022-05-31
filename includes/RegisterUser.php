<?php

    class RegisterUser extends DBcon
    {
        public string $username;
        public string $email;
        public string $password;
        public int $passMinSize;
        public int $passMaxSize;


        public function __construct()
        {
            parent::__construct();
            $this->passMinSize = 8;
            $this->passMaxSize = 16;

        }

        public function setVariables($username, $email, $password): void
        {
            $this->username = $username;
            $this->email = $email;
            $this->password = $password;

        }

        public function getBetaMode(): bool
        {
            return parent::isBetaMode();
        }

        public function filterErrorCodes(array $errorCodes) : ?array
        {
            if(empty($errorCodes))
                return null;
            $filtered_Error_Codes = array();
            if(in_array(0,$errorCodes) || in_array(6,$errorCodes) )     //Username
                $filtered_Error_Codes[]=0;
            if (in_array(1,$errorCodes) || in_array(3,$errorCodes))     //e-mail
                $filtered_Error_Codes[]=1;
            if(!empty($filtered_Error_Codes))                                       //password
                $filtered_Error_Codes[]=2;

            sort($filtered_Error_Codes);
            return $filtered_Error_Codes;
        }

        /*
         *      *     --- Validation Error Code ---
         *
         *      0* : Username Empty
         *      1* : E-mail Empty
         *      2* : Password Empty
         *      3* : Email Pre Exists
         *      4* : Password must be a minimum of 8 characters
         *      5* : Password must be a Maximum of 18 characters
         *      6* : Username already exists
         *      7  : Password must contain at least 1 number
         *      8  : Password must contain at least one uppercase character
         *      9  : Password must contain at least one lowercase character
         *      10 : Password must contain at least one special character
         *
         *
         * */

        public function RegisterValidation(): ?array           // returns null if no problem otherwise an array of error codes
        {
            $array_codes = array();
            $emptyKeys = $this->keysAreEmpty();
            if(!empty($emptyKeys))
                return $emptyKeys;
            if ($emptyKeys!=null)                              // returns 0 => username empty | 1 => email | 3=> password
            {
                foreach ($emptyKeys as $key)
                    $array_codes[]=$key;
            }

            if ($this->passMinError())                         // returns 4 Password must be a minimum of $minPassSize characters
                $array_codes[] = 4;
            if ($this->passMaxError())                         // returns 5 Password must be a Max of $maxPassSize characters
                $array_codes[] = 5;
            if ($this->passNumError())                         // returns 7 Password must contain at least 1 number
                $array_codes[] = 7;
            if ($this->passUpperCaseError())                   // returns 8 Password must contain at least one uppercase character
                $array_codes[] = 8;
            if ($this->passLowerCaseError())                   // returns 9 Password must contain at least one lowercase character
                $array_codes[] = 9;
            if ($this->passSpecialCarError())                  // returns 10 Password must contain at least one Special character
                $array_codes[] = 10;

            if(count($array_codes)==0)
            {
                if ($this->usernamePreExists())                    // returns 6 if username already exists
                    $array_codes[] = 6;
                if ($this->emailPreExists())                       // returns 3 if email already exists
                    $array_codes[] = 3;
            }


            if (empty($array_codes))                      // if array is empty (i.e. no error encountered ) it will return null
                return null;
            sort($array_codes);
            return $array_codes;
        }

        public function keysAreEmpty(): ?array                   // returns true if any of the variable is empty
        {
            $error_Array = array();
            if (empty($this->username))
            {
                $error_Array[]=0;
            }
            if (empty($this->email))
            {
                $error_Array[]=1;
            }
            if (empty($this->password))
            {
                $error_Array[]=2;
            }

            if (!empty($error_Array))
                return $error_Array;
            return null;
        }


        public function passMinError(): bool                   // returns true if character size in less than $passMinSize
        {
            if (strlen($this->password) < $this->passMinSize)
                return true;
            return false;
        }

        public function passMaxError(): bool                    // returns true if character size in more than $passMaxSize
        {
            if (strlen($this->password) > $this->passMaxSize)
                return true;
            return false;
        }

        public function passNumError(): bool                    // returns true if pass doesn't contain at least one number
        {
            if (!preg_match('@[0-9]@', $this->password))
                return true;
            return false;
        }

        public function passUpperCaseError(): bool                // returns true if pass doesn't contain at least one uppercase character
        {
            if (!preg_match('@[A-Z]@', $this->password))
                return true;
            return false;
        }
        public function passLowerCaseError(): bool                // returns true if pass doesn't contain at least one lowercase character
        {
            if (!preg_match('@[a-z]@', $this->password))
                return true;
            return false;
        }

        public function passSpecialCarError(): bool                // returns true if pass doesn't contain at least one Special character
        {
            if (!preg_match('@[^\w]@', $this->password))
                return true;
            return false;
        }




        public function usernamePreExists(): bool    // returns true if username exists already
        {

            $stmt = $this->connect(false)->prepare(query: 'SELECT person_credentials_id FROM person_credentials WHERE person_credentials_username = ? ');
            if (!$stmt->execute(array($this->username))) {
                $stmt = null;
                return true;
            }
            if ($stmt->rowCount() > 0)
                return true;
            else
                return false;
        }

        public function emailPreExists(): bool    // returns true if username exists already
        {

            $stmt = $this->connect(false)->prepare(query: 'SELECT person_credentials_id FROM person_credentials WHERE person_credentials_email = ?');
            if (!$stmt->execute(array($this->email))) {
                $stmt = null;
                echo "Failed";
                return true;
            }
            if ($stmt->rowCount() > 0)
                return true;
            else
                return false;
        }


        public function putErrorCode(array $errorCode): void   //error code
        {
            if ($errorCode==null)
                return;
            if (in_array(0, $errorCode) && in_array(1, $errorCode) && in_array(2, $errorCode)) {
                ?>
                <div class="alert alert-danger" role="alert">
                     All field are <b>mandatory</b>!
                </div>
                <?php
            }
            else{
                if(in_array(0, $errorCode) && in_array(1, $errorCode))
                {
                    ?>
                    <div class="alert alert-danger" role="alert">
                        <b>Username</b> and <b>E-mail</b> can't be empty!
                    </div>
                    <?php
                }
                else if(in_array(0, $errorCode) && in_array(2, $errorCode))
                {
                    ?>
                    <div class="alert alert-danger" role="alert">
                        <b>Username</b> and <b>Password</b> can't be empty!
                    </div>
                    <?php
                }
                else if(in_array(1, $errorCode) && in_array(2, $errorCode))
                {
                    ?>
                    <div class="alert alert-danger" role="alert">
                        <b>E-mail</b> and <b>Password</b> can't be empty!
                    </div>
                    <?php
                }
                else
                {
                    if(in_array(0, $errorCode))
                    {
                        ?>
                        <div class="alert alert-danger" role="alert">
                            <b>Username</b> can't be empty!
                        </div>
                        <?php
                    }
                    else if(in_array(1, $errorCode))
                    {
                        ?>
                        <div class="alert alert-danger" role="alert">
                            <b>E-mail</b> can't be empty!
                        </div>
                        <?php
                    }
                    else if (in_array(2, $errorCode))
                    {
                        ?>
                        <div class="alert alert-danger" role="alert">
                            <b>Password</b> can't be empty!
                        </div>
                        <?php
                    }
                }

            }










            if (in_array(4, $errorCode) || in_array(5, $errorCode)) {
                ?>
                <div class="alert alert-danger" role="alert">
                    Password size must be minimum of <b> <?php echo $this->passMinSize ?> </b> and maximum of
                    <b> <?php echo $this->passMaxSize ?> </b> characters.
                </div>
                <?php
            }
            if (in_array(8, $errorCode)) {
                ?>
                <div class="alert alert-danger" role="alert">
                    Password must contain an <b>uppercase</b> character.
                </div>
                <?php
            }
            if (in_array(9, $errorCode)) {
                ?>
                <div class="alert alert-danger" role="alert">
                    Password must contain a <b>lowercase</b> character.
                </div>
                <?php
            }
            if (in_array(10, $errorCode)) {
                ?>
                <div class="alert alert-danger" role="alert">
                    Password must contain a <b>special</b> character.
                </div>
                <?php
            }

            if (in_array(6, $errorCode) && in_array(3, $errorCode)) {
                ?>
                <div class="alert alert-danger" role="alert">
                    <b>Username</b> and <b>Email</b> already exists! Please try another one or <b>login</b> :)
                </div>
                <?php
            } else {
                if (in_array(6, $errorCode)) {
                    ?>
                    <div class="alert alert-danger" role="alert">
                        Username already exists! Try another :)
                    </div>
                    <?php
                }
                if (in_array(3, $errorCode)) {
                    ?>
                    <div class="alert alert-danger" role="alert">
                        Email already exists! Try another :)
                    </div>
                    <?php
                }
            }


        }

    }