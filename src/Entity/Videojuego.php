<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Articulo as Articulo;
use App\Entity\Plataforma as Plataforma;

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
     * @var Plataforma
     *
     * @ORM\ManyToOne(targetEntity="Plataforma")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idPlataforma", referencedColumnName="idPlataforma")
     * })
     */
    private $idplataforma;

    /**
     * @var Articulo
     *
     * @ORM\ManyToOne(targetEntity="Articulo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idArticulo", referencedColumnName="idArticulo")
     * })
     */
    private $idarticulo;



    /**
     * Get the value of idvideojuego
     */
    public function getIdvideojuego(): int
    {
        return $this->idvideojuego;
    }

    /**
     * Set the value of idvideojuego
     */
    public function setIdvideojuego(int $idvideojuego): self
    {
        $this->idvideojuego = $idvideojuego;

        return $this;
    }

    /**
     * Get the value of idplataforma
     */
    public function getIdplataforma(): Plataforma
    {
        return $this->idplataforma;
    }

    /**
     * Set the value of idplataforma
     */
    public function setIdplataforma(Plataforma $idplataforma): self
    {
        $this->idplataforma = $idplataforma;

        return $this;
    }

    /**
     * Get the value of idarticulo
     */
    public function getIdarticulo(): Articulo
    {
        return $this->idarticulo;
    }

    /**
     * Set the value of idarticulo
     */
    public function setIdarticulo(Articulo $idarticulo): self
    {
        $this->idarticulo = $idarticulo;

        return $this;
    }
}
