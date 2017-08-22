<?php

namespace KCTAPI\Daos;

use PDO;
use FluentPDO;
use Exception;

class BaseDao {
    
    protected $dbConn;
    protected $pdoConnection;


    public function __construct() {
        $this->connectToDb();
    }
    
    private function connectToDb() {
        global $config;
        $dbConfig = $config[$config['mode']];
        $pdoCon = new PDO('pgsql:host=' . $dbConfig['dbHost'] . ';' .
                    'dbname=' . $dbConfig['dbName'] . ';' .
                    'user=' . $dbConfig['dbUser'] . ';' .
                    'password=' . $dbConfig['dbPassword']);

        $pdoCon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdoConnection = $pdoCon;
        $this->dbConn = new FluentPDO($pdoCon);
        
    }
    
    protected function executeQuery($query,$params) {
        try {
            
            global $config,$mode;
            $host = $config[$mode]['dbHost'];
            $database = $config[$mode]['dbName'];
            $username = $config[$mode]['dbUser'];
            $password = $config[$mode]['dbPassword'];
            $dhb = pg_connect("host=".$host." dbname=".$database." user=".$username." password=".$password);
            $result = pg_query_params($dhb,$query,$params);
            pg_close($dhb);
            return $result;
        } catch (Exception $e) {
            throw  $e;
        }
    }
    
    public function closeConnection(){
        try {
            $this->pdoConnection = null;
        }catch (Exception $e){
            throw $e;
        }
    }
}
