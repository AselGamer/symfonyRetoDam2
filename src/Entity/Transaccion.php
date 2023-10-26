<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Transaccion
 *
 * @ORM\Table(name="Transaccion", indexes={@ORM\Index(name="idUsuario", columns={"idUsuario"})})
 * @ORM\Entity
 */
class Transaccion
{
    /**
     * @var int
     *
     * @ORM\Column(name="idTransaccion", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idtransaccion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="latitud", type="string", length=30, nullable=true)
     */
    private $latitud;

    /**
     * @var string|null
     *
     * @ORM\Column(name="longitud", type="string", length=30, nullable=true)
     */
    private $longitud;

    /**
     * @var \Usuario
     *
     * @ORM\ManyToOne(targetEntity="Usuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idUsuario", referencedColumnName="idUsuario")
     * })
     */
    private $idusuario;


}
