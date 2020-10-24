<?php

namespace App\Controller;

use config\BaseTemplate;

class HomeController extends BaseTemplate
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->render('home.html.twig', ['test' => 'testman']);
    }
}