<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Etiqueta
 *
 * @ORM\Table(name="Etiqueta")
 * @ORM\Entity
 */
class Etiqueta
{
    /**
     * @var int
     *
     * @ORM\Column(name="idEtiqueta", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idetiqueta;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nombre", type="string", length=255, nullable=true)
     */
    private $nombre;



    /**
     * Get the value of idetiqueta
     */
    public function getIdetiqueta(): int
    {
        return $this->idetiqueta;
    }

    /**
     * Set the value of idetiqueta
     */
    public function setIdetiqueta(int $idetiqueta)
    {
        $this->idetiqueta = $idetiqueta;

        return $this;
    }

    /**
     * Get the value of nombre
     */
    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     */
    public function setNombre(?string $nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }
}
