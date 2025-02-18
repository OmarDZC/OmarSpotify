<?php

namespace App\Repository;

use App\Entity\Cancion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cancion>
 */
class CancionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cancion::class);
    }

    //    /**
    //     * @return Cancion[] Returns an array of Cancion objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    public function findByNombre($titulo): ?Cancion
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.titulo = :val')
            ->setParameter('val', $titulo)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    //MANAGER:: canciones mas escuchadas
    public function topCancionesMasReproducidas(): array
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.reproducciones', 'DESC')
            ->getQuery()
            ->getResult();
    }

    //MANAGER:: reproducciones por genero
    public function reproduccionesPorGenero()
    {
        return $this->createQueryBuilder('c')
            ->select('g.nombre AS genero, SUM(c.reproducciones) AS totalReproducciones')
            ->innerJoin('c.genero', 'g')
            ->groupBy('g.nombre')
            ->getQuery()
            ->getResult();
    }
}
