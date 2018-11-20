<?php
// src/OC/PlatformBundle/DataFixtures/ORM/LoadCategory.php

namespace Gatomlo\ProjectManagerBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Gatomlo\ProjectManagerBundle\Entity\Status;

class LoadStatus implements FixtureInterface
{
  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager)
  {
    // Liste des noms de catégorie à ajouter
    $liststatus = array(
      array('DREL','En attente de relecture par un vacataire',0,1),
      array('DVAL','En attente de validation par un chargé de développement',0,3),
      array('Terminé','Tout est ok',02,4),
      array('En cours','En cours de développement',0,2),
      array('Nouveau','En attente de vacataire',0,1),

    );

    foreach ($liststatus as $status) {
      // On crée la catégorie
      $newstatus = new Status();
      $newstatus->setName($status[0]);
      $newstatus->setDescription($status[1]);
      $newstatus->setType($status[2]);


      // On la persiste
      $manager->persist($newstatus);
    }

    // On déclenche l'enregistrement de toutes les catégories
    $manager->flush();
  }
}
