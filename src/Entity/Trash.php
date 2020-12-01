<?php

namespace MartenaSoft\Trash\Entity;

use Doctrine\ORM\Mapping as ORM;
use MartenaSoft\Common\Entity\CommonEntityInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use MartenaSoft\Trash\Repository\TrashRepository;

/** @ORM\Entity(repositoryClass=TrashRepository::class) */
class Trash implements CommonEntityInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;
    
    /** 
     * @Assert\NotBlank()
     * @ORM\Column()
     */
    private ?string $name;

    /**
     * @Assert\NotBlank()
     * @ORM\Column()
     */
    private ?string $entityClassName;

    /** @ORM\Column(type="integer") */
    private ?int $entityId;

    /** @ORM\Column(type="datetime") */
    private ?\DateTime $dateTime;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getEntityClassName(): ?string
    {
        return $this->entityClassName;
    }

    public function setEntityClassName(?string $entityClassName): self
    {
        $this->entityClassName = $entityClassName;
        return $this;
    }

    public function getEntityId(): ?int
    {
        return $this->entityId;
    }

    public function setEntityId(?int $entityId): self
    {
        $this->entityId = $entityId;
        return $this;
    }

    public function getDateTime(): ?\DateTime
    {
        return $this->dateTime;
    }

    public function setDateTime(?\DateTime $dateTime): self
    {
        $this->dateTime = $dateTime;
        return $this;
    }
}

