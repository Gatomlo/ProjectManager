<?php

namespace Gatomlo\ProjectManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Gatomlo\ProjectManagerBundle\Entity\Event;
use Gatomlo\ProjectManagerBundle\Entity\Project;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
  public function addAction(Request $request)
  {

    $event = new Event();

    $form = $this->get('form.factory')->create(EventType::class, $event);

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
       $em->persist($event);
       $em->flush();

       $request->getSession()->getFlashBag()->add('notice', 'Evénement bien enregistré.');

       return $this->redirectToRoute('gatomlo_project_manager_one_event', array('id' => $event->getId()));
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

    $form = $this->get('form.factory')->create(EventType::class, $event);

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
       $em->persist($event);
       $em->flush();

       $request->getSession()->getFlashBag()->add('notice', 'Evénement bien enregistré.');

       // On redirige vers la page de visualisation de l'annonce nouvellement créée
       return $this->redirectToRoute('gatomlo_project_manager_one_event', array('id' => $event->getId()));
     }
   }
    return $this->render('@GatomloProjectManager/Event/event.add.html.twig', array(
      'form' => $form->createView(),
      'event'=> $event
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
