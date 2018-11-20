<?php

namespace Gatomlo\ProjectManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Gatomlo\ProjectManagerBundle\Entity\Project;


class ProjectController extends Controller
{
  public function allAction()
  {
      return $this->render('@GatomloProjectManager/Project/all.html.twig');
  }
  public function viewAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $project = $em->getRepository('GatomloProjectManagerBundle:Project')->find($id);

      if (null === $project) {
        throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
      }


      return $this->render('@GatomloProjectManager/Project/project.view.html.twig',array(
        'project'=>$project));
  }
  public function addAction()
  {
      return $this->render('@GatomloProjectManager/Project/add.html.twig');
  }
  public function editAction($id)
  {
      return $this->render('@GatomloProjectManager/Project/edit.html.twig');
  }
  public function deleteAction($id)
  {
      return $this->render('@GatomloProjectManager/Project/delete.html.twig');
  }
}
