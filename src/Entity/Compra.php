<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Compra
 *
 * @ORM\Table(name="Compra", indexes={@ORM\Index(name="TransaccionCompra", columns={"idTransaccion"})})
 * @ORM\Entity
 */
class Compra
{
    /**
     * @var int
     *
     * @ORM\Column(name="idCompra", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcompra;

    /**
     * @var DateTime|null
     *
     * @ORM\Column(name="fecha", type="date", nullable=true)
     */
    private $fecha;

    /**
     * @var Transaccion
     *
     * @ORM\ManyToOne(targetEntity="Transaccion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idTransaccion", referencedColumnName="idTransaccion")
     * })
     */
    private $idtransaccion;



    /**
     * Get the value of idcompra
     */
    public function getIdcompra(): int
    {
        return $this->idcompra;
    }

    /**
     * Set the value of idcompra
     */
    public function setIdcompra(int $idcompra)
    {
        $this->idcompra = $idcompra;
    }

    /**
     * Get the value of fecha
     */
    public function getFecha(): DateTime
    {
        return $this->fecha;
    }

    /**
     * Set the value of fecha
     */
    public function setFecha(DateTime $fecha)
    {
        $this->fecha = $fecha;
    }

    /**
     * Get the value of idtransaccion
     */
    public function getIdtransaccion(): Transaccion
    {
        return $this->idtransaccion;
    }

    /**
     * Set the value of idtransaccion
     */
    public function setIdtransaccion(Transaccion $idtransaccion)
    {
        $this->idtransaccion = $idtransaccion;
    }
}
