<?php
namespace App\Repository;

use App\Entity\Marca;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class MarcaRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Marca::class);
    }

    public function findMarcaOfArticuloType(string $type)
    {
        $queryBuilder = $this->createQueryBuilder('m');
        
        $queryBuilder
        ->select('m')
        ->innerJoin('App\Entity\VistaEntity', 'v', 'v.idmarca = m.idmarca')
        ->where('v.idmarca = m.idmarca')
        ->andWhere('v.tipoarticulo = :type')
        ->setParameter('type', $type);

        return $queryBuilder->getQuery()->getResult();
    }

    public function countMarcas()
    {
        $query = $this->getEntityManager()->createQuery("SELECT COUNT(m) AS total
        FROM App\Entity\Marca m");

        return $query->getResult()[0]['total'];
    }

    public function findAllOffsetWithMax(int $offset)
    {
        $query = $this->getEntityManager()->createQuery("SELECT m
        FROM App\Entity\Marca m")->setMaxResults(10)->setFirstResult($offset * 10);

        return $query->getResult();
    }


    

}