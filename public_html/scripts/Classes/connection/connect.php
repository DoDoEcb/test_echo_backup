<?php

/**
 * Created by PhpStorm.
 * User: elifas
 * Date: 02/11/16
 * Time: 14:32
 */
class Connection {
    private $host;
    private $user;
    private $pass;
    private $base;
    public $pdo;
    public function Connect() {
        try {

            $this->host = "localhost";
            $this->user = "zjjebyri_ecoinbest";
            $this->pass = "eEsU_5-Wd0h)";
            $this->base = "zjjebyri_ecoinbest";
            // Definindo a conex達o com o banco de dados.
            $option = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8");
            $this->file = "mysql:host=". $this->host . ";dbname=" . $this->base;
            $this->pdo = new PDO($this->file, $this->user, $this->pass, $option);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $this->pdo->setAttribute(PDO::ATTR_PERSISTENT, true);
            date_default_timezone_set('Brazil/East');
            if(!$this->pdo){
                echo "Erro na conex達o";
            }
            return $this->pdo;
        } catch (Exception $ex) {
            echo "{$ex->getMessage()}";
        }

}

}
?>
