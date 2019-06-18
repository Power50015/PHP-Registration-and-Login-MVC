<?php
namespace MVC\Controllers;

use MVC\LIB\Helper;

class IndexController extends AbstractController
{
    use Helper;
    public function defaultAction()
    {
        $this->redirect('/login/');
    }
}
