<?php

namespace Gatomlo\ProjectManagerBundle\Repository;

/**
 * DocumentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DocumentRepository extends \Doctrine\ORM\EntityRepository
{
  public function getDocumentsFromOwner($user)
  {
    $qb = $this->createQueryBuilder('e');
    $qb->join('e.project','p')
       ->join('p.owner', 'o')
       ->andWhere('o = :o')
       ->setParameter(':o',$user);

       return $qb->getQuery()->getResult();
  }
}
