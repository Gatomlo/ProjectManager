<?php

namespace Gatomlo\ProjectManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class UserController extends Controller
{
    public function allAction()
    {
        return $this->render('@GatomloProjectManager/User/all.html.twig');
    }
    public function viewAction()
    {
        return $this->render('@GatomloProjectManager/User/view.html.twig');
    }
    public function addAction()
    {
        return $this->render('@GatomloProjectManager/User/add.html.twig');
    }
    public function deleteAction()
    {
        return $this->render('@GatomloProjectManager/User/delete.html.twig');
    }
}
