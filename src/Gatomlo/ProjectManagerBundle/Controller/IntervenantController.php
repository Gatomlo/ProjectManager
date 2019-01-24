<?php

namespace Gatomlo\ProjectManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Gatomlo\ProjectManagerBundle\Entity\Intervenant;
use Gatomlo\ProjectManagerBundle\Entity\Project;
use Gatomlo\ProjectManagerBundle\Entity\Tags;
use Gatomlo\ProjectManagerBundle\Entity\People;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Gatomlo\ProjectManagerBundle\Form\EventType;
use Gatomlo\ProjectManagerBundle\Form\IntervenantType;



class IntervenantController extends Controller
{
  public function allAction()
  {
      $em = $this->getDoctrine()->getManager();
      $intervenants = $em->getRepository('GatomloProjectManagerBundle:Intervenant')->findAll();
      return $this->render('@GatomloProjectManager/Intervenant/intervenant.all.html.twig',array('intervenant'=>$intevenants));
  }

  public function allForProjectAction(Project $projectId)
  {
      $em = $this->getDoctrine()->getManager();
      $intervenants = $em->getRepository('GatomloProjectManagerBundle:Intervenant')->findBy(array(
        'project'=>$projectId
      ));
      return $this->render('@GatomloProjectManager/Intervenant/intervenant.allForProject.html.twig',array('intervenants'=>$intervenants,'project'=>$projectId));
  }

  public function allForPeopleAction(People $peopleId, $isArchived)
  {
      $em = $this->getDoctrine()->getManager();
      $intervenants = $em->getRepository('GatomloProjectManagerBundle:Intervenant')->findBy(array(
        'people'=>$peopleId
        
      ));
      return $this->render('@GatomloProjectManager/Intervenant/intervenant.allForPeople.html.twig',array('intervenants'=>$intervenants,'people'=>$peopleId));
  }

  public function addAction(Request $request, $id = null, $from )
  {

    $em = $this->getDoctrine()->getManager();

    if($from == 'project'){
      $project = $em->getRepository('GatomloProjectManagerBundle:Project')->find($id);
      $people = null;
    }
    elseif($from == 'people'){
      $people = $em->getRepository('GatomloProjectManagerBundle:People')->find($id);
      $project = null;
    }
    $intervenant = new Intervenant();
    $form = $this->get('form.factory')->create(IntervenantType::class, $intervenant,array(
      'project'=>$project,
      'people'=>$people
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
       $em->persist($intervenant);
       $em->flush();

       // On redirige vers la page de visualisation de l'annonce nouvellement créée
       if($from =='project'){
         return $this->redirectToRoute('gatomlo_project_manager_all_intervenants_from_a_project', array('projectId' => $intervenant->getProject()->getId()));
       }
       elseif ($from =='people') {
         return $this->redirectToRoute('gatomlo_project_manager_all_intervenants_from_a_people',array('peopleId'=>$intervenant->getPeople()->getId()));
       }

     }
   }

    // On passe la méthode createView() du formulaire à la vue
    // afin qu'elle puisse afficher le formulaire toute seule
    return $this->render('@GatomloProjectManager/Intervenant/intervenant.add.html.twig', array(
      'form' => $form->createView(),
      'project'=> $project,
      'people'=>$people,
      'intervenant' => $intervenant,
      'new'=>true
    ));
  }


  public function editAction(Request $request, Intervenant $id, $from)
  {
    $intervenant = $id;
    if($from == 'project'){
      $people = null;
      $project = $intervenant->getProject();
    }
    elseif ($from == 'people') {
      $people = $intervenant->getPeople();
      $project = null;
    }
    $form = $this->get('form.factory')->create(IntervenantType::class, $intervenant, array(
      'project'=>$intervenant->getProject(),
      'people'=>$intervenant->getPeople()
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
       $em->persist($intervenant);
       $em->flush();

       if($from =='project'){
         return $this->redirectToRoute('gatomlo_project_manager_all_intervenants_from_a_project', array('projectId' => $intervenant->getProject()->getId()));
       }
       elseif($from == 'people'){
         return $this->redirectToRoute('gatomlo_project_manager_all_intervenants_from_a_people',array('peopleId'=>$intervenant->getPeople()->getId()));
       }
     }
   }

       // On passe la méthode createView() du formulaire à la vue
       // afin qu'elle puisse afficher le formulaire toute seule
       return $this->render('@GatomloProjectManager/Intervenant/intervenant.add.html.twig', array(
         'form' => $form->createView(),
         'project' => $project,
         'people' => $people,
         'new'=>false,
         'intervenant'=>$intervenant

       ));
  }
   public function deleteAction($id,$from)
   {
       $em = $this->getDoctrine()->getManager();
       $intervenant = $em->getRepository('GatomloProjectManagerBundle:Intervenant')->find($id);
       // $project = $em->getRepository('GatomloProjectManagerBundle:Intervenant')->find($intervenant->getProject())->getId();
       $em->remove($intervenant);
       $em->flush();

       if($from == 'project'){
         return $this->redirectToRoute('gatomlo_project_manager_all_intervenants_from_a_project', array('projectId' => $intervenant->getProject()->getId()));
       }
       else{
         return $this->redirectToRoute('gatomlo_project_manager_all_intervenants_from_a_people',array('peopleId'=>$intervenant->getPeople()->getId()));
       }

   }

}
