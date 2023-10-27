<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Estadoreparacion
 *
 * @ORM\Table(name="EstadoReparacion")
 * @ORM\Entity
 */
class Estadoreparacion
{
    /**
     * @var int
     *
     * @ORM\Column(name="idEstadoReparacion", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idestadoreparacion;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=30, nullable=false)
     */
    private $estado;


}
