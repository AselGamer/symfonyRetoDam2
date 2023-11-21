<?php

namespace App\Entity;

use App\Entity\Marca;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\VistaEntityRepository;

/**
 * ArticuloTypeView
 *
 * @ORM\Table(name="ArticuloTypeView")
 * @ORM\Entity(repositoryClass=VistaEntityRepository::class)
 */
class VistaEntity
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
     * @var string
     *
     * @ORM\Column(name="ArticuloNombre", type="string", length=50, nullable=true, options={"default"="NULL"})
     */
    private $articulonombre;

    /**
     * @var string
     *
     * @ORM\Column(name="TipoArticulo", type="string", length=16, nullable=false)
     */
    private $tipoarticulo;
    
    /**
     * @var float|null
     *
     * @ORM\Column(name="precio", type="float", precision=10, scale=0, nullable=true, options={"collation":"utf8mb4_0900_ai_ci"})
     */
    private $precio;

    /**
     * @var int
     *
     * @ORM\Column(name="stock_alquiler", type="integer", nullable=false)
     */
    private $stockalquiler;

    /**
     * @var int
     *
     * @ORM\Column(name="stock", type="integer", nullable=false)
     */
    private $stock;

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
     * @var int
     *
     * @ORM\Column(name="idTipoClase", type="integer", nullable=false)
     */
    private $idtipoClase;
    

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
     * Get the value of articulonombre
     */
    public function getArticulonombre(): string
    {
        return $this->articulonombre;
    }

    /**
     * Set the value of articulonombre
     */
    public function setArticulonombre(string $articulonombre): self
    {
        $this->articulonombre = $articulonombre;

        return $this;
    }

    /**
     * Get the value of tipoarticulo
     */
    public function getTipoarticulo(): string
    {
        return $this->tipoarticulo;
    }

    /**
     * Set the value of tipoarticulo
     */
    public function setTipoarticulo(string $tipoarticulo): self
    {
        $this->tipoarticulo = $tipoarticulo;

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
    public function getIdmarca(): Marca
    {
        return $this->idmarca;
    }

    /**
     * Set the value of idmarca
     */
    public function setIdmarca(int $idmarca): self
    {
        $this->idmarca = $idmarca;

        return $this;
    }

    /**
     * Get the value of idtipoClase
     */
    public function getIdtipoClase(): int
    {
        return $this->idtipoClase;
    }

    /**
     * Set the value of idtipoClase
     */
    public function setIdtipoClase(int $idtipoClase): self
    {
        $this->idtipoClase = $idtipoClase;

        return $this;
    }

    /**
     * Get the value of stockalquiler
     */
    public function getStockalquiler(): int
    {
        return $this->stockalquiler;
    }

    /**
     * Set the value of stockalquiler
     */
    public function setStockalquiler(int $stockalquiler)
    {
        $this->stockalquiler = $stockalquiler;
    }
}
