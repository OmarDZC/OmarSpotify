<?php

namespace App\Repository;

use App\Entity\Perfil;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Perfil>
 */
class PerfilRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Perfil::class);
    }

    //    /**
    //     * @return Perfil[] Returns an array of Perfil objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

       public function findByNombre($nombre): ?Perfil
       {
           return $this->createQueryBuilder('p')
               ->andWhere('p.nombre = :val')
               ->setParameter('val', $nombre)
               ->getQuery()
               ->getOneOrNullResult()
           ;
       }
}
