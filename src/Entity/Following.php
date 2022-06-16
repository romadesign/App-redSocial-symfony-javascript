<?php

namespace App\Entity;

use App\Repository\FollowingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FollowingRepository::class)
 */
class Following
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    //* @ORM\ManyToOne(targetEntity=User::class, inversedBy="followings", cascade={"all"}, fetch="EAGER")
    // cascade={"persist"}  <- delete solo un dato de la tabla y no en cascade

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="followings", cascade={"persist"})
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="followings", cascade={"persist"})
     */
    private $followed;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getFollowed(): ?User
    {
        return $this->followed;
    }

    public function setFollowed(?User $followed): self
    {
        $this->followed = $followed;

        return $this;
    }
}
