<?php

namespace MartenaSoft\Trash\Service;

use MartenaSoft\Trash\Entity\TrashEntityInterface;

interface MoveToTrashServiceInterface
{
    public function move(TrashEntityInterface $entity): void;
    public function returnFormTrash(TrashEntityInterface $entity): void;
}