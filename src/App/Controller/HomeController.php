<?php

namespace App\Controller;

use App\Utilities\BaseTemplate\Template;
use App\Models\Filter;

class HomeController extends Template
{
    private $test;

    public function __construct()
    {
        parent::__construct();
        $this->test = new Filter();
    }

    public function index()
    {
        $this->render('home.html.twig', ['test' => 'testman', 'filter' => $this->test->test()]);
    }
}