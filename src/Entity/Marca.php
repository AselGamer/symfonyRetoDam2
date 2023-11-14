<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Marca
 *
 * @ORM\Table(name="Marca")
 * @ORM\Entity(repositoryClass="App\Repository\MarcaRepository")
 */
class Marca
{
    /**
     * @var int
     *
     * @ORM\Column(name="idMarca", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idmarca;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=50, nullable=false)
     */
    private $nombre;

    public function __toString()
    {
        return $this->nombre;
    }

    public function getIdmarca(): ?int
    {
        return $this->idmarca;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setIdmarca(int $idmarca): self
    {
        $this->idmarca = $idmarca;

        return $this;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }
}
