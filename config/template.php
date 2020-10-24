<?php

namespace config;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class BaseTemplate
{
    private $loader;

    public function __construct()
    {
        $directory = new FilesystemLoader( '../template');
        $this->loader = new Environment($directory);
    }

    protected function render($twig, $array = array())
    {
        echo $this->loader->render($twig, $array);
    }

}