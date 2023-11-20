<?php

namespace App\Entity;

use App\Entity\Usuario;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\VistaTransaccionRepository;

/**
 * ArticuloTypeView
 *
 * @ORM\Table(name="TransaccionTypeView")
 * @ORM\Entity(repositoryClass=VistaTransaccionRepository::class)
 */
class VistaTransaccion
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
     * @var Usuario
     *
     * @ORM\ManyToOne(targetEntity="Usuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idUsuario", referencedColumnName="idUsuario")
     * })
     */
    private $idusuario;

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
     * @var string
     *
     * @ORM\Column(name="TipoTransaccion", type="string", length=8, nullable=false)
     */
    private $tipotransaccion;

    /**
     * @var int
     *
     * @ORM\Column(name="idTipoTransaccion", type="integer", nullable=false)
     */
    private $idtipoTransaccion;


    

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
     * Get the value of idtipoTransaccion
     */
    public function getIdtipoTransaccion(): int
    {
        return $this->idtipoTransaccion;
    }

    /**
     * Set the value of idtipoTransaccion
     */
    public function setIdtipoTransaccion(int $idtipoTransaccion)
    {
        $this->idtipoTransaccion = $idtipoTransaccion;
    }

 



    /**
     * Get the value of tipotransaccion
     */
    public function getTipotransaccion(): string
    {
        return $this->tipotransaccion;
    }

    /**
     * Set the value of tipotransaccion
     */
    public function setTipotransaccion(string $tipotransaccion)
    {
        $this->tipotransaccion = $tipotransaccion;
    }
}