<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Dispositivomovil
 *
 * @ORM\Table(name="DispositivoMovil", indexes={@ORM\Index(name="DispositivoMovilArticulo", columns={"idArticulo"})})
 * @ORM\Entity
 */
class Dispositivomovil
{
    /**
     * @var int
     *
     * @ORM\Column(name="idDispositivoMovil", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $iddispositivomovil;

    /**
     * @var string|null
     *
     * @ORM\Column(name="almacenamiento", type="string", length=255, nullable=true)
     */
    private $almacenamiento;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ram", type="string", length=30, nullable=true)
     */
    private $ram;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tamano_pantalla", type="string", length=30, nullable=true)
     */
    private $tamanoPantalla;

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
