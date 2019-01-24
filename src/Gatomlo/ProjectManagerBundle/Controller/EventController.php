<?php

namespace Gatomlo\ProjectManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Gatomlo\ProjectManagerBundle\Entity\Event;
use Gatomlo\ProjectManagerBundle\Entity\Project;
use Gatomlo\ProjectManagerBundle\Entity\Tags;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Gatomlo\ProjectManagerBundle\Form\EventType;



class EventController extends Controller
{
  public function allAction()
  {
      $em = $this->getDoctrine()->getManager();
      $events = $em->getRepository('GatomloProjectManagerBundle:Event')->findAll();
      return $this->render('@GatomloProjectManager/Event/event.all.html.twig',array('events'=>$events));
  }
  public function allForAction(Project $projectId)
  {
      $em = $this->getDoctrine()->getManager();
      $events = $em->getRepository('GatomloProjectManagerBundle:Event')->findBy(array(
        'project'=>$projectId
      ));
      return $this->render('@GatomloProjectManager/Event/event.allFor.html.twig',array('events'=>$events,'project'=>$projectId));
  }
  public function viewAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $event = $em->getRepository('GatomloProjectManagerBundle:Event')->find($id);

      if (null === $event) {
        throw new NotFoundHttpException("L'événement ".$id." n'existe pas.");
      }
      return $this->render('@GatomloProjectManager/Event/event.view.html.twig',array(
        'event'=>$event));
  }
  public function addAction(Request $request, Project $projectId = null )
  {

    $event = new Event();
    if ($projectId == null){
      $fromProject = FALSE;
    }
    else{
      $fromProject = TRUE;
    }

    $form = $this->get('form.factory')->create(EventType::class, $event, array(
      'project'=>$projectId
    ));

    // Si la requête est en POST
   if ($request->isMethod('POST')) {
     // On fait le lien Requête <-> Formulaire
     // À partir de maintenant, la variable $advert contient les valeurs entrées dans le formulaire par le visiteur
     $form->handleRequest($request);

     // On vérifie que les valeurs entrées sont correctes
     // (Nous verrons la validation des objets en détail dans le prochain chapitre)
     if ($form->isValid()) {
       // On enregistre notre objet $advert dans la base de données, par exemple
       $em = $this->getDoctrine()->getManager();
        $tagsArray = $form['tagsArray']->getData();
        $tags = explode(",",$tagsArray);
        foreach ($tags as $tag) {
          $existingTag = $em->getRepository('GatomloProjectManagerBundle:Tags')->findOneBy(array(
            'name'=> $tag
          ));

          if (empty($existingTag)){
            $newTag = new Tags();
            $newTag->setName($tag);
            $event->addTag($newTag);
          }

          else {
            $event->addTag($existingTag);
          }
        }
       $em->persist($event);
       $em->flush();

       $request->getSession()->getFlashBag()->add('notice', 'Evénement bien enregistré.');

       if($fromProject){
          return $this->redirectToRoute('gatomlo_project_manager_all_events_from_a_project', array('projectId' => $event->getProject()->getId()));
       }
       else{
          return $this->redirectToRoute('gatomlo_project_manager_all_events');
       }

     }
   }


    // On passe la méthode createView() du formulaire à la vue
    // afin qu'elle puisse afficher le formulaire toute seule
    return $this->render('@GatomloProjectManager/Event/event.add.html.twig', array(
      'form' => $form->createView(),
      'event'=>$event
    ));
  }

  public function editAction(Request $request, $id)
  {

    $em = $this->getDoctrine()->getManager();
    $event = $em->getRepository('GatomloProjectManagerBundle:Event')->find($id);
    $project = $event->getProject();

    //Récupération des tags
    $existingTags = $event->getTags();
    //Création d'un tableau vide
    $existingTagsArray = [];
    // Pour chaque tag, on récupére le nom et on l'insère dans le tableau vide.
    foreach ($existingTags as $tag) {
      $currentTag = $tag->getName();
      array_push($existingTagsArray, $currentTag);
    };
    // On transforme le tableau en string pour pouvoir être inséré dans le champ texte selectize
    $existingTagsStringFormat = implode(',',$existingTagsArray);


    $form = $this->get('form.factory')->create(EventType::class, $event, array(
      'existingTags'=>$existingTagsStringFormat,
      'project'=>$project));

    // Si la requête est en POST
   if ($request->isMethod('POST')) {
     // On fait le lien Requête <-> Formulaire
     // À partir de maintenant, la variable $advert contient les valeurs entrées dans le formulaire par le visiteur
     $form->handleRequest($request);

     // On vérifie que les valeurs entrées sont correctes
     // (Nous verrons la validation des objets en détail dans le prochain chapitre)
     if ($form->isValid()) {

       foreach ($existingTags as $tag) {
         $event->removeTag($tag);
       };
       // On enregistre notre objet $advert dans la base de données, par exemple
       $em = $this->getDoctrine()->getManager();
        // On enregistre notre objet $advert dans la base de données, par exemple
        $tagsArray = $form['tagsArray']->getData();
        $tags = explode(",",$tagsArray);
        foreach ($tags as $tag) {
          $existingTag = $em->getRepository('GatomloProjectManagerBundle:Tags')->findOneBy(array(
            'name'=> $tag
          ));

          if (empty($existingTag)){
            $newTag = new Tags();
            $newTag->setName($tag);
            $event->addTag($newTag);
          }

          else {
            $event->addTag($existingTag);
          }
        }
       $em->persist($event);
       $em->flush();

       $request->getSession()->getFlashBag()->add('notice', 'Evénement bien enregistré.');

       // On redirige vers la page de visualisation de l'annonce nouvellement créée
       return $this->redirectToRoute('gatomlo_project_manager_one_event', array('id' => $event->getId()));
     }
   }
    return $this->render('@GatomloProjectManager/Event/event.add.html.twig', array(
      'form' => $form->createView(),
      'event'=> $event,
    ));
  }

  public function deleteAction($id,$from)
  {
      $em = $this->getDoctrine()->getManager();
      $event = $em->getRepository('GatomloProjectManagerBundle:Event')->find($id);
      $project = $em->getRepository('GatomloProjectManagerBundle:Event')->find($event->getProject())->getId();
      $em->remove($event);
      $em->flush();

      if($from == 'events'){
        return $this->redirectToRoute('gatomlo_project_manager_all_events');
      }
      else{
        return $this->redirectToRoute('gatomlo_project_manager_all_events_from_a_project',array('projectId'=>$project));
      }

  }

}
