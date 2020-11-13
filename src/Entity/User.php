<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
//use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"username"}, message="There is already an account with this username")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    
    private $password;


    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $age;

    /**
     * @ORM\Column(type="binary", nullable=true)
     */
    private $tuto_completion;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $birthdate;

    /**
     * @ORM\OneToMany(targetEntity=UserModule::class, mappedBy="id_user")
     */
    private $userModules;

    /**
     * @ORM\OneToMany(targetEntity=UserAnswer::class, mappedBy="user")
     */
    private $userAnswers;

    public function __construct()
    {
        $this->userModules = new ArrayCollection();
        $this->userAnswers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getTutoCompletion()
    {
        return $this->tuto_completion;
    }

    public function setTutoCompletion($tuto_completion): self
    {
        $this->tuto_completion = $tuto_completion;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(?\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * @return Collection|UserModule[]
     */
    public function getUserModules(): Collection
    {
        return $this->userModules;
    }

    public function addUserModule(UserModule $userModule): self
    {
        if (!$this->userModules->contains($userModule)) {
            $this->userModules[] = $userModule;
            $userModule->setIdUser($this);
        }

        return $this;
    }

    public function removeUserModule(UserModule $userModule): self
    {
        if ($this->userModules->contains($userModule)) {
            $this->userModules->removeElement($userModule);
            // set the owning side to null (unless already changed)
            if ($userModule->getIdUser() === $this) {
                $userModule->setIdUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|UserAnswer[]
     */
    public function getUserAnswers(): Collection
    {
        return $this->userAnswers;
    }

    public function addUserAnswer(UserAnswer $userAnswer): self
    {
        if (!$this->userAnswers->contains($userAnswer)) {
            $this->userAnswers[] = $userAnswer;
            $userAnswer->setUser($this);
        }

        return $this;
    }

    public function removeUserAnswer(UserAnswer $userAnswer): self
    {
        if ($this->userAnswers->contains($userAnswer)) {
            $this->userAnswers->removeElement($userAnswer);
            // set the owning side to null (unless already changed)
            if ($userAnswer->getUser() === $this) {
                $userAnswer->setUser(null);
            }
        }

        return $this;
    }
}
