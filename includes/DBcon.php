<?php

    class DBcon
    {
        private string $servername;
        private string $username;
        private string $password;
        private string $dbname;
        private bool $betaMode;

        public function __construct()
        {
            $this->servername = "localhost";
            $this->username = "root";
            $this->password = "";
            $this->dbname = "adrexDB";
            $this->betaMode = true;
        }

        public function connect(): void
        {
            try {
                $conn = new PDO("mysql:host=$this->servername; $this->dbname", $this->username, $this->password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                if ($this->betaMode)
                    echo "Connected successfully";
            } catch (PDOException $e) {
                if ($this->betaMode)
                    echo "Connection failed: " . $e->getMessage();
            }
        }


    }