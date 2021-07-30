<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\IsLegalAge;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * 
 * @UniqueEntity(
 *      fields={"email"},
 *      message = "Podany klient istnieje")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * 
     * @Assert\Email(message = "email {{ value }} nie jest poprawny")
     * @Assert\NotBlank()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Assert\NotBlank()
     */
    private $surname;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Assert\Length(min = 9, max = 9, exactMessage = "Numer musi zawierać 9 cyfr")
     * @Assert\Regex(pattern="/^[0-9]*$/", message="tylko numer telefonu") 
     * @Assert\NotBlank()
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="datetime")
     * 
     * @Assert\NotBlank()
     * @IsLegalAge()
     */
    private $birthDate;

    /**
     * @ORM\Column(type="json")
     */
    private $currencies = [];

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $currencyEventMin = [];

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $currencyEventMax = [];

    /**
     * @ORM\Column(type="boolean")
     */
    private $confirmed;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getCurrencies(): ?array
    {
        return $this->currencies;
    }

    public function setCurrencies(array $currencies): self
    {
        $this->currencies = $currencies;

        return $this;
    }

    public function getCurrencyEventMin(): ?array
    {
        return $this->currencyEventMin;
    }

    public function setCurrencyEventMin(?array $currencyEventMin): self
    {
        $this->currencyEventMin = $currencyEventMin;

        return $this;
    }

    public function getCurrencyEventMax(): ?array
    {
        return $this->currencyEventMax;
    }

    public function setCurrencyEventMax(?array $currencyEventMax): self
    {
        $this->currencyEventMax = $currencyEventMax;

        return $this;
    }

    public function getConfirmed(): ?bool
    {
        return $this->confirmed;
    }

    public function setConfirmed(bool $confirmed): self
    {
        $this->confirmed = $confirmed;

        return $this;
    }
}
