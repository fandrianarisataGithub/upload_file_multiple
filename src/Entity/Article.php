<?php

namespace App\Entity;

use Serializable;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article implements Serializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="text")
     */
    private $contenu;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="articles")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Image::class, mappedBy="article")
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity=Fichier::class, mappedBy="article")
     */
    private $fichier;

    /**
     * @ORM\OneToMany(targetEntity=Video::class, mappedBy="article")
     */
    private $video;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $imagefile = [];

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $fichierFile = [];

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $videoFile = [];


    public function __construct()
    {
        $this->image = new ArrayCollection();
        $this->fichier = new ArrayCollection();
        $this->video = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImage(): Collection
    {
        return $this->image;
    }

    public function addImage(Image $image): self
    {
        if (!$this->image->contains($image)) {
            $this->image[] = $image;
            $image->setArticle($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->image->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getArticle() === $this) {
                $image->setArticle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Fichier[]
     */
    public function getFichier(): Collection
    {
        return $this->fichier;
    }

    public function addFichier(Fichier $fichier): self
    {
        if (!$this->fichier->contains($fichier)) {
            $this->fichier[] = $fichier;
            $fichier->setArticle($this);
        }

        return $this;
    }

    public function removeFichier(Fichier $fichier): self
    {
        if ($this->fichier->removeElement($fichier)) {
            // set the owning side to null (unless already changed)
            if ($fichier->getArticle() === $this) {
                $fichier->setArticle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Video[]
     */
    public function getVideo(): Collection
    {
        return $this->video;
    }

    public function addVideo(Video $video): self
    {
        if (!$this->video->contains($video)) {
            $this->video[] = $video;
            $video->setArticle($this);
        }

        return $this;
    }

    public function removeVideo(Video $video): self
    {
        if ($this->video->removeElement($video)) {
            // set the owning side to null (unless already changed)
            if ($video->getArticle() === $this) {
                $video->setArticle(null);
            }
        }

        return $this;
    }

    public function getImagefile(): ?array
    {
        return $this->imagefile;
    }

    public function setImagefile(?array $imagefile): self
    {
        $this->imagefile = $imagefile;

        return $this;
    }

    public function getFichierFile(): ?array
    {
        return $this->fichierFile;
    }

    public function setFichierFile(?array $fichierFile): self
    {
        $this->fichierFile = $fichierFile;

        return $this;
    }

    public function getVideoFile(): ?array
    {
        return $this->videoFile;
    }

    public function setVideoFile(?array $videoFile): self
    {
        $this->videoFile = $videoFile;

        return $this;
    }

    public function serialize()
    {
        return serialize($this->getId());
    }

    public function unserialize($serialized)
    {
        $this->id = unserialize($serialized);
    }

}
