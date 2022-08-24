<?php

    class DBcon
    {
        private string $servername;
        private string $username;
        private string $password;
        private string $dbname;
        private bool $betaMode;

        protected function __construct()
        {
            $this->servername = "localhost";
            $this->username = "root";
            $this->password = "";
            $this->dbname = "adrexdb";
            $this->betaMode = false;

            $this->connect();
        }

        /**
         * @return bool
         */
        protected function isBetaMode(): bool
        {
            return $this->betaMode;
        }


        protected function connect(bool $flag = true) : ?PDO
        {
            try {
                $conn = new PDO("mysql:host=$this->servername; dbname=$this->dbname", $this->username, $this->password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                if ($this->betaMode && $flag)
                    echo "Database Connected successfully\n";
                return $conn;
            } catch (PDOException $e) {
                if ($this->betaMode && $flag)
                    echo "Database Connection failed: " . $e->getMessage()."\n";
            }
            return null;
        }


    }