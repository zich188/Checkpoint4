<?php

namespace App\Entity;

use App\Repository\JetRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=JetRepository::class)
 * @Vich\Uploadable
 */
class Jet
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
    private $nom;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $aeroportdestination;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $aeroportdepart;


    /**
     * @ORM\Column(type="time")
     */
    private $heureDepart;

    /**
     * @ORM\Column(type="time")
     */
    private $heureArrivee;

    /**
     * @ORM\ManyToMany(targetEntity=Evenement::class, inversedBy="jets")
     */
    private $evenement;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $PaysDepart;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $PaysDestination;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @Vich\UploadableField(mapping="poster_file", fileNameProperty="picture")
     * @var File | null
     * @Assert\File(
     *     maxSize = "5M",
     *     mimeTypes = {"image/jpeg", "image/png", "image/webp", "image/jpg"},
     * )
     */
    private $posterFile;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $villeDepart;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $VilleDestination;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $urlName;



    public function __construct()
    {
        $this->evenement = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }


    public function getAeroportDestination(): ?string
    {
        return $this->aeroportdestination;
    }

    public function setAeroportDestination(string $aeroportdestination): self
    {
        $this->aeroportdestination = $aeroportdestination;

        return $this;
    }

    public function getAeroportDepart(): ?string
    {
        return $this->aeroportdepart;
    }

    public function setAeroportDepart(string $aeroportdepart): self
    {
        $this->aeroportdepart = $aeroportdepart;

        return $this;
    }

    public function getHeureDepart(): ?\DateTimeInterface
    {
        return $this->heureDepart;
    }

    public function setHeureDepart(\DateTimeInterface $heureDepart): self
    {
        $this->heureDepart = $heureDepart;

        return $this;
    }

    public function getHeureArrivee(): ?\DateTimeInterface
    {
        return $this->heureArrivee;
    }

    public function setHeureArrivee(\DateTimeInterface $heureArrivee): self
    {
        $this->heureArrivee = $heureArrivee;

        return $this;
    }

    /**
     * @return Collection|Evenement[]
     */
    public function getEvenement(): Collection
    {
        return $this->evenement;
    }

    public function addEvenement(Evenement $evenement): self
    {
        if (!$this->evenement->contains($evenement)) {
            $this->evenement[] = $evenement;
        }

        return $this;
    }

    public function removeEvenement(Evenement $evenement): self
    {
        $this->evenement->removeElement($evenement);

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getPaysDepart(): ?string
    {
        return $this->PaysDepart;
    }

    public function setPaysDepart(string $PaysDepart): self
    {
        $this->PaysDepart = $PaysDepart;

        return $this;
    }

    public function getPaysDestination(): ?string
    {
        return $this->PaysDestination;
    }

    public function setPaysDestination(string $PaysDestination): self
    {
        $this->PaysDestination = $PaysDestination;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function setPosterFile(File $image = null): Jet
    {
        $this->posterFile = $image;
        return $this;
    }

    public function getPosterFile(): ?File
    {
        return $this->posterFile;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdateAt(File $image = null)
    {
        $this->updatedAt = $image;
        if ($image) {
            $this->updatedAt = new DateTime('now');
        }
    }

    public function getVilleDepart(): ?string
    {
        return $this->villeDepart;
    }

    public function setVilleDepart(string $villeDepart): self
    {
        $this->villeDepart = $villeDepart;

        return $this;
    }

    public function getVilleDestination(): ?string
    {
        return $this->VilleDestination;
    }

    public function setVilleDestination(string $VilleDestination): self
    {
        $this->VilleDestination = $VilleDestination;

        return $this;
    }

    public function getUrlName(): ?string
    {
        return $this->urlName;
    }

    public function setUrlName(string $urlName): self
    {
        $this->urlName = $urlName;

        return $this;
    }

}
