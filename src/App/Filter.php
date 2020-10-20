<?php

namespace App;

use src\User;

class Filter {

    public function __construct() 
    {

    }
    
    public function GetData(User $class) {
        return $class->hi();
    }
}