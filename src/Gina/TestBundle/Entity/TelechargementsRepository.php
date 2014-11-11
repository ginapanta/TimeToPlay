<?php

namespace Gina\TestBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * TelechargementsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TelechargementsRepository extends EntityRepository
{
    
      public function findByVisiteurs($user)
        {
          $qb= $this->createQueryBuilder('t')
                  ->select ('t')
                  ->where('t.visiteurs= :user')
//                  ->andWhere(' t.dateTelechargement between ADDDATE(NOW(), INTERVAL -7 DAY') 
                  ->setParameter('user', $user);
                  
          
          return $qb->getQuery()->getResult();
           
         }
         
     
}
