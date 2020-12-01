<?php

namespace MartenaSoft\Trash\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use MartenaSoft\Trash\Repository\TrashRepository;

/**
 * @ORM\Entity(repositoryClass=TrashRepository::class)
 * @UniqueEntity(
 *     fields={"name"}
 * )
 */
class Trash
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;
    
    /** 
     * @Assert\NotBlank()
     * @@ORM\Column() 
     */
    private ?string $name;
}

