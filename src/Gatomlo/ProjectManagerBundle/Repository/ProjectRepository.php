<?php

namespace Gatomlo\ProjectManagerBundle\Repository;

/**
 * ProjectRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProjectRepository extends \Doctrine\ORM\EntityRepository
{
  public function getLastProjects($limit)
  {
    return $this->createQueryBuilder('e')
    ->setMaxResults($limit)
    ->getQuery()
    ->getResult();
  }
  public function getProjectsFromOwner($isArchived,$user)
  {
    $qb = $this->createQueryBuilder('e');
    $qb->join('e.owner','o')
       ->andWhere('o = :o')
       ->setParameter(':o',$user)
       ->andWhere('e.archived = :archived')
       ->setParameter(':archived',$isArchived);

       return $qb->getQuery()->getResult();
  }

}
