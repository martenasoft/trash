<?php

namespace MartenaSoft\Trash\Entity;

use  Doctrine\ORM\Mapping as ORM;
use MartenaSoft\Common\Library\CommonValues;
use Symfony\Component\Validator\Constraint as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use MartenaSoft\Trash\Repository\TrashConfigRepository;

/**
 * @ORM\Entity(repositoryClass="TrashConfigRepository")
 * @UniqueEntity (
 *     fields={"name"}
 * )
 */
class TrashConfig
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */

    private ?int $id = null;

}