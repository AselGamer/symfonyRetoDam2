<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Marca
 *
 * @ORM\Table(name="Marca")
 * @ORM\Entity
 */
class Marca
{
    /**
     * @var int
     *
     * @ORM\Column(name="idMarca", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idmarca;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=50, nullable=false)
     */
    private $nombre;


}
