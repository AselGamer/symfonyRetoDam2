<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Videojuego
 *
 * @ORM\Table(name="VideoJuego", indexes={@ORM\Index(name="VideoJuegoArticulo", columns={"idArticulo"}), @ORM\Index(name="VideoJuegoPlataforma", columns={"idPlataforma"})})
 * @ORM\Entity
 */
class Videojuego
{
    /**
     * @var int
     *
     * @ORM\Column(name="idVideojuego", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idvideojuego;

    /**
     * @var \Plataforma
     *
     * @ORM\ManyToOne(targetEntity="Plataforma")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idPlataforma", referencedColumnName="idPlataforma")
     * })
     */
    private $idplataforma;

    /**
     * @var \Articulo
     *
     * @ORM\ManyToOne(targetEntity="Articulo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idArticulo", referencedColumnName="idArticulo")
     * })
     */
    private $idarticulo;


}
