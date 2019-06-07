<?php

namespace Gatomlo\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Gatomlo\UserBundle\Form\UserType;
use Gatomlo\UserBundle\Form\EditUserType;
use Gatomlo\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends Controller
{
  public function allAction()
  {
    $em = $this->getDoctrine()->getManager();
    $users = $em->getRepository('GatomloUserBundle:User')->findAll();
    return $this->render('@GatomloUser/User/user.all.html.twig',array('users'=>$users));
  }

  public function addAction(Request $request)
  {
    $user = new User();
    $encoder = $this->get('security.encoder_factory')->getEncoder($user);
    $form = $this->get('form.factory')->create(UserType::class, $user);
    // Si la requête est en POST
     if ($request->isMethod('POST')) {
       $form->handleRequest($request);
       if ($form->isValid()) {
         $em = $this->getDoctrine()->getManager();
         $password = $form['password']->getData();
         $user->setPlainPassword($password);
         $user->setEnabled(false);
         $adminUser = $form['admin']->getData();
         if($adminUser){
           $user->addRole("ROLE_ADMIN");
         }
         $em->persist($user);
         $em->flush();
         $request->getSession()->getFlashBag()->add('notice', 'Utilisateur bien enregistré.');
         return $this->redirectToRoute('gatomlo_user_admin_all_users');
       }
     }

      // On passe la méthode createView() du formulaire à la vue
      // afin qu'elle puisse afficher le formulaire toute seule
      return $this->render('@GatomloUser/User/user.add.html.twig', array(
        'form' => $form->createView(),
        'user' => $user
      ));
  }
  public function editAction(Request $request,$id)
  {
    $em = $this->getDoctrine()->getManager();
    $isAdmin = false;
    $user = $em->getRepository('GatomloUserBundle:User')->find($id);
    $oldPassword = $user->getPassword();
    $roles = $user->getRoles();
    foreach( $user->getRoles() as $role){
           if($role == 'ROLE_ADMIN'){
             $isAdmin = True;
           }
       }
    $form = $this->get('form.factory')->create(EditUserType::class, $user,array('isAdmin'=>$isAdmin));
    if ($request->isMethod('POST')) {
      $form->handleRequest($request);
      if ($form->isValid()) {
        $password = $form['password']->getData();
        $isNowAdmin = $form['admin']->getData();
        if($password==''){
          $user->setPassword($oldPassword);
        }
        else{
          $user->setPlainPassword($password);
        }
        if($isAdmin){
          if(!$isNowAdmin){
            if($user->getId() != 1){
            $user->removeRole('ROLE_ADMIN');
          }}
        }
        else{
          if($isNowAdmin){
            $user->addRole("ROLE_ADMIN");
        }}
        $enabled = $form['enabled']->getData();
        $user->setEnabled($enabled);
        $em->persist($user);
        $em->flush();
        return $this->redirectToRoute('gatomlo_user_admin_all_users', array('id' => $user->getId()));
     }}
    return $this->render('@GatomloUser/User/user.add.html.twig', array(
      'form' => $form->createView(),
      'user' => $user
      ));
  }
  public function deleteAction($id)
  {
    if($id != 1){
      $em = $this->getDoctrine()->getManager();
      $user = $em->getRepository('GatomloUserBundle:User')->find($id);
      $em->remove($user);
      $em->flush();
      return $this->redirectToRoute('gatomlo_user_admin_all_users');
    }
    return $this->redirectToRoute('gatomlo_user_admin_all_users');
  }
}
