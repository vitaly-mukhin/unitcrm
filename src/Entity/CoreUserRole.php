<?php

namespace App\Entity;

use App\Repository\CoreUserRoleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CoreUserRoleRepository::class)]
class CoreUserRole
{
    const ROLE_USER = 0,
        ROLE_ADMIN = 1;

    const STATE_OFF = 0,
        STATE_ON = 1;

    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\Column(type: 'smallint')]
    private $state;

    public function getSymfonyRole(): string
    {
        return [
                   self::ROLE_USER  => 'ROLE_USER',
                   self::ROLE_ADMIN => 'ROLE_ADMIN',
               ][$this->id];
    }

    public function isStateOn(): bool
    {
        return $this->getState() === self::STATE_ON;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getState(): ?int
    {
        return $this->state;
    }

    public function setState(int $state): self
    {
        $this->state = $state;

        return $this;
    }
}
