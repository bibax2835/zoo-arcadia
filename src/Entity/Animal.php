<?php

namespace App\Entity;

use App\Repository\AnimalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Gedmo\Mapping\Annotation as Gedmo;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: AnimalRepository::class)]
#[Vich\Uploadable]
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

    #[Vich\UploadableField(mapping: 'animal_image', fileNameProperty: 'image')]
    private ?File $imageFile = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

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

    public function __toString(): string
    {
        return $this->name ?? '';
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }

    


public function getSlug(): ?string
{
    return $this->slug;
}

public function setSlug(string $slug = null): static
{
    if ($slug) {
        $this->slug = $slug;
    } else if ($this->name) {
        // Utilise le nom pour générer un slug automatiquement si le slug n'est pas défini
        $this->slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $this->name), '-'));
    }

    return $this;
}
// Dans un contrôleur temporaire ou une commande de console
public function generateSlugs(EntityManagerInterface $entityManager): Response
{
    $animals = $entityManager->getRepository(Animal::class)->findAll();

    foreach ($animals as $animal) {
        if (empty($animal->getSlug())) {
            // Génére un slug en utilisant le nom
            $animal->setSlug(strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $animal->getName()), '-')));
        }
    }

    // Sauvegarde les modifications
    $entityManager->flush();

    return new Response("Tous les slugs manquants ont été générés.");
}

}