<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * Empleado
 *
 * @ORM\Table(name="Empleado")
 * @ORM\Entity
 */
class Empleado implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="idEmpleado", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idempleado;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=30, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido1", type="string", length=30, nullable=false)
     */
    private $apellido1;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido2", type="string", length=30, nullable=false)
     */
    private $apellido2;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=30, nullable=false)
     */
    private $password;

    /**
     * @var bool
     *
     * @ORM\Column(name="gerente", type="boolean", nullable=false)
     */
    private $gerente = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=30, nullable=false)
     */
    private $email;
    /**
     * @ORM\Column(type= "json")
     */
    private $roles = [];

    function __toString()
    {
        return $this->nombre;
    }

    /**
     * Get the value of idempleado
     */
    public function getIdempleado(): int
    {
        return $this->idempleado;
    }

    /**
     * Set the value of idempleado
     */
    public function setIdempleado(int $idempleado)
    {
        $this->idempleado = $idempleado;
    }

    /**
     * Get the value of nombre
     */
    public function getNombre(): string
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     */
    public function setNombre(string $nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * Get the value of apellido1
     */
    public function getApellido1(): string
    {
        return $this->apellido1;
    }

    /**
     * Set the value of apellido1
     */
    public function setApellido1(string $apellido1)
    {
        $this->apellido1 = $apellido1;
    }

    /**
     * Get the value of apellido2
     */
    public function getApellido2(): string
    {
        return $this->apellido2;
    }

    /**
     * Set the value of apellido2
     */
    public function setApellido2(string $apellido2)
    {
        $this->apellido2 = $apellido2;
    }

    /**
     * Get the value of password
     */
    public function getPassword(): string
    {
        
        return $this->password;
    }

    /**
     * Set the value of password
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    /**
     * Get the value of gerente
     */
    public function isGerente(): bool
    {
        return $this->gerente;
    }

    /**
     * Set the value of gerente
     */
    public function setGerente(bool $gerente)
    {
        $this->gerente = $gerente;
    }

    /**
     * Get the value of email
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_EMPLEADO';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
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
        return $this->nombre;
    }

    public function getUsername(): string
    {
        return $this->nombre;
    }
}
