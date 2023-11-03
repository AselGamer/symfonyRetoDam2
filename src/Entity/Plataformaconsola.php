<?php

namespace App\Entity;

use App\Entity\Consola;
use App\Entity\Plataforma;
use Doctrine\ORM\Mapping as ORM;

/**
 * Plataformaconsola
 *
 * @ORM\Table(name="PlataformaConsola", indexes={@ORM\Index(name="ConsolaPlataforma", columns={"idPlataforma"}), @ORM\Index(name="PlataformaConsola", columns={"idConsola"})})
 * @ORM\Entity
 */
class Plataformaconsola
{
    /**
     * @var int
     *
     * @ORM\Column(name="idPlataformaConsola", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idplataformaconsola;

    /**
     * @var Consola
     *
     * @ORM\ManyToOne(targetEntity="Consola")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idConsola", referencedColumnName="idConsola")
     * })
     */
    private $idconsola;

    /**
     * @var Plataforma
     *
     * @ORM\ManyToOne(targetEntity="Plataforma")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idPlataforma", referencedColumnName="idPlataforma")
     * })
     */
    private $idplataforma;



    /**
     * Get the value of idplataformaconsola
     */
    public function getIdplataformaconsola()
    {
        return $this->idplataformaconsola;
    }

    /**
     * Set the value of idplataformaconsola
     */
    public function setIdplataformaconsola(int $idplataformaconsola)
    {
        $this->idplataformaconsola = $idplataformaconsola;

        return $this;
    }

    /**
     * Get the value of idconsola
     */
    public function getIdconsola(): Consola
    {
        return $this->idconsola;
    }

    /**
     * Set the value of idconsola
     */
    public function setIdconsola(Consola $idconsola): self
    {
        $this->idconsola = $idconsola;

        return $this;
    }

    /**
     * Get the value of idplataforma
     */
    public function getIdplataforma(): Plataforma
    {
        return $this->idplataforma;
    }

    /**
     * Set the value of idplataforma
     */
    public function setIdplataforma(Plataforma $idplataforma): self
    {
        $this->idplataforma = $idplataforma;

        return $this;
    }
}
