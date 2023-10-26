<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reparacion
 *
 * @ORM\Table(name="Reparacion", indexes={@ORM\Index(name="ReparacionUsuario", columns={"idUsuario"}), @ORM\Index(name="ReparacionEmpleado", columns={"idEmpleado"}), @ORM\Index(name="ReparacionEstadoReparacion", columns={"idEstadoReparacion"})})
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
     * @var \DateTime|null
     *
     * @ORM\Column(name="fecha_inicio", type="date", nullable=true)
     */
    private $fechaInicio;

    /**
     * @var \DateTime|null
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
     * @var \Usuario
     *
     * @ORM\ManyToOne(targetEntity="Usuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idUsuario", referencedColumnName="idUsuario")
     * })
     */
    private $idusuario;

    /**
     * @var \Estadoreparacion
     *
     * @ORM\ManyToOne(targetEntity="Estadoreparacion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idEstadoReparacion", referencedColumnName="idEstadoReparacion")
     * })
     */
    private $idestadoreparacion;

    /**
     * @var \Empleado
     *
     * @ORM\ManyToOne(targetEntity="Empleado")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idEmpleado", referencedColumnName="idEmpleado")
     * })
     */
    private $idempleado;


}
