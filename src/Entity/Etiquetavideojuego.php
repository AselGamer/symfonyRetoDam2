<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Etiquetavideojuego
 *
 * @ORM\Table(name="EtiquetaVideoJuego", indexes={@ORM\Index(name="EtiquetaVideoJuegoVideoJuego", columns={"idVideojuego"}), @ORM\Index(name="EtiquetaVideoJuegoEtiqueta", columns={"idEtiqueta"})})
 * @ORM\Entity(repositoryClass="App\Repository\EtiquetaVideojuegoRepository")
 */
class Etiquetavideojuego
{
    /**
     * @var int
     *
     * @ORM\Column(name="idEtiquetaVideoJuego", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idetiquetavideojuego;

    /**
     * @var Videojuego
     *
     * @ORM\ManyToOne(targetEntity="Videojuego")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idVideojuego", referencedColumnName="idVideojuego")
     * })
     */
    private $idvideojuego;

    /**
     * @var Etiqueta
     *
     * @ORM\ManyToOne(targetEntity="Etiqueta")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idEtiqueta", referencedColumnName="idEtiqueta")
     * })
     */
    private $idetiqueta;



    /**
     * Get the value of idetiquetavideojuego
     */
    public function getIdetiquetavideojuego(): int
    {
        return $this->idetiquetavideojuego;
    }

    /**
     * Set the value of idetiquetavideojuego
     */
    public function setIdetiquetavideojuego(int $idetiquetavideojuego): self
    {
        $this->idetiquetavideojuego = $idetiquetavideojuego;

        return $this;
    }

    /**
     * Get the value of idvideojuego
     */
    public function getIdvideojuego(): Videojuego
    {
        return $this->idvideojuego;
    }

    /**
     * Set the value of idvideojuego
     */
    public function setIdvideojuego(Videojuego $idvideojuego): self
    {
        $this->idvideojuego = $idvideojuego;

        return $this;
    }

    /**
     * Get the value of idetiqueta
     */
    public function getIdetiqueta(): Etiqueta
    {
        return $this->idetiqueta;
    }

    /**
     * Set the value of idetiqueta
     */
    public function setIdetiqueta(Etiqueta $idetiqueta): self
    {
        $this->idetiqueta = $idetiqueta;

        return $this;
    }
}
