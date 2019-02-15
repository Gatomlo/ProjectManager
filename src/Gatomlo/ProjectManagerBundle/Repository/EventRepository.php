<?php

namespace Gatomlo\ProjectManagerBundle\Repository;

/**
 * EventRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EventRepository extends \Doctrine\ORM\EntityRepository
{
  public function getLastEvents($limit)
  {
    return $this->createQueryBuilder('e')
    ->setMaxResults($limit)
    ->getQuery()
    ->getResult();
  }

  public function getReport($startDate,$endDate,$people,$project,$tag,$type)
  {
    return $this->createQueryBuilder('e')
    
    ->where('e.project = :project')
    ->setParameter(':project',$project)
    ->andWhere('e.startDate BETWEEN :start AND :end')
    ->setParameter('start', new \Datetime(date('Y').'-01-01'))  // Date entre le 1er janvier de cette année
    ->setParameter('end',   new \Datetime(date('Y').'-12-31'))  // Et le 31 décembre de cette année


    ->getQuery()
    ->getResult();
  }

}
