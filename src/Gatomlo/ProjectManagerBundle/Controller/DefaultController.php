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

      $tags = new Tags();
      $tags->SetName('tag1');


      $project = new Project();
      $project->SetName('Lorem Ipsum v2');
      $project->SetDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit.
        Phasellus tristique porta sapien vel commodo. Proin odio lectus,
        tincidunt ut commodo sit amet, faucibus sit amet dolor.
        Nulla mattis turpis elit, ultricies ultricies ante mollis et.
        Nulla sagittis augue quis dolor fermentum, quis mollis nunc ornare.
        Maecenas vel nunc mattis est finibus hendrerit. Aenean semper mattis metus,
        ac porttitor justo ultricies sit amet. Donec elit nisl, bibendum a enim at,
        vestibulum vestibulum mi. Donec feugiat id neque at auctor.
        Nulla semper quis justo ac pulvinar. ');
      $project->setCreator('ThomasV');
      $project->setArchived(false);

      $project->addTag($tags);

      $status = new Status();
      $status->SetName('Dre12');
      $status->setType(0);
      $status->setProject($project);

      $project->addStatus($status);

      $event1 = new Event();
      $event1->setTitle('Contact téléphonique');
      $event1->setDescription('Lit, ultricies ultricies ante mollis et.
      Nulla sagittis augue quis dolor fermentum, quis mollis nunc ornare.
      Maecenas vel nunc mattis est finibus hendrerit. Aenean semper mattis metus,
      ac porttitor justo ultricies sit amet. Donec eli');
      $event1->setCreation(new \DateTime(date("Y-m-d H:i:s")));
      $event1->setStartdate(new \DateTime(date("Y-m-d H:i:s")));

      $event2 = new Event();
      $event2->setTitle('Email de Pierre');
      $event2->setDescription('Lit, ultricies ultricies ante mollis et.
      Nulla sagittis augue quis dolor fermentum, quis mollis nunc ornare.
      Maecenas vel nunc mattis est finibus hendrerit. Aenean semper mattis metus,
      ac porttitor justo ultricies sit amet. Donec eli');
      $event2->setCreation(new \DateTime(date("Y-m-d H:i:s")));
      $event2->setStartdate(new \DateTime(date("Y-m-d H:i:s")));

      $project->addEvent($event1);
      $project->addEvent($event2);


      $em = $this->getDoctrine()->getManager();
      $em->persist($tags);
      $em->persist($project);

      $em->flush();

        return $this->render('@GatomloProjectManager/Default/index.html.twig');
    }
}
