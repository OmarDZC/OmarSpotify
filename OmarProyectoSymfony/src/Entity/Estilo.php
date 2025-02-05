<?php

namespace App\Entity;

use App\Repository\EstiloRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EstiloRepository::class)]
class Estilo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(length: 255)]
    private ?string $descripcion = null;

    /**
     * @var Collection<int, Cancion>
     */
    #[ORM\OneToMany(targetEntity: Cancion::class, mappedBy: 'genero')]
    #[ORM\JoinColumn(nullable: true)]
    private Collection $canciones;

    /**
     * @var Collection<int, Perfil>
     */
    #[ORM\ManyToMany(targetEntity: Perfil::class, mappedBy: 'estiloPreferido')]
    private Collection $perfiles;



    public function __construct()
    {
        $this->canciones = new ArrayCollection();
        $this->perfiles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * @return Collection<int, Cancion>
     */
    public function getCanciones(): Collection
    {
        return $this->canciones;
    }

    public function addCancione(Cancion $cancione)
    {
        if (!$this->canciones->contains($cancione)) {
            $this->canciones->add($cancione);
            $cancione->setGenero($this);
        }

        return $this;
    }

    public function removeCancione(Cancion $cancione)
    {
        if ($this->canciones->removeElement($cancione)) {
            if ($cancione->getGenero() === $this) {
                $cancione->setGenero(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Perfil>
     */
    public function getPerfiles(): Collection
    {
        return $this->perfiles;
    }

    public function addPerfile(Perfil $perfil): static
    {
        if (!$this->perfiles->contains($perfil)) {
            $this->perfiles->add($perfil);
        }

        return $this;
    }

    public function removePerfile(Perfil $perfil): static
    {
        $this->perfiles->removeElement($perfil);

        return $this;
    }



    public function __toString()
    {
        return $this->getNombre();
    }
}
