<?php

namespace App\Models;

class Filter extends Model
{

    public function GetData(User $class) {
        return $class->hi();
    }

    public function test() {
        return 'test';
    }
}