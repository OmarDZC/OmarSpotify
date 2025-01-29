<?php

namespace App\Entity;

use App\Repository\UsuarioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsuarioRepository::class)]
class Usuario
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fechaNacimiento = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Perfil $perfil = null;

    /**
     * @var Collection<int, Playlist>
     */
    #[ORM\OneToMany(targetEntity: Playlist::class, mappedBy: 'propietario')]
    private Collection $propietario;

    /**
     * @var Collection<int, UsuarioPlaylist>
     */
    #[ORM\OneToMany(targetEntity: UsuarioPlaylist::class, mappedBy: 'usuario')]
    private Collection $usuario;

    public function __construct()
    {
        $this->propietario = new ArrayCollection();
        $this->usuario = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getFechaNacimiento(): ?\DateTimeInterface
    {
        return $this->fechaNacimiento;
    }

    public function setFechaNacimiento(\DateTimeInterface $fechaNacimiento): static
    {
        $this->fechaNacimiento = $fechaNacimiento;

        return $this;
    }

    public function getPerfil(): ?Perfil
    {
        return $this->perfil;
    }

    public function setPerfil(Perfil $perfil): static
    {
        $this->perfil = $perfil;

        return $this;
    }

    /**
     * @return Collection<int, Playlist>
     */
    public function getPropietario(): Collection
    {
        return $this->propietario;
    }

    public function addPropietario(Playlist $propietario): static
    {
        if (!$this->propietario->contains($propietario)) {
            $this->propietario->add($propietario);
            $propietario->setPropietario($this);
        }

        return $this;
    }

    public function removePropietario(Playlist $propietario): static
    {
        if ($this->propietario->removeElement($propietario)) {
            // set the owning side to null (unless already changed)
            if ($propietario->getPropietario() === $this) {
                $propietario->setPropietario(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UsuarioPlaylist>
     */
    public function getUsuario(): Collection
    {
        return $this->usuario;
    }

    public function addUsuario(UsuarioPlaylist $usuario): static
    {
        if (!$this->usuario->contains($usuario)) {
            $this->usuario->add($usuario);
            $usuario->setUsuario($this);
        }

        return $this;
    }

    public function removeUsuario(UsuarioPlaylist $usuario): static
    {
        if ($this->usuario->removeElement($usuario)) {
            // set the owning side to null (unless already changed)
            if ($usuario->getUsuario() === $this) {
                $usuario->setUsuario(null);
            }
        }

        return $this;
    }
}
