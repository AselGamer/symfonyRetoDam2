<?php
namespace App\Repository;

use App\Entity\Articulo;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class ArticuloRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Articulo::class);
    }

    public function findVideoJuegoByTag(string $tag)
    {
        $queryBuilder = $this->createQueryBuilder('a');
        $queryBuilder
        ->select('a')
        ->innerJoin('App\Entity\Videojuego', 'v', 'v.idarticulo = a.idarticulo')
        ->innerJoin('App\Entity\Etiquetavideojuego', 'e', 'v.idvideojuego = e.idvideojuego')
        ->innerJoin('App\Entity\Etiqueta', 'et', 'e.idetiqueta = et.idetiqueta')
        ->where('v.idarticulo = a.idarticulo')
        ->andWhere('e.idvideojuego = v.idvideojuego')
        ->andWhere('e.idetiqueta = et.idetiqueta')
        ->andWhere('et.nombre = :tag')
        ->setParameter('tag', $tag);

        //dd($queryBuilder->getQuery());

        return $queryBuilder->getQuery()->getResult();
    }

}