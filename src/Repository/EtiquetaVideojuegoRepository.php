<?php
namespace App\Repository;

use App\Entity\Etiquetavideojuego;
use App\Entity\Plataformaconsola;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class EtiquetaVideojuegoRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Etiquetavideojuego::class);
    }

    public function removeByVideojuego(int $idVideojuego)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('DELETE FROM App\Entity\Etiquetavideojuego p WHERE p.idvideojuego = :idVideojuego');
        $query->setParameter('idVideojuego', $idVideojuego);
        $query->execute();
    }

}