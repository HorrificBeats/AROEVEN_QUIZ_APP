<?php

namespace App\Entity;

use App\Repository\SlideRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SlideRepository::class)
 */
class Slide
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=1500)
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $content_type;

    /**
     * @ORM\Column(type="integer")
     */
    private $slide_number;

    /**
     * @ORM\ManyToOne(targetEntity=Module::class, inversedBy="slides")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_module;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getContentType(): ?string
    {
        return $this->content_type;
    }

    public function setContentType(string $content_type): self
    {
        $this->content_type = $content_type;

        return $this;
    }

    public function getSlideNumber(): ?int
    {
        return $this->slide_number;
    }

    public function setSlideNumber(int $slide_number): self
    {
        $this->slide_number = $slide_number;

        return $this;
    }

    public function getIdModule(): ?Module
    {
        return $this->id_module;
    }

    public function setIdModule(?Module $id_module): self
    {
        $this->id_module = $id_module;

        return $this;
    }
}
