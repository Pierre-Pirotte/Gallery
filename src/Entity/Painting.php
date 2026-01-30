<?php

namespace App\Entity;

use App\Repository\PaintingRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: PaintingRepository::class)]
#[Vich\Uploadable]
#[UniqueEntity(
    fields: ['title'],
    message: 'Ce nom existe déjà!'
)]
class Painting
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;



    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'Le Nom est obligatoire')]
    #[Assert\Length(
        min: 5,
        max: 50,
        minMessage: 'Le Nom doit contenir au minimum {{ limit }} caractères',
        maxMessage: 'Le Nom ne peut pas dépasser {{ limit }} caractères'
    )]
    private ?string $title = null;



    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'Le Nom de l\'auteur est obligatoire')]
    #[Assert\Length(
        min: 5,
        max: 50,
        minMessage: 'Le Nom de l\'auteur doit contenir au minimum {{ limit }} caractères',
        maxMessage: 'Le Nom de l\'auteur ne peut pas dépasser {{ limit }} caractères'
    )]
    private ?string $author = null;



    #[ORM\Column(type: 'text')]
    #[Assert\NotBlank(message: 'La description est obligatoire')]
    #[Assert\Length(
        min: 10,
        max: 10000,
        minMessage: 'La description doit contenir au minimum {{ limit }} caractères',
        maxMessage: 'La description ne peut pas dépasser {{ limit }} caractères'
    )]
    private ?string $description = null;



    #[ORM\Column(type: 'date_immutable', nullable: true)]
    #[Assert\NotBlank(message: 'La date de création est obligatoire')]
    #[Assert\LessThanOrEqual('today', message: 'La date de création ne peut pas être dans le futur')]
    #[Assert\GreaterThanOrEqual( value:'0001-01-01', message: 'La date de création doit être postérieure à l\'an 0001')]
    private ?\DateTimeImmutable $created = null;


    #[Assert\NotBlank(message: 'La hauteur est obligatoire')]
    #[ORM\Column]
    #[Assert\Range(
        min: 10,
        max: 1000,
        notInRangeMessage: 'La hauteur doit être comprise entre {{ min }} et {{ max }} cm'
    )]
    #[Assert\Regex(
        pattern: '/^\d+(\.\d{1})?$/',
        message: 'La hauteur doit être un nombre valide avec au maximum une décimale'
    )]
    private ?float $height = null;


    #[Assert\NotBlank(message: 'La largeur est obligatoire')]
    #[ORM\Column]
    #[Assert\Range(
        min: 10,
        max: 1000,
        notInRangeMessage: 'La largeur doit être comprise entre {{ min }} et {{ max }} cm'
    )]
    #[Assert\Regex(
        pattern: '/^\d+(\.\d{1})?$/',
        message: 'La largeur doit être un nombre valide avec au maximum une décimale'
    )]
    private ?float $width = null;


    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[Vich\UploadableField(mapping: 'paintings_images', fileNameProperty: 'image')]
    #[Assert\File(
        maxSize: '5M',
        maxSizeMessage: 'La taille du fichier est trop volumineuse ({{ size }} {{ suffix }}). La taille maximale autorisée est {{ limit }} {{ suffix }}.',
        mimeTypes: ['image/jpeg', 'image/png', 'image/webp'],
        mimeTypesMessage: 'Formats acceptés : (JPEG, PNG, WEBP)'
    )]
    private ?File $imageFile = null;


    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;


    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'La technique est obligatoire')]
    #[Assert\Length(
        min: 5,
        max: 100,
        minMessage: 'La technique doit contenir au minimum {{ limit }} caractères',
        maxMessage: 'La technique ne peut pas dépasser {{ limit }} caractères'
    )]
    private ?string $technical = null;


    #[ORM\Column(length: 255, unique: true)]
    private ?string $slug = null;


    #[ORM\Column(type: 'boolean', options: ['default' => true])]
    private ?bool $isVisible = true;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): static
    {
        $this->author = $author;

        return $this;
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

    public function getCreated(): ?\DateTimeImmutable
    {
        return $this->created;
    }

    public function setCreated(\DateTimeImmutable $created): static
    {
        $this->created = $created;

        return $this;
    }

    public function getHeight(): ?float
    {
        return $this->height;
    }

    public function setHeight(float $height): static
    {
        $this->height = $height;

        return $this;
    }

    public function getWidth(): ?float
    {
        return $this->width;
    }

    public function setWidth(float $width): static
    {
        $this->width = $width;

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

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // Mettre à jour updatedAt pour forcer la mise à jour Doctrine
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }


    public function getTechnical(): ?string
    {
        return $this->technical;
    }

    public function setTechnical(string $technical): static
    {
        $this->technical = $technical;

        return $this;
    }

    public function getSlug(): ?string
    {
    return $this->slug;
    }

    public function setSlug(string $slug): static
    {
    $this->slug = $slug;
    return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function isVisible(): ?bool
    {
        return $this->isVisible;
    }

    public function setIsVisible(bool $isVisible): static
    {
        $this->isVisible = $isVisible;
        return $this;
    }
}
