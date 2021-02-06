<?php

namespace App\ORM;

use PDO;

class Database
{
   private $hostname = 'localhost';
   private $username = 'root';
   private $passwd = '';
   private $dbname = 'practice';

   private $dbh;
   private $error;
   private $stmt;

   public $queryLine;

   public function __construct()
   {
       $dsn = 'mysql:host=' . $this->hostname . ';dbname=' . $this->dbname;

       $options = [
           PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
           PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
           PDO::ATTR_EMULATE_PREPARES   => false,
       ];

       try {
           $this->dbh = new PDO($dsn, $this->username, $this->passwd, $options);
       } catch (\PDOException $e) {
           throw new \PDOException($e->getMessage(), (int)$e->getCode());
       }
   }

   public function query()
   {
       $this->stmt = $this->dbh->prepare($this->queryLine);
   }

   public function bind($param, $value, $type = null)
   {
        if(is_null($type))
        {
            switch (true)
            {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
   }


    public function execute()
    {
        return $this->stmt->execute();
    }

    public function result()
    {
        $this->query();
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function select($table, $fields) : self
    {
        $this->queryLine = 'SELECT ' . $fields . ' FROM ' . $table;
        return $this;
    }

    public function where($row, $value) : self
    {
        $this->queryLine .=' WHERE ' . $row . ' = ' . $value;
        return $this;
    }

    public function and($row, $value) : self
    {
        return ' AND ' . $row . ' = ' . $value;
    }

    public function or($row, $value)
    {
        return ' OR ' . $row . ' = ' . $value;
    }

    public function whereNot($row, $value)
    {
        return ' WHERE NOT ' . $row . ' = ' . $value;
    }

    public function andNot($row, $value)
    {
        return ' AND NOT ' . $row . ' = ' . $value;
    }

    public function orNot($row, $value)
    {
        return ' OR NOT ' . $row . ' = ' . $value;
    }
}
