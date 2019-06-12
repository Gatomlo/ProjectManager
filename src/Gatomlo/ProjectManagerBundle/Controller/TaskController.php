<?php

namespace Gatomlo\ProjectManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Gatomlo\ProjectManagerBundle\Entity\Task;
use Gatomlo\ProjectManagerBundle\Entity\Project;
use Gatomlo\ProjectManagerBundle\Entity\Event;
use Gatomlo\ProjectManagerBundle\Entity\Tags;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Gatomlo\ProjectManagerBundle\Form\EventType;
use Gatomlo\ProjectManagerBundle\Form\TaskType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;



class TaskController extends Controller
{
  public function allOpenTaskAction(){
      $em = $this->getDoctrine()->getManager();
      if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
        $tasks = $em->getRepository('GatomloProjectManagerBundle:Task')->findAll();
       }
      else{
        $tasks = $em->getRepository('GatomloProjectManagerBundle:Task')->getOpenTasksFromOwner($this->getUser());
      }
      $taskArray = array();

      foreach ($tasks as $task){
        $obj['id'] = $task->getId();
        $obj['description'] = $task->getDescription();
        $obj['project'] = $task->getProject();
        $obj['enddate'] = $task->getEnddate();
        $obj['closed'] = $task->getClosed();
        $obj['tags'] = $task->getTags();
        $obj['owner'] = $task->getOwner();
        if($task->getEnddate() != null){
          if($task->getEnddate()->format('Y-m-d') > (new \DateTime("now"))->format('Y-m-d') ){
            $obj['status'] =-1;
            $obj['color'] ="green";
          }
          elseif ($task->getEnddate()->format('Y-m-d') < (new \DateTime("now"))->format('Y-m-d') ) {
            $obj['status'] =1;
            $obj['color'] ="red";
          }
          elseif ($task->getEnddate()->format('Y-m-d') == (new \DateTime("now"))->format('Y-m-d') ) {
            $obj['status'] =0;
            $obj['color'] ="orange";
          }
        }
        else{
          $obj['color'] ="grey";
        }
        array_push($taskArray,$obj);

      }
      return $this->render('@GatomloProjectManager/Task/task.all.html.twig',array('tasksArray'=>$taskArray,'openTask'=>false));
  }

  public function allClosedTaskAction(){
      $em = $this->getDoctrine()->getManager();
      if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
        $tasks = $em->getRepository('GatomloProjectManagerBundle:Task')->findAll();
       }
      else{
        $tasks = $em->getRepository('GatomloProjectManagerBundle:Task')->getOpenTasksFromOwner($this->getUser());
      }
      $taskArray = array();

      foreach ($tasks as $task){
        $obj['id'] = $task->getId();
        $obj['description'] = $task->getDescription();
        $obj['project'] = $task->getProject();
        $obj['enddate'] = $task->getEnddate();
        $obj['closed'] = $task->getClosed();
        $obj['tags'] = $task->getTags();
        $obj['owner'] = $task->getOwner();
        if($task->getEnddate() != null){
          if($task->getEnddate()->format('Y-m-d') > (new \DateTime("now"))->format('Y-m-d') ){
            $obj['status'] =-1;
            $obj['color'] ="green";
          }
          elseif ($task->getEnddate()->format('Y-m-d') < (new \DateTime("now"))->format('Y-m-d') ) {
            $obj['status'] =1;
            $obj['color'] ="red";
          }
          elseif ($task->getEnddate()->format('Y-m-d') == (new \DateTime("now"))->format('Y-m-d') ) {
            $obj['status'] =0;
            $obj['color'] ="orange";
          }
        }
        else{
          $obj['color'] ="grey";
        }
        array_push($taskArray,$obj);

      }
      return $this->render('@GatomloProjectManager/Task/task.all.html.twig',array('tasksArray'=>$taskArray,'openTask'=>true));
  }

  public function plannificatorAction(){
      $em = $this->getDoctrine()->getManager();

      if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
        $tasks = $em->getRepository('GatomloProjectManagerBundle:Task')->findBy(
          array(),
          array('closed' => 'asc')
        );
       }
      else{
        $tasks = $em->getRepository('GatomloProjectManagerBundle:Task')->getAllTasksFromOwner($this->getUser());
      }

      $list_tasks = array();
      foreach ($tasks as $task){
        if ($task->getExecutiondate() == null){
          $obj['id'] = $task->getId();
          $obj['description'] = $task->getDescription();
          $obj['closed'] = $task->getClosed();
          if($task->getEnddate() != null){
            if($task->getEnddate()->format('Y-m-d') > (new \DateTime("now"))->format('Y-m-d') ){
              $obj['status'] =-1;
              $obj['color'] ="green";
            }
            elseif ($task->getEnddate()->format('Y-m-d') < (new \DateTime("now"))->format('Y-m-d') ) {
              $obj['status'] =1;
              $obj['color'] ="red";
            }
            elseif ($task->getEnddate()->format('Y-m-d') == (new \DateTime("now"))->format('Y-m-d') ) {
              $obj['status'] =0;
              $obj['color'] ="orange";
            }
          }
          else{
            $obj['color'] ="grey";
          }
          array_push($list_tasks,$obj);
        }
      }
      return $this->render('@GatomloProjectManager/Task/task.plannificator.html.twig',array('noPlannifiedTasks'=>$list_tasks));
  }

  public function allForAction(Project $projectId){
      $em = $this->getDoctrine()->getManager();
      $openTasks = $em->getRepository('GatomloProjectManagerBundle:Task')->findBy(array(
        'project'=>$projectId,
        'closed'=> false,
      ),
      array('closed' => 'asc'));
      $openTaskArray = array();

      foreach ($openTasks as $task){

          $obj['id'] = $task->getId();
          $obj['description'] = $task->getDescription();
          $obj['enddate'] = $task->getEnddate();
          $obj['closed'] = $task->getClosed();
          $obj['tags'] = $task->getTags();
          if($task->getEnddate() != null){
            if($task->getEnddate()->format('Y-m-d') > (new \DateTime("now"))->format('Y-m-d') ){
              $obj['status'] =-1;
              $obj['color'] ="green";
            }
            elseif ($task->getEnddate()->format('Y-m-d') < (new \DateTime("now"))->format('Y-m-d') ) {
              $obj['status'] =1;
              $obj['color'] ="red";
            }
            elseif ($task->getEnddate()->format('Y-m-d') == (new \DateTime("now"))->format('Y-m-d') ) {
              $obj['status'] =0;
              $obj['color'] ="orange";
          }}
          array_push($openTaskArray,$obj);

      }

      $closedTasks = $em->getRepository('GatomloProjectManagerBundle:Task')->findBy(array(
        'project'=>$projectId,
        'closed'=> true,
      ),
      array('closed' => 'asc'));
      $closedTaskArray = array();

      foreach ($closedTasks as $task){
        $obj['id'] = $task->getId();
        $obj['description'] = $task->getDescription();
        $obj['enddate'] = $task->getEnddate();
        $obj['closed'] = $task->getClosed();
        $obj['tags'] = $task->getTags();
        array_push($closedTaskArray,$obj);
      }

      return $this->render('@GatomloProjectManager/Task/task.allFor.html.twig',array('openTasksArray'=>$openTaskArray,'closedTasksArray'=>$closedTaskArray,'project'=>$projectId));
  }

  public function addAction(Request $request, Project $projectId = null ){

    $task = new Task();
    if ($projectId == null){
      $fromProject = FALSE;
    }
    else{
      $fromProject = TRUE;
    }

    $form = $this->get('form.factory')->create(TaskType::class, $task, array(
      'project'=>$projectId,
      'curentUser'=>$this->getUser()
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
            $newTag->setType(1);
            $task->addTag($newTag);
          }

          else {
            $task->addTag($existingTag);
          }
        }
       $task->addOwner($this->getUser());
       $em->persist($task);
       $em->flush();

       $request->getSession()->getFlashBag()->add('notice', 'Evénement bien enregistré.');

       if($fromProject){
          return $this->redirectToRoute('gatomlo_project_manager_all_tasks_from_a_project', array('projectId' => $task->getProject()->getId()));
       }
       else{
          return $this->redirectToRoute('gatomlo_project_manager_all_open_tasks');
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

  public function editAction(Request $request, $id){

    $em = $this->getDoctrine()->getManager();
    $task = $em->getRepository('GatomloProjectManagerBundle:Task')->find($id);
    if($task->isOwner($this->getUser()) || $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN') ){
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
        'project'=>$project,
        'curentUser'=>$this->getUser()));

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
              $newTag->setType(1);
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
         return $this->redirectToRoute('gatomlo_project_manager_all_open_tasks');
       }
     }
      return $this->render('@GatomloProjectManager/Task/task.add.html.twig', array(
        'form' => $form->createView(),
        'task'=> $task,
      ));
      }
    else{
      return $this->redirectToRoute('gatomlo_project_manager_homepage');
    }
  }

  public function closeAction($id,$from){
      $em = $this->getDoctrine()->getManager();
      $task = $em->getRepository('GatomloProjectManagerBundle:Task')->find($id);
      if($task->isOwner($this->getUser()) || $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN') ){
        $type = $em->getRepository('GatomloProjectManagerBundle:Type')->find(1);
        $project = $em->getRepository('GatomloProjectManagerBundle:Project')->find($task->getProject()->getId());
        if($task->getClosed()==False){
          $task->setClosed(True);
          $event= new Event();
          $event->setTitle($task->getDescription());
          $event->setDescription('Tâche terminée');
          $event->setType($type);
          $event->setStartdate(new \DateTime("now"));
          $event->setProject($project);
          $em->persist($event);
        }
        else{
          $task->setClosed(False);
        }
        $em->persist($task);
        $em->flush();

        if($from == 'tasks'){
          return $this->redirectToRoute('gatomlo_project_manager_all_open_tasks');
        }
        elseif ($from == 'project'){
          return $this->redirectToRoute('gatomlo_project_manager_all_tasks_from_a_project',array('projectId'=>$project->getId()));
        }
        else{
          return $this->redirectToRoute('gatomlo_project_manager_homepage');
        }
      }
      else{
        return $this->redirectToRoute('gatomlo_project_manager_homepage');
      }
  }

  public function deleteAction($id,$from){
      $em = $this->getDoctrine()->getManager();
      $task = $em->getRepository('GatomloProjectManagerBundle:Task')->find($id);
      if($task->isOwner($this->getUser()) || $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN') ){
        $project = $em->getRepository('GatomloProjectManagerBundle:Project')->find($task->getProject())->getId();
        $em->remove($task);
        $em->flush();

        if($from == 'openTasks'){
          return $this->redirectToRoute('gatomlo_project_manager_all_open_tasks');
        }
        elseif ($from == 'project'){
          return $this->redirectToRoute('gatomlo_project_manager_all_tasks_from_a_project',array('projectId'=>$project));
        }
        elseif ($from =='closedTask'){
          return $this->redirectToRoute('gatomlo_project_manager_all_closed_tasks');
        }
        else{
          return $this->redirectToRoute('gatomlo_project_manager_homepage');
        }
      }
      else{
        return $this->redirectToRoute('gatomlo_project_manager_homepage');
      }
  }

  public function plannifiedAction(Request $request){
      $em = $this->getDoctrine()->getManager();
      $task = $em->getRepository('GatomloProjectManagerBundle:Task')->find($request->get('id'));
      if($task->isOwner($this->getUser()) || $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN') ){
        if($request->get('start')!= null){
          $task->setExecutiondate(new \DateTime($request->get('start')));
        }
        else{
          $task->setExecutiondate(null);
        }
        $em->persist($task);
        $em->flush();
        return new JsonResponse(array('success'=> 200));
      }
      else{
        return $this->redirectToRoute('gatomlo_project_manager_homepage');
      }
  }

  public function jsonPlanTaksListAction(){
      $em = $this->getDoctrine()->getManager();
      if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
        $tasks = $em->getRepository('GatomloProjectManagerBundle:Task')->findBy(
          array(),
          array('closed' => 'asc')
        );
       }
      else{
        $tasks = $em->getRepository('GatomloProjectManagerBundle:Task')->getAllTasksFromOwner($this->getUser());
      }
      $list_tasks = array();
      foreach ($tasks as $task){
        if ($task->getExecutiondate() != null){
          $obj['id'] = $task->getId();
          $obj['title'] = $task->getDescription();
          $obj['start'] = $task->getExecutiondate()->format("Y-m-d H:m:s");
          $obj['url'] = $this->get('router')->generate('gatomlo_project_manager_close_task', array('id' => $task->getId(),'from'=>'index'));
          $obj['closed'] = $task->getClosed();
          if($task->getEnddate() != null){
            if($task->getEnddate()->format('Y-m-d') > (new \DateTime("now"))->format('Y-m-d') ){
              $obj['color'] ="green";
            }
            elseif ($task->getEnddate()->format('Y-m-d') < (new \DateTime("now"))->format('Y-m-d') ) {
              $obj['color'] ="red";
            }
            elseif ($task->getEnddate()->format('Y-m-d') == (new \DateTime("now"))->format('Y-m-d') ) {
              $obj['color'] ="orange";
            }
          }
          else{
            $obj['color'] ="grey";
          }
          array_push($list_tasks,$obj);
        }
      }
      return new JsonResponse($list_tasks);
  }

  public function jsonDeadlineTaksListAction(){
      $em = $this->getDoctrine()->getManager();
      if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
        $tasks = $em->getRepository('GatomloProjectManagerBundle:Task')->findBy(
          array(),
          array('closed' => 'asc')
        );
       }
      else{
        $tasks = $em->getRepository('GatomloProjectManagerBundle:Task')->getAllTasksFromOwner($this->getUser());
      }

      $list_tasks = array();
      foreach ($tasks as $task){
        if($task->getEnddate() != null){
          $obj['id'] = $task->getId();
          $obj['title'] = $task->getDescription();
          $obj['start'] = $task->getEnddate()->format("Y-m-d H:m:s");
          $obj['url'] = $this->get('router')->generate('gatomlo_project_manager_close_task', array('id' => $task->getId(),'from'=>'index'));
          $obj['closed'] = $task->getClosed();
          if($task->getClosed() == 0){
            if($task->getEnddate()->format('Y-m-d') > (new \DateTime("now"))->format('Y-m-d') ){
              $obj['color'] ="green";
            }
            elseif ($task->getEnddate()->format('Y-m-d') < (new \DateTime("now"))->format('Y-m-d') ) {
              $obj['color'] ="red";
            }
            elseif ($task->getEnddate()->format('Y-m-d') == (new \DateTime("now"))->format('Y-m-d') ) {
              $obj['color'] ="orange";
            }
          }
          else{
            $obj['color'] ="grey";
          }
          array_push($list_tasks,$obj);
        }
      }
      return new JsonResponse($list_tasks);
  }

}
