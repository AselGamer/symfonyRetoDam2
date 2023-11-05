<?php
namespace App\Repository;

use App\Entity\Consola;
use App\Entity\Plataformaconsola;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class PlataformaConsolaRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Plataformaconsola::class);
    }

    public function removeByConsola(int $idConsola)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('DELETE FROM App\Entity\Plataformaconsola p WHERE p.idconsola = :idConsola');
        $query->setParameter('idConsola', $idConsola);
        $query->execute();
    }

}