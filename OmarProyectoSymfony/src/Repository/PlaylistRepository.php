<?php

namespace App\Repository;

use App\Entity\Playlist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Playlist>
 */
class PlaylistRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Playlist::class);
    }

    //    /**
    //     * @return Playlist[] Returns an array of Playlist objects
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

    public function findByNombre($nombre): ?Playlist
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.nombre = :val')
            ->setParameter('val', $nombre)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }


    //MANAGER:: obtener likes
    public function obtenerLikesPorPlaylist(): array
    {
        return $this->createQueryBuilder('p')
            ->select('p.nombre AS playlist', 'SUM(p.likes) AS totalLikes')
            ->groupBy('p.id')
            ->orderBy('totalLikes', 'DESC')
            ->getQuery()
            ->getResult();
    }

    //MANAGER:: obtener reproducciones de playlist
    public function playlistMasReproducciones(): array
    {
        return $this->createQueryBuilder('p')
            ->select('p.id AS playlistId', 'p.reproducciones AS totalReproducciones')
            ->orderBy('totalReproducciones', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
