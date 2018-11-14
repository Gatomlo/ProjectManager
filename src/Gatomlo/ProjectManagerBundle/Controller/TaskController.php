<?php

namespace Gatomlo\ProjectManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class TaskController extends Controller
{
  public function allAction()
  {
      return $this->render('@GatomloProjectManager/Task/all.html.twig');
  }
  public function viewAction($id)
  {
      return $this->render('@GatomloProjectManager/Task/view.html.twig');
  }
  public function addAction()
  {
      return $this->render('@GatomloProjectManager/Task/add.html.twig');
  }
  public function editAction($id)
  {
      return $this->render('@GatomloProjectManager/Task/edit.html.twig');
  }
  public function deleteAction($id)
  {
      return $this->render('@GatomloProjectManager/Task/delete.html.twig');
  }
}
