<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * Usuario
 *
 * @ORM\Table(name="Usuario")
 * @ORM\Entity
 */
class Usuario implements UserInterface, PasswordAuthenticatedUserInterface
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

    /*
    * @ORM\Column(type= "json")
    */
    private array $roles = [];

    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function eraseCredentials(): void
    {

    }

    /**
     * Returns the identifier for this user (e.g. username or email address).
     */
    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getUsername(): string
    {
        return $this->email;
    }

    public function getSalt(): void
    {

    }

    function __toString()
    {
        return $this->nombre;
    }

    /**
     * Get the value of idusuario
     */
    public function getIdusuario(): int
    {
        return $this->idusuario;
    }

    /**
     * Set the value of idusuario
     */
    public function setIdusuario(int $idusuario): self
    {
        $this->idusuario = $idusuario;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     */
    public function setEmail(?string $email): self
    {
        $this->email = $email;

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
     * Get the value of apellido1
     */
    public function getApellido1(): ?string
    {
        return $this->apellido1;
    }

    /**
     * Set the value of apellido1
     */
    public function setApellido1(?string $apellido1): self
    {
        $this->apellido1 = $apellido1;

        return $this;
    }

    /**
     * Get the value of apellido2
     */
    public function getApellido2(): ?string
    {
        return $this->apellido2;
    }

    /**
     * Set the value of apellido2
     */
    public function setApellido2(?string $apellido2): self
    {
        $this->apellido2 = $apellido2;

        return $this;
    }

    /**
     * Get the value of telefono
     */
    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    /**
     * Set the value of telefono
     */
    public function setTelefono(?string $telefono): self
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get the value of calle
     */
    public function getCalle(): ?string
    {
        return $this->calle;
    }

    /**
     * Set the value of calle
     */
    public function setCalle(?string $calle): self
    {
        $this->calle = $calle;

        return $this;
    }

    /**
     * Get the value of numPortal
     */
    public function getNumPortal(): ?string
    {
        return $this->numPortal;
    }

    /**
     * Set the value of numPortal
     */
    public function setNumPortal(?string $numPortal): self
    {
        $this->numPortal = $numPortal;

        return $this;
    }

    /**
     * Get the value of piso
     */
    public function getPiso(): ?string
    {
        return $this->piso;
    }

    /**
     * Set the value of piso
     */
    public function setPiso(?string $piso): self
    {
        $this->piso = $piso;

        return $this;
    }

    /**
     * Get the value of codigoPostal
     */
    public function getCodigoPostal(): ?string
    {
        return $this->codigoPostal;
    }

    /**
     * Set the value of codigoPostal
     */
    public function setCodigoPostal(?string $codigoPostal): self
    {
        $this->codigoPostal = $codigoPostal;

        return $this;
    }

    /**
     * Get the value of ciudad
     */
    public function getCiudad(): ?string
    {
        return $this->ciudad;
    }

    /**
     * Set the value of ciudad
     */
    public function setCiudad(?string $ciudad): self
    {
        $this->ciudad = $ciudad;

        return $this;
    }

    /**
     * Get the value of provincia
     */
    public function getProvincia(): ?string
    {
        return $this->provincia;
    }

    /**
     * Set the value of provincia
     */
    public function setProvincia(?string $provincia): self
    {
        $this->provincia = $provincia;

        return $this;
    }

    /**
     * Get the value of pais
     */
    public function getPais(): ?string
    {
        return $this->pais;
    }

    /**
     * Set the value of pais
     */
    public function setPais(?string $pais): self
    {
        $this->pais = $pais;

        return $this;
    }
}
