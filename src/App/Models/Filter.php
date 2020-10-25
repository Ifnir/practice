<?php

namespace App\Models;

class Filter {

    public function __construct() 
    {

    }
    
    public function GetData(User $class) {
        return $class->hi();
    }

    public function test() {
        return 'test';
    }
}