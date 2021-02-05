<?php

namespace App\ORM;

use PDO;

class Database implements QueryBuilderInterface
{
   private $hostname = 'localhost';
   private $username = 'root';
   private $passwd = '';
   private $dbname = 'practice';

   private $dbh;
   private $error;
   private $stmt;

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

   public function query($query)
   {
       $this->stmt = $this->dbh->prepare($query);
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
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function select($table, $fields)
    {
        $this->query('SELECT ' . $fields . ' FROM ' . $table);
    }

    public function where($row, $value)
    {
        return ' WHERE ' . $row . ' = ' . $value;
    }

    public function and($row, $value)
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
