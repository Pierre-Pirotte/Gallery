<?php
namespace App\Class;

use Symfony\Component\Validator\Constraints as Assert;

class Contact
{
    #[Assert\NotBlank(message: 'Le prénom est obligatoire')]
    private ?string $firstName;

    #[Assert\NotBlank(message: 'Le nom est obligatoire')]
    private ?string $lastName;

    #[Assert\NotBlank(message: 'L\'email est obligatoire')]
    #[Assert\Email(
        message: 'Votre Email {{ value }} n\'est pas valide.'
    )]
    private ?string $email;

    #[Assert\NotBlank(message: 'Le sujet est obligatoire')]
    private ?string $subject;

    #[Assert\NotBlank(message: 'Le message est obligatoire')]
    private ?string $message;

// Getters et setters...
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(?string $subject): self
    {
        $this->subject = $subject;
        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;
        return $this;
    }
}