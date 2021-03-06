<?php

namespace Gatomlo\ProjectManagerBundle\Controller;

use Gatomlo\ProjectManagerBundle\Entity\Project;
use Gatomlo\ProjectManagerBundle\Entity\Status;
use Gatomlo\ProjectManagerBundle\Entity\Tags;
use Gatomlo\ProjectManagerBundle\Entity\Event;
use Gatomlo\ProjectManagerBundle\Entity\Type;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;



class DefaultController extends Controller
{
    public function indexAction()
    {

      $em = $this->getDoctrine()->getManager();
      // $user = $em->getRepository('GatomloUserBundle:User')->findOneBy(array('username'=>'admin'));
      // $user->addRole('ROLE_ADMIN');
      // $em->persist($user);
      // $em->flush();
      $lastProjects = $em->getRepository('GatomloProjectManagerBundle:Project')->getLastProjects(10,$this->getUser());
      $lastEvents = $em->getRepository('GatomloProjectManagerBundle:Event')->getLastEvents(10,$this->getUser());

        return $this->render('@GatomloProjectManager/Default/index.html.twig',array('projects'=> $lastProjects,'events'=>$lastEvents));
    }
}
