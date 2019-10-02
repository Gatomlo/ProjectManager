<?php

namespace Gatomlo\ProjectManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Gatomlo\ProjectManagerBundle\Entity\Document;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Gatomlo\ProjectManagerBundle\Form\DocumentType;
use Gatomlo\ProjectManagerBundle\Entity\Project;

class DocumentController extends Controller
{
  public function allAction()
  {
    $em = $this->getDoctrine()->getManager();
    if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
      $documents = $em->getRepository('GatomloProjectManagerBundle:Document')->findAll();
     }
    else{
      $documents = $em->getRepository('GatomloProjectManagerBundle:Document')->getDocumentsFromOwner($this->getUser());
    }
    return $this->render('@GatomloProjectManager/Document/documents.all.html.twig',array('documents'=>$documents));
  }
  public function allForAction(Project $projectId)
  {
      $em = $this->getDoctrine()->getManager();
      $documents = $em->getRepository('GatomloProjectManagerBundle:Document')->findBy(array(
        'project'=>$projectId
      ));
      return $this->render('@GatomloProjectManager/Document/documents.allFor.html.twig',array('documents'=>$documents,'project'=>$projectId));
  }
  public function addAction(Request $request, Project $projectId= null)
  {
    $document = new Document();
    if ($projectId == null){
      $fromProject = FALSE;
    }
    else{
      $fromProject = TRUE;
    }
    $form = $this->get('form.factory')->create(DocumentType::class, $document, array(
      'project'=>$projectId,
      'curentUser'=>$this->getUser()
    ));
    // Si la requête est en POST
     if ($request->isMethod('POST')) {
       $form->handleRequest($request);
       if ($form->isValid()) {
         $em = $this->getDoctrine()->getManager();
         $document->setProject($projectId);
         $em->persist($document);
         $em->flush();
         if($fromProject){
            return $this->redirectToRoute('gatomlo_project_manager_all_documents_from_project', array('projectId' => $projectId->getId()));
         }
         else{
            return $this->redirectToRoute('gatomlo_project_manager_all_documents');
         }
       }
     }
    return $this->render('@GatomloProjectManager/Document/document.add.html.twig', array(
        'form' => $form->createView(),
        'document' => $document
      ));
  }
  public function deleteAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $document = $em->getRepository('GatomloProjectManagerBundle:Document')->find($id);
    $project= $document->getProject();
    $em->flush();
    $em->remove($document);
    $em->flush();
    return $this->redirectToRoute('gatomlo_project_manager_all_documents_from_project', array('projectId' => $project->getId()));
  }
}
