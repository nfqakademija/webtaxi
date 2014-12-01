<?php
namespace Webtaxi\MainBundle\Model;
/**
 * Created by PhpStorm.
 * User: grt
 * Date: 14-12-01
 * Time: 20:25
 */
use Doctrine\ORM\EntityRepository;


class TravelRepository extends EntityRepository
{
    public function getTravelsAfterId($id, $queryLimit)
    {
        return $this->getEntityManager()
            ->createQuery('SELECT t FROM Webtaxi\MainBundle\Entity\Travel t WHERE t.id < ' . $id .  ' ORDER BY t.timeCall DESC')
            ->setMaxResults($queryLimit)
            ->getResult();

    }
}