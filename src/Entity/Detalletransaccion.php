<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Detalletransaccion
 *
 * @ORM\Table(name="DetalleTransaccion", indexes={@ORM\Index(name="DetalleTransaccion", columns={"idTransaccion"}), @ORM\Index(name="DetalleArticulo", columns={"idArticulo"})})
 * @ORM\Entity
 */
class Detalletransaccion
{
    /**
     * @var int
     *
     * @ORM\Column(name="idDetalleTransaccion", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $iddetalletransaccion;

    /**
     * @var float
     *
     * @ORM\Column(name="precio_total", type="float", precision=10, scale=0, nullable=false)
     */
    private $precioTotal;

    /**
     * @var \Transaccion
     *
     * @ORM\ManyToOne(targetEntity="Transaccion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idTransaccion", referencedColumnName="idTransaccion")
     * })
     */
    private $idtransaccion;

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
