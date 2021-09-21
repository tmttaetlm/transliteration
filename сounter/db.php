<?php
namespace Components;

use PDO;

/* DB
 * Работа с базой данных
 */

class Db {
    private static $db;
    private $link;

    private function __construct(){
        $dsn = "mysql:host=10.14.24.134; dbname=isdb;charset=utf8";
        $opt = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,];
        //Подключаемся к БД
        try { $this->link = new PDO($dsn, 'vlad', 'ManGust2112*', $opt); } 
        catch (PDOException $e) {
            echo 'Data base problem:<br>';
            echo $e->getMessage(); 
            die();
        }
        
    }

    //Статический метод получения соединения (Синглтон)
    public static function getDb() {
        if (is_null(self::$db)){
            self::$db = new self();
        }
        return self::$db;
    }

    //Запрос на добавление, обновление, удаление записей в БД
    public function IUDquery($query,array $params = null) {
        try {
            $stmt= $this->link->prepare($query);
            if ($params) 
            {
                foreach ($params as $key => $value) 
                {
                    $bindKey = ':' . $key;
                    $stmt->bindValue($bindKey, $params[$key]);
                }
            }
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo 'Data base problem:<br>';
            echo $e->getMessage(); 
            die();
        }
    }
    
    public function InsertDataByQ($query, $data) {
        $stmt = $this->link->prepare($query);
        $stmt->execute($data);
    }

    //Запрос на выборку из БД
    public function selectQuery($query,array $params = null) {
        try {
            $stmt= $this->link->prepare($query);
            if ($params) 
            {
                foreach ($params as $key => $value) 
                {
                    $bindKey = ':' . $key;
                    $stmt->bindValue($bindKey, $params[$key]);
                }
            }
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo 'Data base problem:<br>';
            echo $e->getMessage(); 
            die();            
        }
    }

}
