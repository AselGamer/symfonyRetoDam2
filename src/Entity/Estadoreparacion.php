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
     * @ORM\Column(name="nombre", type="string", length=30, nullable=false)
     */
    private $nombre;



    function __toString()
    {
        return $this->nombre;
    }

    /**
     * Get the value of idestadoreparacion
     */
    public function getIdestadoreparacion(): int
    {
        return $this->idestadoreparacion;
    }

    /**
     * Set the value of idestadoreparacion
     */
    public function setIdestadoreparacion(int $idestadoreparacion)
    {
        $this->idestadoreparacion = $idestadoreparacion;
    }

    /**
     * Get the value of nombre
     */
    public function getNombre(): string
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     */
    public function setNombre(string $nombre)
    {
        $this->nombre = $nombre;
    }
}
