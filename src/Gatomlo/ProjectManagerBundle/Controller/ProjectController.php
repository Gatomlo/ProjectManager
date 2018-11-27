<?php

namespace Gatomlo\ProjectManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Gatomlo\ProjectManagerBundle\Entity\Project;


class ProjectController extends Controller
{
  public function allAction()
  {
      $em = $this->getDoctrine()->getManager();
      $projects = $em->getRepository('GatomloProjectManagerBundle:Project')->findAll();
      return $this->render('@GatomloProjectManager/Project/project.all.html.twig',array('projects'=>$projects));
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

  public function addParentAction($idChild,$idParent)
  {
      $em = $this->getDoctrine()->getManager();
      $child = $em->getRepository('GatomloProjectManagerBundle:Project')->find($idChild);
      $parent = $em->getRepository('GatomloProjectManagerBundle:Project')->find($idParent);

      $parent->addChild($child);
      $child->setParent($parent);

      $em->persist($child);
      $em->persist($parent);
      $em->flush();

      return $this->render('@GatomloProjectManager/Project/project.default.html.twig',array(
        'child'=>$child,
        'parent'=>$parent));
  }
}
