<?php

namespace App\Entity;

use App\Repository\EstiloRepository;
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

    #[ORM\ManyToOne(inversedBy: 'estiloMusicalPreferido')]
    private ?Perfil $estiloMusicalPreferido = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): static
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getEstiloMusicalPreferido(): ?Perfil
    {
        return $this->estiloMusicalPreferido;
    }

    public function setEstiloMusicalPreferido(?Perfil $estiloMusicalPreferido): static
    {
        $this->estiloMusicalPreferido = $estiloMusicalPreferido;

        return $this;
    }
}
