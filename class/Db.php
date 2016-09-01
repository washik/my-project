<?php
class Db
{
    protected $pdo;

    public function __construct($username, $password, $hostname, $dbname)
    {

        $dsn = "mysql:host=$hostname;dbname=$dbname;charset=UTF8";
        $opt = array(
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );

        try {
            $this->pdo = new PDO($dsn, $username, $password, $opt);
        } catch (PDOException $e) {
            die('Error db: ' . $e->getMessage());
        }
    }

    public function getConnection(){
        return $this->pdo;
    }
}
