<?php

namespace App\Entity;

use App\Repository\AnimalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: AnimalRepository::class)]
#[Vich\Uploadable] // Annotation pour indiquer que l'entité est uploadable
class Animal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $species = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    // Ce champ n'est pas persisté en base de données
    #[Vich\UploadableField(mapping: 'animal_image', fileNameProperty: 'image')]
    private ?File $imageFile = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    /**
     * @var Collection<int, VeterinaryReport>
     */
    #[ORM\OneToMany(mappedBy: 'animal', targetEntity: VeterinaryReport::class)]
    private Collection $veterinaryReports;

    /**
     * @var Collection<int, Habitat>
     */
    #[ORM\ManyToMany(targetEntity: Habitat::class, inversedBy: 'animals')]
    private Collection $habitat;

    public function __construct()
    {
        $this->veterinaryReports = new ArrayCollection();
        $this->habitat = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getSpecies(): ?string
    {
        return $this->species;
    }

    public function setSpecies(string $species): static
    {
        $this->species = $species;
        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;
        return $this;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        // Mettre à jour la date de modification si un fichier est téléchargé
        if ($imageFile instanceof File) {
            $this->updatedAt = new \DateTime();
        }
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return Collection<int, VeterinaryReport>
     */
    public function getVeterinaryReports(): Collection
    {
        return $this->veterinaryReports;
    }

    public function addVeterinaryReport(VeterinaryReport $veterinaryReport): static
    {
        if (!$this->veterinaryReports->contains($veterinaryReport)) {
            $this->veterinaryReports->add($veterinaryReport);
            $veterinaryReport->setAnimal($this);
        }

        return $this;
    }

    public function removeVeterinaryReport(VeterinaryReport $veterinaryReport): static
    {
        if ($this->veterinaryReports->removeElement($veterinaryReport)) {
            if ($veterinaryReport->getAnimal() === $this) {
                $veterinaryReport->setAnimal(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Habitat>
     */
    public function getHabitat(): Collection
    {
        return $this->habitat;
    }

    public function addHabitat(Habitat $habitat): static
    {
        if (!$this->habitat->contains($habitat)) {
            $this->habitat->add($habitat);
        }

        return $this;
    }

    public function removeHabitat(Habitat $habitat): static
    {
        $this->habitat->removeElement($habitat);
        return $this;
    }

    /**
     * Convert the object to a string (for displaying in forms)
     */
    public function __toString(): string
    {
        return $this->name ?? ''; // Gérer les cas où le nom est null
    }
}
