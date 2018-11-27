<?php

namespace Gatomlo\ProjectManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Gatomlo\ProjectManagerBundle\Entity\People;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;


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
    // On crée un objet People
    $people = new People();

    // On crée le FormBuilder grâce au service form factory
    $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $people);

    // On ajoute les champs de l'entité que l'on veut à notre formulaire
    $formBuilder
      ->add('firstName',      TextType::class)
      ->add('lastName', TextType::class)
      ->add('save',      SubmitType::class)
    ;

    // À partir du formBuilder, on génère le formulaire
    $form = $formBuilder->getForm();

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
    ));
  }

  public function editAction(Request $request, $id)
  {
    // On crée un objet People
    $em = $this->getDoctrine()->getManager();
    $people = $em->getRepository('GatomloProjectManagerBundle:People')->find($id);

    // On crée le FormBuilder grâce au service form factory
    $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $people);

    // On ajoute les champs de l'entité que l'on veut à notre formulaire
    $formBuilder
      ->add('firtName',      TextType::class)
      ->add('lastName',      TextType::class)
      ->add('save',      SubmitType::class)
    ;

    // À partir du formBuilder, on génère le formulaire
    $form = $formBuilder->getForm();

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
