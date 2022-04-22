<?php

namespace App\Repository;

use App\Entity\Vehicle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Vehicle>
 *
 * @method Vehicle|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vehicle|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vehicle[]    findAll()
 * @method Vehicle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VehicleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vehicle::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Vehicle $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Vehicle $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @param mixed[] $params
     */
    public function getList(array $params): QueryBuilder
    {
        $search = $params['search'] ?? '';
        $order = $params['order'] ?? 'id';
        $direction = $params['direction'] ?? 'ASC';
        $limit = $params['limit'] ?? 10;
        $offset = $params['offset'] ?? 0;

        return $this->createQueryBuilder('v')
            ->orWhere('v.year LIKE :val')
            ->setParameter('val', "%{$search}%")
            ->orWhere('v.make LIKE :val')
            ->setParameter('val', "%{$search}%")
            ->orWhere('v.model LIKE :val')
            ->setParameter('val', "%{$search}%")
            ->andWhere('v.deleted = 0')
            ->orderBy("v.{$order}", $direction)
            ->setFirstResult($offset)
            ->setMaxResults($limit)
        ;
    }

    /*
    public function findOneBySomeField($value): ?Vehicle
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
