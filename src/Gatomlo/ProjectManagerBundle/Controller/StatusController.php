<?php

namespace Gatomlo\ProjectManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Gatomlo\ProjectManagerBundle\Entity\Status;
use Gatomlo\ProjectManagerBundle\Entity\Project;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Gatomlo\ProjectManagerBundle\Form\StatusType;

class StatusController extends Controller
{
  public function allAction()
  {
    $em = $this->getDoctrine()->getManager();
    $status = $em->getRepository('GatomloProjectManagerBundle:Status')->findAll();
    return $this->render('@GatomloProjectManager/Status/status.all.html.twig',array('status'=>$status));
  }
  public function addAction(Request $request)
  {
    $status = new Status();
    $form = $this->get('form.factory')->create(StatusType::class, $status);
    // Si la requête est en POST
     if ($request->isMethod('POST')) {
       $form->handleRequest($request);
       if ($form->isValid()) {
         $em = $this->getDoctrine()->getManager();
         $em->persist($status);
         $em->flush();
         return $this->redirectToRoute('gatomlo_project_manager_admin_all_status');
       }
     }
    return $this->render('@GatomloProjectManager/Status/status.add.html.twig', array(
        'form' => $form->createView(),
        'status' => $status
      ));
  }
  public function editAction(Request $request,$id)
  {
    $em = $this->getDoctrine()->getManager();
    $status = $em->getRepository('GatomloProjectManagerBundle:Status')->find($id);
    $form = $this->get('form.factory')->create(StatusType::class, $status);
    if ($request->isMethod('POST')) {
      $form->handleRequest($request);
      if ($form->isValid()) {
        $em->persist($status);
        $em->flush();
        return $this->redirectToRoute('gatomlo_project_manager_admin_all_status');
     }}
     return $this->render('@GatomloProjectManager/Status/status.add.html.twig', array(
         'form' => $form->createView(),
         'status' => $status
       ));
  }
  public function deleteAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $status = $em->getRepository('GatomloProjectManagerBundle:Status')->find($id);
    $listOfProjects = $em->getRepository('GatomloProjectManagerBundle:Project')->findBy(array(
      'status'=>$status
    ));
    foreach ($listOfProjects as $key => $project) {
      $project->setStatus(null);
    }
    $em->flush();
    $em->remove($status);
    $em->flush();
    return $this->redirectToRoute('gatomlo_project_manager_admin_all_status');
  }
}
