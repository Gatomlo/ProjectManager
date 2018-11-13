<?php

namespace Gatomlo\ProjectManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class ProjectController extends Controller
{
    public function allAction()
    {
        return $this->render('@GatomloProjectManager/Project/all.html.twig');
    }
    public function viewAction()
    {
        return $this->render('@GatomloProjectManager/Project/view.html.twig');
    }
    public function addAction()
    {
        return $this->render('@GatomloProjectManager/Project/add.html.twig');
    }
    public function deleteAction()
    {
        return $this->render('@GatomloProjectManager/Project/delete.html.twig');
    }
}
