<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Link", inversedBy="users")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $link;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $ip;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="datetime")
     */
    private $timestamp;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLink(): ?Link
    {
        return $this->link;
    }

    public function setLink(?Link $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function setIp(string $ip): self
    {
        $this->ip = $ip;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getTimestamp(): ?\DateTimeInterface
    {
        return $this->timestamp;
    }

    public function setTimestamp(\DateTimeInterface $timestamp): self
    {
        $this->timestamp = $timestamp;

        return $this;
    }
}
