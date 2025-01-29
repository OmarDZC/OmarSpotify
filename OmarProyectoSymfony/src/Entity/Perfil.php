<?php

namespace App\Entity;

use App\Repository\PerfilRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PerfilRepository::class)]
class Perfil
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $foto = null;

    #[ORM\Column(length: 255)]
    private ?string $descripcion = null;

    /**
     * @var Collection<int, Estilo>
     */
    #[ORM\OneToMany(targetEntity: Estilo::class, mappedBy: 'estiloMusicalPreferido', cascade: ['persist'])]
    private Collection $estiloMusicalPreferido;

    public function __construct()
    {
        $this->estiloMusicalPreferido = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFoto(): ?string
    {
        return $this->foto;
    }

    public function setFoto(string $foto): static
    {
        $this->foto = $foto;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): static
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * @return Collection<int, Estilo>
     */
    public function getEstiloMusicalPreferido(): Collection
    {
        return $this->estiloMusicalPreferido;
    }

    public function addEstiloMusicalPreferido(Estilo $estiloMusicalPreferido): static
    {
        if (!$this->estiloMusicalPreferido->contains($estiloMusicalPreferido)) {
            $this->estiloMusicalPreferido->add($estiloMusicalPreferido);
            $estiloMusicalPreferido->setEstiloMusicalPreferido($this);
        }

        return $this;
    }

    public function removeEstiloMusicalPreferido(Estilo $estiloMusicalPreferido): static
    {
        if ($this->estiloMusicalPreferido->removeElement($estiloMusicalPreferido)) {
            // set the owning side to null (unless already changed)
            if ($estiloMusicalPreferido->getEstiloMusicalPreferido() === $this) {
                $estiloMusicalPreferido->setEstiloMusicalPreferido(null);
            }
        }

        return $this;
    }
}
