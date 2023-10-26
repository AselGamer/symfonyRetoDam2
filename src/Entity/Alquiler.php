<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Alquiler
 *
 * @ORM\Table(name="Alquiler", indexes={@ORM\Index(name="TransaccionAlquiler", columns={"idTransaccion"})})
 * @ORM\Entity
 */
class Alquiler
{
    /**
     * @var int
     *
     * @ORM\Column(name="idAlquiler", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idalquiler;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_inicio", type="date", nullable=false)
     */
    private $fechaInicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_fin", type="date", nullable=false)
     */
    private $fechaFin;

    /**
     * @var float|null
     *
     * @ORM\Column(name="fecha_devolucion", type="float", precision=10, scale=0, nullable=true)
     */
    private $fechaDevolucion;

    /**
     * @var float
     *
     * @ORM\Column(name="precio", type="float", precision=10, scale=0, nullable=false)
     */
    private $precio;

    /**
     * @var \Transaccion
     *
     * @ORM\ManyToOne(targetEntity="Transaccion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idTransaccion", referencedColumnName="idTransaccion")
     * })
     */
    private $idtransaccion;


}
