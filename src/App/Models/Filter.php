<?php

namespace App\Models;

use src\Models\User;

class Filter {

    public function __construct() 
    {

    }
    
    public function GetData(User $class) {
        return $class->hi();
    }
}