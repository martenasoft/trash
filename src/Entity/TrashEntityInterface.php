<?php

namespace MartenaSoft\Trash\Entity;

interface TrashEntityInterface
{
    public function isDeleted(): ?bool;
    public function setIsDeleted(?bool $isDeleted): self;
}