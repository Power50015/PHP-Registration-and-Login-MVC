<?php
namespace MVC\Controllers;

class IndexController extends AbstractController
{
    public function defaultAction()
    {
        $this->_view();
    }
    public function addAction()
    {
        $this->_view();
    }
}
