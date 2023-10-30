<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Plataforma
 *
 * @ORM\Table(name="Plataforma")
 * @ORM\Entity
 */
class Plataforma
{
    /**
     * @var int
     *
     * @ORM\Column(name="idPlataforma", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idplataforma;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255, nullable=false)
     */
    private $nombre;

    public function __toString()
    {
        return $this->nombre;
    }
    
    /**
     * Get the value of idplataforma
     */
    public function getIdplataforma(): int
    {
        return $this->idplataforma;
    }

    /**
     * Set the value of idplataforma
     */
    public function setIdplataforma(int $idplataforma): self
    {
        $this->idplataforma = $idplataforma;

        return $this;
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
    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }
}
