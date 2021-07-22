<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=EvenementRepository::class)
 * @Vich\Uploadable
 */
class Evenement
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
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ville;


    /**
     * @ORM\ManyToMany(targetEntity=Bar::class, mappedBy="event")
     */
    private $bars;

    /**
     * @ORM\ManyToMany(targetEntity=Hotel::class, mappedBy="evenement")
     */
    private $hotels;

    /**
     * @ORM\ManyToMany(targetEntity=Jet::class, mappedBy="evenement")
     */
    private $jets;


    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="evenement")
     */
    private $users;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pays;

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
    private $urlName;

    /**
     * @ORM\OneToMany(targetEntity=UserEvent::class, mappedBy="event")
     */
    private $userEvents;

    public function __construct()
    {
        $this->bars = new ArrayCollection();
        $this->hotels = new ArrayCollection();
        $this->jets = new ArrayCollection();
        $this->plages = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->userEvents = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }


    /**
     * @return Collection|Bar[]
     */
    public function getBars(): Collection
    {
        return $this->bars;
    }

    public function addBar(Bar $bar): self
    {
        if (!$this->bars->contains($bar)) {
            $this->bars[] = $bar;
            $bar->addEvent($this);
        }

        return $this;
    }

    public function removeBar(Bar $bar): self
    {
        if ($this->bars->removeElement($bar)) {
            $bar->removeEvent($this);
        }

        return $this;
    }

    /**
     * @return Collection|Hotel[]
     */
    public function getHotels(): Collection
    {
        return $this->hotels;
    }

    public function addHotel(Hotel $hotel): self
    {
        if (!$this->hotels->contains($hotel)) {
            $this->hotels[] = $hotel;
            $hotel->addEvenement($this);
        }

        return $this;
    }

    public function removeHotel(Hotel $hotel): self
    {
        if ($this->hotels->removeElement($hotel)) {
            $hotel->removeEvenement($this);
        }

        return $this;
    }

    /**
     * @return Collection|Jet[]
     */
    public function getJets(): Collection
    {
        return $this->jets;
    }

    public function addJet(Jet $jet): self
    {
        if (!$this->jets->contains($jet)) {
            $this->jets[] = $jet;
            $jet->addEvenement($this);
        }

        return $this;
    }

    public function removeJet(Jet $jet): self
    {
        if ($this->jets->removeElement($jet)) {
            $jet->removeEvenement($this);
        }

        return $this;
    }

    /**
     * @return Collection|Plage[]
     */
    public function getPlages(): Collection
    {
        return $this->plages;
    }

    public function addPlage(Plage $plage): self
    {
        if (!$this->plages->contains($plage)) {
            $this->plages[] = $plage;
            $plage->addEvenement($this);
        }

        return $this;
    }

    public function removePlage(Plage $plage): self
    {
        if ($this->plages->removeElement($plage)) {
            $plage->removeEvenement($this);
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addEvenement($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeEvenement($this);
        }

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): self
    {
        $this->pays = $pays;

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

    public function setPosterFile(File $image = null): Evenement
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

    public function getUrlName(): ?string
    {
        return $this->urlName;
    }

    public function setUrlName(string $urlName): self
    {
        $this->urlName = $urlName;

        return $this;
    }

    /**
     * @return Collection|UserEvent[]
     */
    public function getUserEvents(): Collection
    {
        return $this->userEvents;
    }

    public function addUserEvent(UserEvent $userEvent): self
    {
        if (!$this->userEvents->contains($userEvent)) {
            $this->userEvents[] = $userEvent;
            $userEvent->setEvent($this);
        }

        return $this;
    }

    public function removeUserEvent(UserEvent $userEvent): self
    {
        if ($this->userEvents->removeElement($userEvent)) {
            // set the owning side to null (unless already changed)
            if ($userEvent->getEvent() === $this) {
                $userEvent->setEvent(null);
            }
        }

        return $this;
    }
}
