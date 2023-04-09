<?php

namespace App\CustomActions;

use Agrandesr\actions\ActionBuilder;
use PDO;

class SQLAction extends ActionBuilder {
    protected string $envFlag='';
    protected mixed $sql;
    protected mixed $values=[];
    private $pdo;

    public function execute() {
        $flag = (empty($flag))? 'SQL_': 'SQL_'.$flag.'_';
        $type=$_ENV[$flag . 'TYPE'];
        $host=$_ENV[$flag . 'HOST'];
        $user=$_ENV[$flag . 'USER'];
        $pass=$_ENV[$flag . 'PASS'];
        $dtbs=$_ENV[$flag . 'DTBS']??null;
        $port=$_ENV[$flag . 'PORT'];
        $char=isset($_ENV[$flag . 'CHAR']) ? $_ENV[$flag . 'CHAR'] : 'UTF8';
        $dsn = "$type:host=$host;port=$port;". (isset($dtbs)?"dbname=$dtbs;":'') . "charset=$char";

        $this->pdo = new PDO($dsn, $user, $pass);

        if(empty($this->values)) {
            $statement = $this->pdo->query($this->sql);
        } else {
            $statement = $this->pdo->prepare($this->sql);
            foreach ($this->values as $key=>&$value){
                $statement->bindParam("$key", $value, $this->getPdoType($value));
            }
            $statement->execute();
        }
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return empty($result) ? true : $result;
    }

    private function getPdoType($value){
        switch(gettype($value)) {
            case ("boolean"):
                return PDO::PARAM_BOOL;
            case ("integer"):
                return PDO::PARAM_INT;
            case ("NULL"):
                return PDO::PARAM_NULL;
            default:
                return PDO::PARAM_STR;
        }
    }
}