<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Articulo;

/**
 * Consola
 *
 * @ORM\Table(name="Consola", indexes={@ORM\Index(name="ConsolaArticulo", columns={"idArticulo"})})
 * @ORM\Entity
 */
class Consola
{
    /**
     * @var int
     *
     * @ORM\Column(name="idConsola", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idconsola;

    /**
     * @var string|null
     *
     * @ORM\Column(name="modelo", type="string", length=255, nullable=true)
     */
    private $modelo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cant_mandos", type="string", length=30, nullable=true)
     */
    private $cantMandos;

    /**
     * @var string|null
     *
     * @ORM\Column(name="almacenamiento", type="string", length=255, nullable=true)
     */
    private $almacenamiento;

    /**
     * @var Articulo
     *
     * @ORM\ManyToOne(targetEntity="Articulo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idArticulo", referencedColumnName="idArticulo")
     * })
     */
    private $idarticulo;



    /**
     * Get the value of idconsola
     */
    public function getIdconsola(): int
    {
        return $this->idconsola;
    }

    /**
     * Set the value of idconsola
     */
    public function setIdconsola(int $idconsola): self
    {
        $this->idconsola = $idconsola;

        return $this;
    }

    /**
     * Get the value of modelo
     */
    public function getModelo(): ?string
    {
        return $this->modelo;
    }

    /**
     * Set the value of modelo
     */
    public function setModelo(?string $modelo): self
    {
        $this->modelo = $modelo;

        return $this;
    }

    /**
     * Get the value of cantMandos
     */
    public function getCantMandos(): ?string
    {
        return $this->cantMandos;
    }

    /**
     * Set the value of cantMandos
     */
    public function setCantMandos(?string $cantMandos): self
    {
        $this->cantMandos = $cantMandos;

        return $this;
    }

    /**
     * Get the value of almacenamiento
     */
    public function getAlmacenamiento(): ?string
    {
        return $this->almacenamiento;
    }

    /**
     * Set the value of almacenamiento
     */
    public function setAlmacenamiento(?string $almacenamiento): self
    {
        $this->almacenamiento = $almacenamiento;

        return $this;
    }

    /**
     * Get the value of idarticulo
     */
    public function getIdarticulo(): ?Articulo
    {
        return $this->idarticulo;
    }

    /**
     * Set the value of idarticulo
     */
    public function setIdarticulo(?Articulo $idarticulo): self
    {
        $this->idarticulo = $idarticulo;

        return $this;
    }
}
