<?php

namespace App\Entity;

use App\Entity\Marca as Marca;
use App\Repository\ArticuloRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Articulo
 *
 * @ORM\Table(name="Articulo", indexes={@ORM\Index(name="MarcaArticulo", columns={"idMarca"})})
 * @ORM\Entity(repositoryClass=ArticuloRepository::class)
 */
class Articulo
{
    /**
     * @var int
     *
     * @ORM\Column(name="idArticulo", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idarticulo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nombre", type="string", length=50, nullable=true)
     */
    private $nombre;

    /**
     * @var float|null
     *
     * @ORM\Column(name="precio", type="float", precision=10, scale=0, nullable=true)
     */
    private $precio;

    /**
     * @var int
     *
     * @ORM\Column(name="stock", type="integer", nullable=false)
     */
    private $stock;

    /**
     * @var int
     *
     * @ORM\Column(name="stock_alquiler", type="integer", nullable=true)
     */
    private $stockAlquiler;

    /**
     * @var string|null
     *
     * @ORM\Column(name="foto", type="string", length=255, nullable=true)
     */
    private $foto;

    /**
     * @var Marca
     *
     * @ORM\ManyToOne(targetEntity="Marca")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idMarca", referencedColumnName="idMarca")
     * })
     */
    private $idmarca;


    


    /**
     * Get the value of idarticulo
     */
    public function getIdarticulo(): int
    {
        return $this->idarticulo;
    }

    /**
     * Set the value of idarticulo
     */
    public function setIdarticulo(int $idarticulo): self
    {
        $this->idarticulo = $idarticulo;

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
    public function setNombre(?string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
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
    public function setPrecio(?float $precio): self
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Get the value of stock
     */
    public function getStock(): int
    {
        return $this->stock;
    }

    /**
     * Set the value of stock
     */
    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get the value of foto
     */
    public function getFoto(): ?string
    {
        return $this->foto;
    }

    /**
     * Set the value of foto
     */
    public function setFoto(?string $foto): self
    {
        $this->foto = $foto;

        return $this;
    }

    /**
     * Get the value of idmarca
     */
    public function getIdmarca(): ?Marca
    {
        return $this->idmarca;
    }

    /**
     * Set the value of idmarca
     */
    public function setIdmarca(Marca $idmarca): self
    {
        $this->idmarca = $idmarca;

        return $this;
    }

    /**
     * Get the value of stockAlquiler
     */
    public function getStockAlquiler(): int
    {
        return $this->stockAlquiler;
    }

    /**
     * Set the value of stockAlquiler
     */
    public function setStockAlquiler(int $stockAlquiler)
    {
        $this->stockAlquiler = $stockAlquiler;
    }
}
