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

        /*      --- Validation Error Code ---
         *
         *      1* : Username already exists
         *      2* : One or multiple keys are empty. [Keys : Username, email, password]
         *      3*: Email Pre Exists
         *      4*  : Password must be a minimum of 8 characters
         *      5*  : Password must be a Maximum of 18 characters
         *
         *      7  : Password must contain at least 1 number
         *      8  : Password must contain at least one uppercase character
         *      9  : Password must contain at least one lowercase character
         *      10 : Password must contain at least one special character
         *      11 :
         *
         * */

        public function RegisterValidation(): ?array            // returns null if no problem otherwise an array of error codes
        {
            $array_codes = array();
            if ($this->usernamePreExists())                    // returns 1 if username already exists
                $array_codes[] = 1;
            if ($this->keysAreEmpty())                         // returns 2 if any key is empty
                $array_codes[] = 2;
            if ($this->emailPreExists())                       // returns 3 if email already exists
                $array_codes[] = 3;
            if ($this->passMinError())                       // returns 4 Password must be a minimum of $minPassSize characters
                $array_codes[] = 4;
            if ($this->passMaxError())                       // returns 5 Password must be a Max of $maxPassSize characters
                $array_codes[] = 5;


            if (count($array_codes) == 0)                          // if array is empty (i.e. no error encountered ) it will return null
                return null;
            sort($array_codes);
            return $array_codes;
        }

        public function keysAreEmpty(): bool    // returns true if any of the variable is empty
        {
            if (empty($this->username) || empty($this->email || empty($this->password)))
                return true;
            return false;
        }


        public function passMinError(): bool
        {
            if (strlen($this->password) < $this->passMinSize)
                return true;
            return false;
        }

        public function passMaxError(): bool
        {
            if (strlen($this->password) > $this->passMaxSize)
                return true;
            return false;
        }


        public function usernamePreExists(): bool    // returns true if username exists already
        {

            $stmt = $this->connect(false)->prepare(query: 'SELECT person_credentials_id FROM person_credentials WHERE person_credentials_username = ? ');
            if (!$stmt->execute(array($this->username))) {
                $stmt = null;
                echo "Failed";
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
            if (in_array(0, $errorCode))
                return;
            if (in_array(2, $errorCode)) {
                ?>
                <div class="alert alert-danger" role="alert">
                    All field are <b>mandatory</b>!
                </div>
                <?php
            }
            if (in_array(4, $errorCode) || in_array(5, $errorCode)) {
                ?>
                <div class="alert alert-danger" role="alert">
                    Password size must be minimum of <b> <?php echo $this->passMinSize ?> </b> and maximum of
                    <b> <?php echo $this->passMaxSize ?> </b> characters.
                </div>
                <?php
            }

            if (in_array(1, $errorCode) && in_array(3, $errorCode)) {
                ?>
                <div class="alert alert-danger" role="alert">
                    <b>Username</b> and <b>Email</b> already exists! Please try another one or <b>login</b> :)
                </div>
                <?php
            } else {
                if (in_array(1, $errorCode)) {
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