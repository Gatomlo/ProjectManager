<?php

namespace Gatomlo\ProjectManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Gatomlo\ProjectManagerBundle\Entity\Tags;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Gatomlo\ProjectManagerBundle\Form\TagsType;

class TagsController extends Controller
{
  public function jsonTagsListAction($type)
  {
      $em = $this->getDoctrine()->getManager();
      $tags = $em->getRepository('GatomloProjectManagerBundle:Tags')->findBy(
        array(
          'type'=>$type
        )
      );
      $list_tags = array();
      foreach ($tags as $tag){
          $obj['id'] = $tag->getId();
          $obj['text'] = $tag->getName();
          array_push($list_tags,$obj);
      }
      return new JsonResponse($list_tags);
  }
  public function allAction()
  {
    $em = $this->getDoctrine()->getManager();
    $tags = $em->getRepository('GatomloProjectManagerBundle:Tags')->findAll();
    return $this->render('@GatomloProjectManager/Tags/tags.all.html.twig',array('tags'=>$tags));
  }
  public function addAction(Request $request)
  {
    $tags = new Tags();
    $form = $this->get('form.factory')->create(TagsType::class, $tags);
    // Si la requête est en POST
     if ($request->isMethod('POST')) {
       $form->handleRequest($request);
       if ($form->isValid()) {
         $em = $this->getDoctrine()->getManager();
         $em->persist($tags);
         $em->flush();
         return $this->redirectToRoute('gatomlo_project_manager_admin_all_tags');
       }
     }
    return $this->render('@GatomloProjectManager/Tags/tags.add.html.twig', array(
        'form' => $form->createView(),
        'tags' => $tags
      ));
  }
  public function editAction(Request $request,$id)
  {
    $em = $this->getDoctrine()->getManager();
    $isAdmin = false;
    $tags = $em->getRepository('GatomloProjectManagerBundle:Tags')->find($id);
    $form = $this->get('form.factory')->create(TagsType::class, $tags);
    if ($request->isMethod('POST')) {
      $form->handleRequest($request);
      if ($form->isValid()) {
        $em->persist($tags);
        $em->flush();
        return $this->redirectToRoute('gatomlo_project_manager_admin_all_tags');
     }}
     return $this->render('@GatomloProjectManager/Tags/tags.add.html.twig', array(
         'form' => $form->createView(),
         'tags' => $tags
       ));
  }
  public function deleteAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $tags = $em->getRepository('GatomloProjectManagerBundle:Tags')->find($id);
    $em->remove($tags);
    $em->flush();
    return $this->redirectToRoute('gatomlo_project_manager_admin_all_tags');
  }
}
