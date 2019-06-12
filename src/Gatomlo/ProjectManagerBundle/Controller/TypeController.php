<?php

namespace Gatomlo\ProjectManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Gatomlo\ProjectManagerBundle\Entity\Type;
use Gatomlo\ProjectManagerBundle\Entity\Event;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Gatomlo\ProjectManagerBundle\Form\TypeType;

class TypeController extends Controller
{
  public function allAction()
  {
    $em = $this->getDoctrine()->getManager();
    $type = $em->getRepository('GatomloProjectManagerBundle:Type')->findAll();
    return $this->render('@GatomloProjectManager/Type/type.all.html.twig',array('type'=>$type));
  }
  public function addAction(Request $request)
  {
    $type = new Type();
    $form = $this->get('form.factory')->create(TypeType::class, $type);
    // Si la requête est en POST
     if ($request->isMethod('POST')) {
       $form->handleRequest($request);
       if ($form->isValid()) {
         $em = $this->getDoctrine()->getManager();
         $em->persist($type);
         $em->flush();
         return $this->redirectToRoute('gatomlo_project_manager_admin_all_type');
       }
     }
    return $this->render('@GatomloProjectManager/Type/type.add.html.twig', array(
        'form' => $form->createView(),
        'type' => $type
      ));
  }
  public function editAction(Request $request,$id)
  {
    $em = $this->getDoctrine()->getManager();
    $type = $em->getRepository('GatomloProjectManagerBundle:Type')->find($id);
    $form = $this->get('form.factory')->create(TypeType::class, $type);
    if ($request->isMethod('POST')) {
      $form->handleRequest($request);
      if ($form->isValid()) {
        $em->persist($type);
        $em->flush();
        return $this->redirectToRoute('gatomlo_project_manager_admin_all_type');
     }}
     return $this->render('@GatomloProjectManager/Type/type.add.html.twig', array(
         'form' => $form->createView(),
         'type' => $type
       ));
  }
  public function deleteAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $type = $em->getRepository('GatomloProjectManagerBundle:Type')->find($id);
    $listOfEvents = $em->getRepository('GatomloProjectManagerBundle:Event')->findBy(array(
      'type'=>$type
    ));
    foreach ($listOfEvents as $key => $event) {
      $event->setType(null);
    }
    $em->flush();
    $em->remove($type);
    $em->flush();
    return $this->redirectToRoute('gatomlo_project_manager_admin_all_type');
  }
}
