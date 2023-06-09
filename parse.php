<?php

class parse{
    public $database;
    public $server;
    public $username;
    public $password;

    function __construct(){
        include("config/config.php");

        $this->database=$database;
        $this->server=$server;
        $this->username=$username;
        $this->password=$password;

    }

    function dbConnect(){

        /****** connect to database **************/

        try {
            $db = new PDO("mysql:host=$this->server;dbname=$this->database;charset=utf8;port=3306", $this->username, $this->password);
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }
        return $db;

    }

    




}

$parse=new parse();
$db=$parse->dbConnect();






?>