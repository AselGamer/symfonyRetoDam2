<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Articulo as Articulo;

/**
 * Dispositivomovil
 *
 * @ORM\Table(name="DispositivoMovil", indexes={@ORM\Index(name="DispositivoMovilArticulo", columns={"idArticulo"})})
 * @ORM\Entity
 */
class Dispositivomovil
{
    /**
     * @var int
     *
     * @ORM\Column(name="idDispositivoMovil", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $iddispositivomovil;

    /**
     * @var string|null
     *
     * @ORM\Column(name="almacenamiento", type="string", length=255, nullable=true)
     */
    private $almacenamiento;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ram", type="string", length=30, nullable=true)
     */
    private $ram;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tamano_pantalla", type="string", length=30, nullable=true)
     */
    private $tamanoPantalla;

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
     * Get the value of iddispositivomovil
     */
    public function getIddispositivomovil(): int
    {
        return $this->iddispositivomovil;
    }

    /**
     * Set the value of iddispositivomovil
     */
    public function setIddispositivomovil(int $iddispositivomovil): self
    {
        $this->iddispositivomovil = $iddispositivomovil;

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
     * Get the value of ram
     */
    public function getRam(): ?string
    {
        return $this->ram;
    }

    /**
     * Set the value of ram
     */
    public function setRam(?string $ram): self
    {
        $this->ram = $ram;

        return $this;
    }

    /**
     * Get the value of tamanoPantalla
     */
    public function getTamanoPantalla(): ?string
    {
        return $this->tamanoPantalla;
    }

    /**
     * Set the value of tamanoPantalla
     */
    public function setTamanoPantalla(?string $tamanoPantalla): self
    {
        $this->tamanoPantalla = $tamanoPantalla;

        return $this;
    }

    /**
     * Get the value of idarticulo
     */
    public function getIdarticulo(): Articulo
    {
        return $this->idarticulo;
    }

    /**
     * Set the value of idarticulo
     */
    public function setIdarticulo(Articulo $idarticulo): self
    {
        $this->idarticulo = $idarticulo;

        return $this;
    }
}
