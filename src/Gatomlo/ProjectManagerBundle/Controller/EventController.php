<?php

namespace Gatomlo\ProjectManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Gatomlo\ProjectManagerBundle\Entity\Project;
use Gatomlo\ProjectManagerBundle\Entity\Event;


class EventController extends Controller
{
    public function allAction()
    {
        return $this->render('@GatomloProjectManager/Event/all.html.twig');
    }
    public function allforAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $project = $em->getRepository('GatomloProjectManagerBundle:Project')->find($id);
        return $this->render('@GatomloProjectManager/Event/event.allfor.html.twig',array(
          'project'=>$project));
    }
    public function viewAction($id)
    {
        return $this->render('@GatomloProjectManager/Event/event.view.html.twig',array(
          'id'=>$id));
    }
    public function addAction()
    {
        $em = $this->getDoctrine()->getManager();
        $project = $em->getRepository('GatomloProjectManagerBundle:Project')->find(11);
        $type = $em->getRepository('GatomloProjectManagerBundle:Type')->find(2);

        $event1 = new Event();
        $event1->setTitle('Exemple suivant');
        $event1->setDescription('Lit, ultricies ultricies ante mollis et.
        Nulla sagittis augue quis dolor fermentum, quis mollis nunc ornare.
        Maecenas vel nunc mattis est finibus hendrerit. Aenean semper mattis metus,
        ac porttitor justo ultricies sit amet. Donec eli');
        $event1->setCreation(new \DateTime(date("Y-m-d H:i:s")));
        $event1->setStartdate(new \DateTime(date("Y-m-d H:i:s")));
        $event1->setType($type);

        $project->addEvent($event1);

        $em->persist($project);
        $em->flush();

        return $this->render('@GatomloProjectManager/Event/event.add.html.twig');
    }
    public function editAction($id)
    {
        return $this->render('@GatomloProjectManager/Event/edit.html.twig');
    }
    public function deleteAction($id)
    {
        return $this->render('@GatomloProjectManager/Event/delete.html.twig');
    }
}
