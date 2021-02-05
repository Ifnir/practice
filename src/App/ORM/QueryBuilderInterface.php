<?php

namespace App\ORM;

interface QueryBuilderInterface
{
    public function select($table, array $fields);
    public function where($row, $value);
    public function and($row, $value);
    public function or($row, $value);
    public function whereNot($row, $value);
    public function andNot($row, $value);
    public function orNot($row, $value);
    public function execute();
}