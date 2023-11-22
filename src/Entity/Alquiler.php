<?php

namespace App\Entity;

use DateTime;
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
     * @var DateTime
     *
     * @ORM\Column(name="fecha_inicio", type="date", nullable=false)
     */
    private $fechaInicio;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="fecha_fin", type="date", nullable=false)
     */
    private $fechaFin;

    /**
     * @var DateTime|null
     *
     * @ORM\Column(name="fecha_devolucion", type="date", precision=10, scale=0, nullable=true)
     */
    private $fechaDevolucion;

    /**
     * @var float
     *
     * @ORM\Column(name="precio", type="float", precision=10, scale=0, nullable=false)
     */
    private $precio;

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
     * Get the value of idalquiler
     */
    public function getIdalquiler(): int
    {
        return $this->idalquiler;
    }

    /**
     * Set the value of idalquiler
     */
    public function setIdalquiler(int $idalquiler)
    {
        $this->idalquiler = $idalquiler;
    }

    /**
     * Get the value of fechaInicio
     */
    public function getFechaInicio(): DateTime
    {
        return $this->fechaInicio;
    }

    /**
     * Set the value of fechaInicio
     */
    public function setFechaInicio(DateTime $fechaInicio)
    {
        $this->fechaInicio = $fechaInicio;
    }

    /**
     * Get the value of fechaFin
     */
    public function getFechaFin(): DateTime
    {
        return $this->fechaFin;
    }

    /**
     * Set the value of fechaFin
     */
    public function setFechaFin(DateTime $fechaFin)
    {
        $this->fechaFin = $fechaFin;
    }

    /**
     * Get the value of fechaDevolucion
     */
    public function getFechaDevolucion(): ?DateTime
    {
        return $this->fechaDevolucion;
    }

    /**
     * Set the value of fechaDevolucion
     */
    public function setFechaDevolucion(?DateTime $fechaDevolucion)
    {
        $this->fechaDevolucion = $fechaDevolucion;
    }

    /**
     * Get the value of precio
     */
    public function getPrecio(): float
    {
        return $this->precio;
    }

    /**
     * Set the value of precio
     */
    public function setPrecio(float $precio)
    {
        $this->precio = $precio;
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
