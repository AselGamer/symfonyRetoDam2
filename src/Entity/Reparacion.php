<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Reparacion
 *
 * @ORM\Table(name="Reparacion", indexes={@ORM\Index(name="ReparacionEstadoReparacion", columns={"idEstadoReparacion"}), @ORM\Index(name="ReparacionEmpleado", columns={"idEmpleado"}), @ORM\Index(name="ReparacionUsuario", columns={"idUsuario"})})
 * @ORM\Entity
 */
class Reparacion
{
    /**
     * @var int
     *
     * @ORM\Column(name="idReparacion", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idreparacion;

    /**
     * @var string
     *
     * @ORM\Column(name="problema", type="string", length=255, nullable=false)
     */
    private $problema;

    /**
     * @var string|null
     *
     * @ORM\Column(name="comentario_reparacion", type="string", length=255, nullable=true)
     */
    private $comentarioReparacion;

    /**
     * @var DateTime|null
     *
     * @ORM\Column(name="fecha_inicio", type="date", nullable=true)
     */
    private $fechaInicio;

    /**
     * @var DateTime|null
     *
     * @ORM\Column(name="fecha_fin", type="date", nullable=true)
     */
    private $fechaFin;

    /**
     * @var float|null
     *
     * @ORM\Column(name="precio", type="float", precision=10, scale=0, nullable=true)
     */
    private $precio;

    /**
     * @var Usuario
     *
     * @ORM\ManyToOne(targetEntity="Usuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idUsuario", referencedColumnName="idUsuario")
     * })
     */
    private $idusuario;

    /**
     * @var Estadoreparacion
     *
     * @ORM\ManyToOne(targetEntity="Estadoreparacion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idEstadoReparacion", referencedColumnName="idEstadoReparacion")
     * })
     */
    private $idestadoreparacion;

    /**
     * @var Empleado
     *
     * @ORM\ManyToOne(targetEntity="Empleado")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idEmpleado", referencedColumnName="idEmpleado")
     * })
     */
    private $idempleado;



    /**
     * Get the value of idreparacion
     */
    public function getIdreparacion(): int
    {
        return $this->idreparacion;
    }

    /**
     * Set the value of idreparacion
     */
    public function setIdreparacion(int $idreparacion)
    {
        $this->idreparacion = $idreparacion;
    }

    /**
     * Get the value of problema
     */
    public function getProblema(): string
    {
        return $this->problema;
    }

    /**
     * Set the value of problema
     */
    public function setProblema(string $problema)
    {
        $this->problema = $problema;
    }

    /**
     * Get the value of comentarioReparacion
     */
    public function getComentarioReparacion(): ?string
    {
        return $this->comentarioReparacion;
    }

    /**
     * Set the value of comentarioReparacion
     */
    public function setComentarioReparacion(?string $comentarioReparacion)
    {
        $this->comentarioReparacion = $comentarioReparacion;
    }

    /**
     * Get the value of fechaInicio
     */
    public function getFechaInicio(): ?DateTime
    {
        return $this->fechaInicio;
    }

    /**
     * Set the value of fechaInicio
     */
    public function setFechaInicio(?DateTime $fechaInicio)
    {
        $this->fechaInicio = $fechaInicio;
    }

    /**
     * Get the value of fechaFin
     */
    public function getFechaFin(): ?DateTime
    {
        return $this->fechaFin;
    }

    /**
     * Set the value of fechaFin
     */
    public function setFechaFin(?DateTime $fechaFin)
    {
        $this->fechaFin = $fechaFin;
    }

    /**
     * Get the value of precio
     */
    public function getPrecio(): ?float
    {
        return $this->precio;
    }

    /**
     * Set the value of precio
     */
    public function setPrecio(?float $precio)
    {
        $this->precio = $precio;
    }

    /**
     * Get the value of idusuario
     */
    public function getIdusuario(): Usuario
    {
        return $this->idusuario;
    }

    /**
     * Set the value of idusuario
     */
    public function setIdusuario(Usuario $idusuario)
    {
        $this->idusuario = $idusuario;
    }

    /**
     * Get the value of idestadoreparacion
     */
    public function getIdestadoreparacion(): Estadoreparacion
    {
        return $this->idestadoreparacion;
    }

    /**
     * Set the value of idestadoreparacion
     */
    public function setIdestadoreparacion(Estadoreparacion $idestadoreparacion)
    {
        $this->idestadoreparacion = $idestadoreparacion;
    }

    /**
     * Get the value of idempleado
     */
    public function getIdempleado(): ?Empleado
    {
        return $this->idempleado;
    }

    /**
     * Set the value of idempleado
     */
    public function setIdempleado(?Empleado $idempleado)
    {
        $this->idempleado = $idempleado;
    }
}
