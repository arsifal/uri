<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LinkRepository")
 */
class Link
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=190)
     */
    private $initial_link;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $output_link;

    /**
     * @ORM\Column(type="datetime")
     */
    private $create_timestamp;

    /**
     * @ORM\Column(type="datetime")
     */
    private $expire_timestamp;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="link", orphanRemoval=true)
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInitialLink(): ?string
    {
        return $this->initial_link;
    }

    public function setInitialLink(string $initial_link): self
    {
        $this->initial_link = $initial_link;

        return $this;
    }

    public function getOutputLink(): ?string
    {
        return $this->output_link;
    }

    public function setOutputLink(string $output_link): self
    {
        $this->output_link = $output_link;

        return $this;
    }

    public function getCreateTimestamp(): ?\DateTimeInterface
    {
        return $this->create_timestamp;
    }

    public function setCreateTimestamp(\DateTimeInterface $create_timestamp): self
    {
        $this->create_timestamp = $create_timestamp;

        return $this;
    }

    public function getExpireTimestamp(): ?\DateTimeInterface
    {
        return $this->expire_timestamp;
    }

    public function setExpireTimestamp(\DateTimeInterface $expire_timestamp): self
    {
        $this->expire_timestamp = $expire_timestamp;

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
            $user->setLink($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getLink() === $this) {
                $user->setLink(null);
            }
        }

        return $this;
    }
}
