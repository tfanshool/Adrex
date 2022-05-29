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
            $this->betaMode = false;
            $this->connect();
        }

        /**
         * @return bool
         */
        public function isBetaMode(): bool
        {
            return $this->betaMode;
        }

        public function connect(): void
        {
            try {
                $conn = new PDO("mysql:host=$this->servername; $this->dbname", $this->username, $this->password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                if ($this->betaMode)
                    echo "Database Connected successfully\n";
            } catch (PDOException $e) {
                if ($this->betaMode)
                    echo "Database Connection failed: " . $e->getMessage()."\n";
            }
        }


    }