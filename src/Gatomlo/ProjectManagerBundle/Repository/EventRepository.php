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
  
}
