<?php
namespace App\Repository;

use App\Entity\Articulo;
use App\Entity\VistaTransaccion;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class VistaTransaccionRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VistaTransaccion::class);
    }

    public function findAllOffsetWithMax(int $offset)
    {
        $query = $this->getEntityManager()->createQuery("SELECT a
        FROM App\Entity\VistaTransaccion a")->setMaxResults(10)->setFirstResult($offset * 10);

        return $query->getResult();
    }

    public function countTransacciones()
    {
        $query = $this->getEntityManager()->createQuery("SELECT COUNT(a) AS total
        FROM App\Entity\VistaTransaccion a");

        return $query->getResult()[0]['total'];
    }

    public function searchTransaccionPagina(string $search)
    {
        $query = $this->getEntityManager()->createQuery("SELECT a
        FROM App\Entity\VistaTransaccion a
        INNER JOIN App\Entity\Usuario b
        WHERE a.tipotransaccion LIKE :search
        OR a.latitud LIKE :search
        OR a.longitud LIKE :search
        OR b.nombre LIKE :search")
        ->setParameter('search', '%'.$search.'%');

        return $query->getResult();
    }

}