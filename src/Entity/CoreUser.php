<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: \App\Repository\CoreUserRepository::class)]
#[ORM\Index(columns: ['login'], name: 'idx_login')]
#[ORM\Index(columns: ['state'], name: 'idx_state')]
#[ORM\Index(columns: ['date_created'], name: 'idx_date_created')]
class CoreUser implements UserInterface, PasswordAuthenticatedUserInterface
{
    const STATE_OFF = 0, STATE_ON = 1;

    const IS_DELETED_YES = true, IS_DELETED_NO = false;

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 64)]
    private $login;

    #[ORM\Column(type: 'string', length: 255)]
    private $password;

    #[ORM\Column(type: 'smallint')]
    private $state;

    #[ORM\Column(type: 'datetimetz')]
    private $date_created;

    #[ORM\Column(type: 'datetimetz')]
    private $date_updated;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $email;

    #[ORM\Column(type: 'boolean')]
    private $is_deleted;

    #[ORM\ManyToMany(targetEntity: CoreUserRole::class, orphanRemoval: true)]
    private $roles;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->login;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string)$this->login;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = [];

        foreach ($this->roles->getIterator() as $role) {
            if ($role->isStateOn()) {
                $roles[] = $role->getSymfonyRole();
            }
        }
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

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

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->date_created;
    }

    public function setDateCreated(\DateTimeInterface $date_created): self
    {
        $this->date_created = $date_created;

        return $this;
    }

    public function getDateUpdated(): ?\DateTimeInterface
    {
        return $this->date_updated;
    }

    public function setDateUpdated(\DateTimeInterface $date_updated): self
    {
        $this->date_updated = $date_updated;

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

    public function getIsDeleted(): ?bool
    {
        return $this->is_deleted;
    }

    public function setIsDeleted(bool $is_deleted): self
    {
        $this->is_deleted = $is_deleted;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function addRole(CoreUserRole $role): self
    {
        if (!$this->roles->contains($role)) {
            $this->roles[] = $role;
        }

        return $this;
    }

    public function removeRole(CoreUserRole $role): self
    {
        $this->roles->removeElement($role);

        return $this;
    }
}
