<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Consola
 *
 * @ORM\Table(name="Consola", indexes={@ORM\Index(name="ConsolaArticulo", columns={"idArticulo"})})
 * @ORM\Entity
 */
class Consola
{
    /**
     * @var int
     *
     * @ORM\Column(name="idConsola", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idconsola;

    /**
     * @var string|null
     *
     * @ORM\Column(name="modelo", type="string", length=255, nullable=true)
     */
    private $modelo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cant_mandos", type="string", length=30, nullable=true)
     */
    private $cantMandos;

    /**
     * @var string|null
     *
     * @ORM\Column(name="almacenamiento", type="string", length=255, nullable=true)
     */
    private $almacenamiento;

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
