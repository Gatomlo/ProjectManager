<?php

namespace Gatomlo\ProjectManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Gatomlo\ProjectManagerBundle\Entity\People;
use Symfony\Component\HttpFoundation\Request;
use Gatomlo\ProjectManagerBundle\Entity\Tags;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Gatomlo\ProjectManagerBundle\Form\PeopleType;


class PeopleController extends Controller
{
  public function allAction()
  {
      $em = $this->getDoctrine()->getManager();
      $people = $em->getRepository('GatomloProjectManagerBundle:People')->findAll();
      return $this->render('@GatomloProjectManager/People/people.all.html.twig',array('peoples'=>$people));
  }
  public function viewAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $people = $em->getRepository('GatomloProjectManagerBundle:People')->find($id);

      if (null === $people) {
        throw new NotFoundHttpException("L'utilisateur d'id ".$id." n'existe pas.");
      }


      return $this->render('@GatomloProjectManager/People/people.view.html.twig',array(
        'people'=>$people));
  }
  public function addAction(Request $request)
  {

    $people = new People();
    $form = $this->get('form.factory')->create(PeopleType::class, $people);

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
           $people->addTag($newTag);
         }

         else {
           $people->addTag($existingTag);
         }
       }
       $em->persist($people);
       $em->flush();

       $request->getSession()->getFlashBag()->add('notice', 'Utilisateur bien enregistré.');

       // On redirige vers la page de visualisation de l'annonce nouvellement créée
       return $this->redirectToRoute('gatomlo_project_manager_one_people', array('id' => $people->getId()));
     }
   }

    // On passe la méthode createView() du formulaire à la vue
    // afin qu'elle puisse afficher le formulaire toute seule
    return $this->render('@GatomloProjectManager/People/people.add.html.twig', array(
      'form' => $form->createView(),
      'people' => $people
    ));
  }

  public function editAction(Request $request, $id)
  {
    // On crée un objet People
    $em = $this->getDoctrine()->getManager();
    $people = $em->getRepository('GatomloProjectManagerBundle:People')->find($id);
    //Récupération des tags
    $existingTags = $people->getTags();
    //Création d'un tableau vide
    $existingTagsArray = [];
    // Pour chaque tag, on récupére le nom et on l'insère dans le tableau vide.
    foreach ($existingTags as $tag) {
      $currentTag = $tag->getName();
      array_push($existingTagsArray, $currentTag);
    };
    // On transforme le tableau en string pour pouvoir être inséré dans le champ texte selectize
    $existingTagsStringFormat = implode(',',$existingTagsArray);

    $form = $this->get('form.factory')->create(PeopleType::class, $people, array(
      'existingTags'=>$existingTagsStringFormat));

    // Si la requête est en POST
   if ($request->isMethod('POST')) {
     // On fait le lien Requête <-> Formulaire
     // À partir de maintenant, la variable $advert contient les valeurs entrées dans le formulaire par le visiteur
     $form->handleRequest($request);

     // On vérifie que les valeurs entrées sont correctes
     // (Nous verrons la validation des objets en détail dans le prochain chapitre)
     if ($form->isValid()) {
       foreach ($existingTags as $tag) {
         $people->removeTag($tag);
       };
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
           $people->addTag($newTag);
         }

         else {
           $people->addTag($existingTag);
         }
       }
       $em->persist($people);
       $em->flush();

       $request->getSession()->getFlashBag()->add('notice', 'Utilisateur bien enregistré.');

       // On redirige vers la page de visualisation de l'annonce nouvellement créée
       return $this->redirectToRoute('gatomlo_project_manager_one_people', array('id' => $people->getId()));
     }
   }

    // On passe la méthode createView() du formulaire à la vue
    // afin qu'elle puisse afficher le formulaire toute seule
    return $this->render('@GatomloProjectManager/People/people.add.html.twig', array(
      'form' => $form->createView(),
      'people'=> $people
    ));
  }

  public function deleteAction($id)
  {
      $em = $this->getDoctrine()->getManager();
      $people = $em->getRepository('GatomloProjectManagerBundle:People')->find($id);
      $em->remove($people);
      $em->flush();

       return $this->redirectToRoute('gatomlo_project_manager_all_peoples');
  }

}
