<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Plataforma
 *
 * @ORM\Table(name="Plataforma")
 * @ORM\Entity
 */
class Plataforma
{
    /**
     * @var int
     *
     * @ORM\Column(name="idPlataforma", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idplataforma;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255, nullable=false)
     */
    private $nombre;


}
