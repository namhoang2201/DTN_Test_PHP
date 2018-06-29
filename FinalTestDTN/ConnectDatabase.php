<?php

class Connection {

    function connect() {
        $server = "localhost";
        $username = "root";
        $password = "";
        $dbname = "budgetdb";
        $conn = new mysqli($server, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }

}
