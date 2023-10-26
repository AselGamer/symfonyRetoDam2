<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Usuario
 *
 * @ORM\Table(name="Usuario")
 * @ORM\Entity
 */
class Usuario
{
    /**
     * @var int
     *
     * @ORM\Column(name="idUsuario", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idusuario;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nombre", type="string", length=30, nullable=true)
     */
    private $nombre;

    /**
     * @var string|null
     *
     * @ORM\Column(name="password", type="string", length=30, nullable=true)
     */
    private $password;

    /**
     * @var string|null
     *
     * @ORM\Column(name="apellido1", type="string", length=30, nullable=true)
     */
    private $apellido1;

    /**
     * @var string|null
     *
     * @ORM\Column(name="apellido2", type="string", length=30, nullable=true)
     */
    private $apellido2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="telefono", type="string", length=30, nullable=true)
     */
    private $telefono;

    /**
     * @var string|null
     *
     * @ORM\Column(name="calle", type="string", length=30, nullable=true)
     */
    private $calle;

    /**
     * @var string|null
     *
     * @ORM\Column(name="num_portal", type="string", length=30, nullable=true)
     */
    private $numPortal;

    /**
     * @var string|null
     *
     * @ORM\Column(name="piso", type="string", length=30, nullable=true)
     */
    private $piso;

    /**
     * @var string|null
     *
     * @ORM\Column(name="codigo_postal", type="string", length=255, nullable=true)
     */
    private $codigoPostal;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ciudad", type="string", length=30, nullable=true)
     */
    private $ciudad;

    /**
     * @var string|null
     *
     * @ORM\Column(name="provincia", type="string", length=30, nullable=true)
     */
    private $provincia;

    /**
     * @var string|null
     *
     * @ORM\Column(name="pais", type="string", length=30, nullable=true)
     */
    private $pais;


}
