<?php

namespace App\Entity;

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
     * @var \Consola
     *
     * @ORM\ManyToOne(targetEntity="Consola")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idConsola", referencedColumnName="idConsola")
     * })
     */
    private $idconsola;

    /**
     * @var \Plataforma
     *
     * @ORM\ManyToOne(targetEntity="Plataforma")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idPlataforma", referencedColumnName="idPlataforma")
     * })
     */
    private $idplataforma;


}
