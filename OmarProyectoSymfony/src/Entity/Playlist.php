<?php

namespace App\Entity;

use App\Repository\PlaylistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlaylistRepository::class)]
class Playlist
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(length: 255)]
    private ?string $visibilidad = null;

    #[ORM\Column]
    private ?int $reproducciones = null;

    #[ORM\Column]
    private ?int $likes = null;

    #[ORM\ManyToOne(inversedBy: 'propietario', cascade: ['persist'])]
    private ?Usuario $propietario = null;

    /**
     * @var Collection<int, UsuarioPlaylist>
     */
    #[ORM\OneToMany(targetEntity: UsuarioPlaylist::class, mappedBy: 'playlist', cascade: ['persist'])]
    private Collection $playlist;

    /**
     * @var Collection<int, PlaylistCancion>
     */
    #[ORM\OneToMany(targetEntity: PlaylistCancion::class, mappedBy: 'playlist', cascade: ['persist'])]
    private Collection $lista;

    public function __construct()
    {
        $this->playlist = new ArrayCollection();
        $this->lista = new ArrayCollection();
    }

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

    public function getVisibilidad(): ?string
    {
        return $this->visibilidad;
    }

    public function setVisibilidad(string $visibilidad): static
    {
        $this->visibilidad = $visibilidad;

        return $this;
    }

    public function getReproducciones(): ?int
    {
        return $this->reproducciones;
    }

    public function setReproducciones(int $reproducciones): static
    {
        $this->reproducciones = $reproducciones;

        return $this;
    }

    public function getLikes(): ?int
    {
        return $this->likes;
    }

    public function setLikes(int $likes): static
    {
        $this->likes = $likes;

        return $this;
    }

    public function getPropietario(): ?Usuario
    {
        return $this->propietario;
    }

    public function setPropietario(?Usuario $propietario): static
    {
        $this->propietario = $propietario;

        return $this;
    }

    /**
     * @return Collection<int, UsuarioPlaylist>
     */
    public function getPlaylist(): Collection
    {
        return $this->playlist;
    }

    public function addPlaylist(UsuarioPlaylist $playlist): static
    {
        if (!$this->playlist->contains($playlist)) {
            $this->playlist->add($playlist);
            $playlist->setPlaylist($this);
        }

        return $this;
    }

    public function removePlaylist(UsuarioPlaylist $playlist): static
    {
        if ($this->playlist->removeElement($playlist)) {
            // set the owning side to null (unless already changed)
            if ($playlist->getPlaylist() === $this) {
                $playlist->setPlaylist(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PlaylistCancion>
     */
    public function getLista(): Collection
    {
        return $this->lista;
    }

    public function addListum(PlaylistCancion $listum): static
    {
        if (!$this->lista->contains($listum)) {
            $this->lista->add($listum);
            $listum->setPlaylist($this);
        }

        return $this;
    }

    public function removeListum(PlaylistCancion $listum): static
    {
        if ($this->lista->removeElement($listum)) {
            // set the owning side to null (unless already changed)
            if ($listum->getPlaylist() === $this) {
                $listum->setPlaylist(null);
            }
        }

        return $this;
    }
}
