<?php

namespace MartenaSoft\Trash\Entity;

trait InitTrashMethodsTrait
{
    private bool $isSafeDelete = false;

    public function isDeleted(): ?bool
    {
        return $this->isSafeDelete;
    }

    public function setIsDeleted(?bool $isDeleted): self
    {
        $this->isSafeDelete = $isDeleted;
        return $this;
    }
}
