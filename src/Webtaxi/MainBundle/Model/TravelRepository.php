<?php
namespace Webtaxi\MainBundle\Model;
/**
 * Created by PhpStorm.
 * User: grt
 * Date: 14-12-01
 * Time: 20:25
 */
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Translation\Tests\String;


class TravelRepository extends EntityRepository
{
    /**
     * @param $id
     * @param $queryLimit
     * @return array all travels followed by id
     */
    public function getTravelsAfterId($id, $queryLimit)
    {

        return $this->getEntityManager()
            ->createQuery('SELECT t FROM Webtaxi\MainBundle\Entity\Travel t WHERE t.id < :id '  .  ' ORDER BY t.timeCall DESC')
            ->setParameter("id", $id)
            ->setMaxResults($queryLimit)
            ->getResult();

    }

    /**
     * @param $id
     * @param $queryLimit
     * @return array travels with no drivers followed by id
     */
    public function getNotAcceptedTravelsAfterId($id, $queryLimit)
    {
        return $this->getEntityManager()
            ->createQuery('SELECT t FROM Webtaxi\MainBundle\Entity\Travel t
            WHERE t.id < :id'  .
                ' AND t.driver is null' .
                ' ORDER BY t.timeCall DESC')
            ->setParameter("id", $id)
            ->setMaxResults($queryLimit)
            ->getResult();
    }

    /**
     * @param $user
     * @param $id
     * @param $queryLimit
     * @return array travels followed by $id related with $user
     */
    public function getMyTravels($user, $id, $queryLimit)
    {
        return $this->getEntityManager()
            ->createQuery('SELECT t FROM Webtaxi\MainBundle\Entity\Travel t
            WHERE t.id < :id' .
                ' AND ( t.client = :clientId' .
                ' OR t.driver = :driverId' . ' ) ' .
                ' ORDER BY t.timeCall DESC')
            ->setParameter("id", $id)
            ->setParameter("clientId", $user->getId())
            ->setParameter("driverId", $user->getId())
            ->setMaxResults($queryLimit)
            ->getResult();
    }

}