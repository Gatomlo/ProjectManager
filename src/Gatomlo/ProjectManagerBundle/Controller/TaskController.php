<?php

namespace Gatomlo\ProjectManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Gatomlo\ProjectManagerBundle\Entity\Task;
use Gatomlo\ProjectManagerBundle\Entity\Project;
use Gatomlo\ProjectManagerBundle\Entity\Tags;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Gatomlo\ProjectManagerBundle\Form\EventType;
use Gatomlo\ProjectManagerBundle\Form\TaskType;



class TaskController extends Controller
{
  public function allAction()
  {
      $em = $this->getDoctrine()->getManager();
      $tasks = $em->getRepository('GatomloProjectManagerBundle:Task')->findAll();
      return $this->render('@GatomloProjectManager/Task/task.all.html.twig',array('tasks'=>$tasks));
  }
  public function allForAction(Project $projectId)
  {
      $em = $this->getDoctrine()->getManager();
      $tasks = $em->getRepository('GatomloProjectManagerBundle:Task')->findBy(array(
        'project'=>$projectId
      ));
      return $this->render('@GatomloProjectManager/Task/task.allFor.html.twig',array('tasks'=>$tasks,'project'=>$projectId));
  }

  public function addAction(Request $request, Project $projectId = null )
  {

    $task = new Task();
    if ($projectId == null){
      $fromProject = FALSE;
    }
    else{
      $fromProject = TRUE;
    }

    $form = $this->get('form.factory')->create(TaskType::class, $task, array(
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
            $task->addTag($newTag);
          }

          else {
            $task->addTag($existingTag);
          }
        }
       $em->persist($task);
       $em->flush();

       $request->getSession()->getFlashBag()->add('notice', 'Evénement bien enregistré.');

       if($fromProject){
          return $this->redirectToRoute('gatomlo_project_manager_all_tasks_from_a_project', array('projectId' => $task->getProject()->getId()));
       }
       else{
          return $this->redirectToRoute('gatomlo_project_manager_all_tasks');
       }

     }
   }


    // On passe la méthode createView() du formulaire à la vue
    // afin qu'elle puisse afficher le formulaire toute seule
    return $this->render('@GatomloProjectManager/Task/task.add.html.twig', array(
      'form' => $form->createView(),
      'task'=>$task
    ));
  }

  public function editAction(Request $request, $id)
  {

    $em = $this->getDoctrine()->getManager();
    $task = $em->getRepository('GatomloProjectManagerBundle:Task')->find($id);
    $project = $task->getProject();

    //Récupération des tags
    $existingTags = $task->getTags();
    //Création d'un tableau vide
    $existingTagsArray = [];
    // Pour chaque tag, on récupére le nom et on l'insère dans le tableau vide.
    foreach ($existingTags as $tag) {
      $currentTag = $tag->getName();
      array_push($existingTagsArray, $currentTag);
    };
    // On transforme le tableau en string pour pouvoir être inséré dans le champ texte selectize
    $existingTagsStringFormat = implode(',',$existingTagsArray);


    $form = $this->get('form.factory')->create(TaskType::class, $task, array(
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
         $task->removeTag($tag);
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
            $task->addTag($newTag);
          }

          else {
            $task->addTag($existingTag);
          }
        }
       $em->persist($task);
       $em->flush();

       $request->getSession()->getFlashBag()->add('notice', 'Evénement bien enregistré.');

       // On redirige vers la page de visualisation de l'annonce nouvellement créée
       return $this->redirectToRoute('gatomlo_project_manager_all_tasks');
     }
   }
    return $this->render('@GatomloProjectManager/Task/task.add.html.twig', array(
      'form' => $form->createView(),
      'task'=> $task,
    ));
  }

  public function closeAction($id,$from)
  {
      $em = $this->getDoctrine()->getManager();
      $task = $em->getRepository('GatomloProjectManagerBundle:Task')->find($id);
      $task->setClosed(True);
      $em->persist($task);
      $em->flush();

      if($from == 'tasks'){
        return $this->redirectToRoute('gatomlo_project_manager_all_tasks');
      }
      else{
        return $this->redirectToRoute('gatomlo_project_manager_all_tasks_from_a_project',array('projectId'=>$project));
      }

  }

  public function deleteAction($id,$from)
  {
      $em = $this->getDoctrine()->getManager();
      $task = $em->getRepository('GatomloProjectManagerBundle:Task')->find($id);
      $project = $em->getRepository('GatomloProjectManagerBundle:Project')->find($task->getProject())->getId();
      $em->remove($task);
      $em->flush();

      // if($from == 'tasks'){
        return $this->redirectToRoute('gatomlo_project_manager_all_tasks');
      // }
      // else{
      //   return $this->redirectToRoute('gatomlo_project_manager_all_tasks_from_a_project',array('projectId'=>$project));
      // }

  }

}
