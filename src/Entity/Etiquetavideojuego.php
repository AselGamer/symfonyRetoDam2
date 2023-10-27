<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Etiquetavideojuego
 *
 * @ORM\Table(name="EtiquetaVideoJuego", indexes={@ORM\Index(name="EtiquetaVideoJuegoVideoJuego", columns={"idVideojuego"}), @ORM\Index(name="EtiquetaVideoJuegoEtiqueta", columns={"idEtiqueta"})})
 * @ORM\Entity
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
     * @var \Videojuego
     *
     * @ORM\ManyToOne(targetEntity="Videojuego")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idVideojuego", referencedColumnName="idVideojuego")
     * })
     */
    private $idvideojuego;

    /**
     * @var \Etiqueta
     *
     * @ORM\ManyToOne(targetEntity="Etiqueta")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idEtiqueta", referencedColumnName="idEtiqueta")
     * })
     */
    private $idetiqueta;


}
