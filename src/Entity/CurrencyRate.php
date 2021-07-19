<?php

namespace App\Entity;

use App\Repository\CurrencyRateRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ApiResource(
 *      collectionOperations = {
 *          "GET"
 * },
 *      itemOperations = {
 *          "GET"
 * }
 * ) 
 * 
 * @ORM\Entity(repositoryClass=CurrencyRateRepository::class)
 */
class CurrencyRate
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
    private $currency;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $code;

    /**
     * @ORM\Column(type="float")
     */
    private $mid;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getMid(): ?float
    {
        return $this->mid;
    }

    public function setMid(float $mid): self
    {
        $this->mid = $mid;

        return $this;
    }
}
