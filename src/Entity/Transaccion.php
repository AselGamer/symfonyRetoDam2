<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Transaccion
 *
 * @ORM\Table(name="Transaccion", indexes={@ORM\Index(name="idUsuario", columns={"idUsuario"})})
 * @ORM\Entity
 */
class Transaccion
{
    /**
     * @var int
     *
     * @ORM\Column(name="idTransaccion", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idtransaccion;

    /**
     * @var string|null
     *
     * @ORM\Column(name="latitud", type="string", length=30, nullable=true)
     */
    private $latitud;

    /**
     * @var string|null
     *
     * @ORM\Column(name="longitud", type="string", length=30, nullable=true)
     */
    private $longitud;

    /**
     * @var Usuario
     *
     * @ORM\ManyToOne(targetEntity="Usuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idUsuario", referencedColumnName="idUsuario")
     * })
     */
    private $idusuario;



    /**
     * Get the value of idtransaccion
     */
    public function getIdtransaccion(): int
    {
        return $this->idtransaccion;
    }

    /**
     * Set the value of idtransaccion
     */
    public function setIdtransaccion(int $idtransaccion)
    {
        $this->idtransaccion = $idtransaccion;
    }

    /**
     * Get the value of latitud
     */
    public function getLatitud(): string
    {
        return $this->latitud;
    }

    /**
     * Set the value of latitud
     */
    public function setLatitud(string $latitud)
    {
        $this->latitud = $latitud;
    }

    /**
     * Get the value of longitud
     */
    public function getLongitud(): string
    {
        return $this->longitud;
    }

    /**
     * Set the value of longitud
     */
    public function setLongitud(string $longitud)
    {
        $this->longitud = $longitud;
    }

    /**
     * Get the value of idusuario
     */
    public function getIdusuario(): Usuario
    {
        return $this->idusuario;
    }

    /**
     * Set the value of idusuario
     */
    public function setIdusuario(Usuario $idusuario)
    {
        $this->idusuario = $idusuario;
    }
}
