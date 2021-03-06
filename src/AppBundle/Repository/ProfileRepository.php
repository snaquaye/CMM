<?php

namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;

/**
 * ProfileRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProfileRepository extends EntityRepository
{
  /**
   * @return array
   */
  public function findAll()
  {
    $qb = $this->createQueryBuilder('p');

    $query = $qb->select('u.firstName')
      ->addSelect('u.lastName')
      ->addSelect('u.otherNames')
      ->addSelect('p.id')
      ->addSelect('p.annualIncome')
      ->addSelect('p.creditRating')
      ->addSelect('p.isQualified')
      ->addSelect('p.netWorth')
      ->addSelect('p.phone')
      ->innerJoin('p.user', 'u')
      ->getQuery();

    return $query->getArrayResult();
  }
}
