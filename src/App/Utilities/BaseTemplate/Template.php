<?php

namespace App\Utilities\BaseTemplate;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

Abstract class Template
{
    private $loader;

    public function __construct()
    {
        $directory = new FilesystemLoader( '../template');
        $this->loader = new Environment($directory);
    }

    protected function render($twig, $array = array())
    {
        try {
            echo $this->loader->render($twig, $array);
        } catch (LoaderError $e) {
        } catch (RuntimeError $e) {
        } catch (SyntaxError $e) {
        }
    }

}