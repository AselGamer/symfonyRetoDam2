<?php

namespace App\Repository;

use App\Entity\VistaEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<VistaEntity>
 *
 * @method VistaEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method VistaEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method VistaEntity[]    findAll()
 * @method VistaEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VistaEntityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VistaEntity::class);
    }

    public function find3TypeStartingBy(string $type, int $offset)
    {
        $query = $this->getEntityManager()->createQuery("SELECT a
        FROM App\Entity\VistaEntity a
        WHERE a.tipoarticulo = :tipo")->setParameter('tipo', $type)->setMaxResults(3)->setFirstResult($offset);

        return $query->getResult();
    }

    public function findByType(string $type)
    {
        $query = $this->getEntityManager()->createQuery("SELECT a
        FROM App\Entity\VistaEntity a
        WHERE a.tipoarticulo = :tipo")->setParameter('tipo', $type);

        return $query->getResult();
    }

    public function searchArticulo(string $type, string $search)
    {
        $query = $this->getEntityManager()->createQuery("SELECT a
        FROM App\Entity\VistaEntity a
        WHERE a.tipoarticulo = :tipo AND a.articulonombre LIKE :search")->setParameter('tipo', $type)->setParameter('search', '%'.$search.'%');

        return $query->getResult();
    }

    public function searchArticuloNoType(string $search)
    {
        $query = $this->getEntityManager()->createQuery("SELECT a
        FROM App\Entity\VistaEntity a
        WHERE a.articulonombre LIKE :search")->setParameter('search', '%'.$search.'%');

        return $query->getResult();
    }

    public function searchArticuloPagina(string $search)
    {
        $query = $this->getEntityManager()->createQuery("SELECT a
        FROM App\Entity\VistaEntity a
        WHERE a.articulonombre LIKE :search
        OR a.tipoarticulo LIKE :search
        OR a.precio LIKE :search
        OR a.stock LIKE :search
         ")->setParameter('search', '%'.$search.'%');

        return $query->getResult();
    }

    public function countArticulos()
    {
        $query = $this->getEntityManager()->createQuery("SELECT COUNT(a) AS total
        FROM App\Entity\VistaEntity a");

        return $query->getResult()[0]['total'];
    }

    public function findAllOffsetWithMax(int $offset)
    {
        $query = $this->getEntityManager()->createQuery("SELECT a
        FROM App\Entity\VistaEntity a")->setMaxResults(10)->setFirstResult($offset * 10);

        return $query->getResult();
    }

    


    /*
    public function findConsolasWithPlataformas()
    {
        $query = $this->getEntityManager()->createQuery("SELECT a.idtipoClase, 
        a.articulonombre, 
        GROUP_CONCAT(p.idplataforma) AS idPlataformas, 
        GROUP_CONCAT(p.nombre) AS NombrePlataformas 
        FROM App\Entity\VistaEntity a
        INNER JOIN App\Entity\Plataformaconsola pc
        INNER JOIN App\Entity\Plataforma p
        WHERE a.tipoarticulo = 'Consola' 
        GROUP BY a.idtipoClase, a.articulonombre");

        return $query->getResult();
    }
*/
//    /**
//     * @return VistaEntity[] Returns an array of VistaEntity objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?VistaEntity
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
