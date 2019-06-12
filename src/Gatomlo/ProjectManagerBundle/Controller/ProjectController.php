<?php

namespace Gatomlo\ProjectManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Gatomlo\ProjectManagerBundle\Entity\Project;
use Gatomlo\ProjectManagerBundle\Entity\Tags;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Gatomlo\ProjectManagerBundle\Form\ProjectType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;



class ProjectController extends Controller
{
  public function allAction($archived)
  {
    $em = $this->getDoctrine()->getManager();
    if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
      $projects = $em->getRepository('GatomloProjectManagerBundle:Project')->findBy(array(
        'archived'=> $archived
      ));
     }
    else{
      $projects = $em->getRepository('GatomloProjectManagerBundle:Project')->getProjectsFromOwner($archived,$this->getUser());
    }
      return $this->render('@GatomloProjectManager/Project/project.all.html.twig',array('projects'=>$projects, 'archived'=>$archived));
  }

  public function viewAction($id)
  {

    $em = $this->getDoctrine()->getManager();
    $project = $em->getRepository('GatomloProjectManagerBundle:Project')->find($id);
    if($project->isOwner($this->getUser()) || $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN') ){
      return $this->render('@GatomloProjectManager/Project/project.view.html.twig',array(
        'project'=>$project));
    }
    else{
      return $this->redirectToRoute('gatomlo_project_manager_homepage');
    }
  }

  public function jsonProjectsListAction()
  {
      $em = $this->getDoctrine()->getManager();
      if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
        $projects = $em->getRepository('GatomloProjectManagerBundle:Project')->findBy(
          array('archived'=>false)
        );
       }
      else{
        $projects = $em->getRepository('GatomloProjectManagerBundle:Project')->getProjectsFromOwner(false,$this->getUser());
      }

      $list_Projects = array();
      foreach ($projects as $project){
          $obj['id'] = $project->getId();
          $obj['text'] = $project->getName();
          array_push($list_Projects,$obj);
      }
      return new JsonResponse($list_Projects);
  }

  public function addAction(Request $request)
  {
    // On crée un objet Project
    $project = new Project();
    $form = $this->get('form.factory')->create(ProjectType::class, $project);
    // Si la requête est en POST
   if ($request->isMethod('POST')) {
     // On fait le lien Requête <-> Formulaire
     // À partir de maintenant, la variable $advert contient les valeurs entrées dans le formulaire par le visiteur
     $form->handleRequest($request);
     // On vérifie que les valeurs entrées sont correctes
     // (Nous verrons la validation des objets en détail dans le prochain chapitre)
     if ($form->isValid()) {
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
           $newTag->setType(3);
           $project->addTag($newTag);
         }
         else {
           $project->addTag($existingTag);
         }
       }
       $project->addOwner($this->getUser());
       $em->persist($project);
       $em->flush();
       $request->getSession()->getFlashBag()->add('notice', 'Projet bien enregistrée.');
       // On redirige vers la page de visualisation de l'annonce nouvellement créée
       return $this->redirectToRoute('gatomlo_project_manager_one_project', array('id' => $project->getId()));
     }
   }


    // On passe la méthode createView() du formulaire à la vue
    // afin qu'elle puisse afficher le formulaire toute seule
    return $this->render('@GatomloProjectManager/Project/project.add.html.twig', array(
      'form' => $form->createView(),
      'project'=>$project
    ));
  }

  public function editAction(Request $request, $id)
  {
    $em = $this->getDoctrine()->getManager();
    $project = $em->getRepository('GatomloProjectManagerBundle:Project')->find($id);
    if($project->isOwner($this->getUser()) || $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN') ){
      //Récupération des tags
      $existingTags = $project->getTags();
      //Création d'un tableau vide
      $existingTagsArray = [];
      // Pour chaque tag, on récupére le nom et on l'insère dans le tableau vide.
      foreach ($existingTags as $tag) {
        $currentTag = $tag->getName();
        array_push($existingTagsArray, $currentTag);
      };
      // On transforme le tableau en string pour pouvoir être inséré dans le champ texte selectize
      $existingTagsStringFormat = implode(',',$existingTagsArray);
      $form = $this->get('form.factory')->create(ProjectType::class, $project, array('existingTags'=>$existingTagsStringFormat));
      // Si la requête est en POST
     if ($request->isMethod('POST')) {
       // On fait le lien Requête <-> Formulaire
       // À partir de maintenant, la variable $advert contient les valeurs entrées dans le formulaire par le visiteur
       $form->handleRequest($request);
       // On vérifie que les valeurs entrées sont correctes
       // (Nous verrons la validation des objets en détail dans le prochain chapitre)
       if ($form->isValid()) {
         foreach ($existingTags as $tag) {
           $project->removeTag($tag);
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
              $newTag->setType(3);
              $project->addTag($newTag);
            }
            else {
              $project->addTag($existingTag);
            }
          }
         $em->persist($project);
         $em->flush();
         $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
         // On redirige vers la page de visualisation de l'annonce nouvellement créée
         return $this->redirectToRoute('gatomlo_project_manager_one_project', array('id' => $project->getId()));
       }
     }
      // On passe la méthode createView() du formulaire à la vue
      // afin qu'elle puisse afficher le formulaire toute seule
      return $this->render('@GatomloProjectManager/Project/project.add.html.twig', array(
        'form' => $form->createView(),
        'project'=>$project,
        'tags'=>$existingTagsArray,
      ));
    }
    else{
      return $this->redirectToRoute('gatomlo_project_manager_homepage');
    }
  }

  public function deleteAction($id)
  {
      $em = $this->getDoctrine()->getManager();
      $project = $em->getRepository('GatomloProjectManagerBundle:Project')->find($id);
      if($project->isOwner($this->getUser()) || $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN') ){
        if($project->getParent() != null){
          $parent = $em->getRepository('GatomloProjectManagerBundle:Project')->find($project->getParent());
          $project->setParents(null);
        }
        $em->remove($project);
        $em->flush();

         return $this->redirectToRoute('gatomlo_project_manager_all_projects');
       }
       else{
         return $this->redirectToRoute('gatomlo_project_manager_homepage');
       }
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
  public function removeParentAction($idChild,$idParent)
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

  public function archivedAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $project = $em->getRepository('GatomloProjectManagerBundle:Project')->find($id);
    if($project->isOwner($this->getUser()) || $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN') ){
      if ($project->getArchived()== FALSE){
        $project->SetArchived(TRUE);
      }
      else{
        $project->SetArchived(FALSE);
      }

      $em->persist($project);
      $em->flush();
      if ($project->getArchived()== TRUE){
        return $this->redirectToRoute('gatomlo_project_manager_all_projects');
      }
      else{
        return $this->redirectToRoute('gatomlo_project_manager_all_projects',array('archived'=>1));
      }
    }
    else{
      return $this->redirectToRoute('gatomlo_project_manager_homepage');
    }
  }
  public function jsonDeadlineProjectsListAction()
  {
      $em = $this->getDoctrine()->getManager();
      if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
        $projects = $em->getRepository('GatomloProjectManagerBundle:Project')->findAll();
       }
      else{
        $projects = $em->getRepository('GatomloProjectManagerBundle:Project')->getProjectsFromOwner(false,$this->getUser());
      }
      $list_projects = array();
      foreach ($projects as $project){
          if ($project->getEndtime() != null){
            $obj['title'] = $project->getName();
            $obj['start'] = $project->getEndtime()->format("Y-m-d H:m:s");
            $obj['url'] = $this->get('router')->generate('gatomlo_project_manager_one_project', array('id' => $project->getId()));
            $obj['description'] = false;
            array_push($list_projects,$obj);
          }

      }
      return new JsonResponse($list_projects);
  }
}
