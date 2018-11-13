<?php

namespace Gatomlo\ProjectManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class EventController extends Controller
{
    public function allAction()
    {
        return $this->render('@GatomloProjectManager/Event/all.html.twig');
    }
    public function viewAction()
    {
        return $this->render('@GatomloProjectManager/Event/view.html.twig');
    }
    public function addAction()
    {
        return $this->render('@GatomloProjectManager/Event/add.html.twig');
    }
    public function deleteAction()
    {
        return $this->render('@GatomloProjectManager/Event/delete.html.twig');
    }
}
