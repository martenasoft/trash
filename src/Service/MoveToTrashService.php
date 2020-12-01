<?php

namespace MartenaSoft\Trash\Service;

use Doctrine\ORM\EntityManagerInterface;
use MartenaSoft\Trash\Entity\Trash;
use MartenaSoft\Trash\Entity\TrashEntityInterface;

class MoveToTrashService implements MoveToTrashServiceInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function move(TrashEntityInterface $entity): void
    {
        $trashEntity = new Trash();
        $name = "item_".$entity->getId();
        if (method_exists($entity, 'getName')) {
            $name = $entity->getName();
        }
        $trashEntity->setName($name);
        $trashEntity->setEntityClassName(get_class($entity));
        $trashEntity->setDateTime(new \DateTime('now'));
        $trashEntity->setEntityId($entity->getId());
        $entity->setIsDeleted(true);
        $this->entityManager->persist($trashEntity);
        $this->entityManager->flush();
    }

    public function returnFormTrash(TrashEntityInterface $entity): void
    {

    }
}
