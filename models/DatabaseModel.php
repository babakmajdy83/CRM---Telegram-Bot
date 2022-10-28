<?php

class DatabaseModel {
    protected string $host = HOST;
    protected string $dbname = DB_NAME;
    protected string $dbuser = DB_USER;
    protected string $dbpass = DB_PASS;
    protected PDO $con;
    protected string $query;

    protected function __construct()
    {
        $this->con = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->dbname, $this->dbuser, $this->dbpass);
        $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->con->exec('set names utf8');
    }

    protected function prepare($sql){
        $this->query = $this->con->prepare($sql);
    }

    protected function bindValue($index, $value){
        $this->query->bindValue($index, $value);
    }

    protected function single(){
        return $this->query->fetch(PDO::FETCH_OBJ);
    }

    protected function results(){
        return $this->query->fetchall(PDO::FETCH_OBJ);
    }

    protected function execute(){
        $this->query->execute();
    }

}