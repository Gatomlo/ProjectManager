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
  public function getLastProjects($limit,$user)
  {
    return $this->createQueryBuilder('e')
    ->join('e.owner','o')
    ->andWhere('o = :o')
    ->setParameter(':o',$user)
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
  public function getOwnerProjectsForList($user)
  {
    $qb = $this->createQueryBuilder('e');
    $roles = $user->getRoles();
    if(in_array("ROLE_ADMIN", $roles)){
      }
    else{
      $qb->join('e.owner','o')
         ->andWhere('o = :o')
         ->setParameter(':o',$user);
      }
     return $qb;
  }
}
