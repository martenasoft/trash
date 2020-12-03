<?php

namespace MartenaSoft\Trash\EventSubscriber;

use MartenaSoft\Common\Event\CommonEventResponseInterface;
use MartenaSoft\Common\Event\CommonFormEventEntityInterface;
use MartenaSoft\Crud\Event\CrudAfterFindEvent;
use MartenaSoft\Crud\Event\CrudBeforeDeleteEvent;
use MartenaSoft\Trash\Entity\TrashEntityInterface;
use MartenaSoft\Trash\Service\MoveToTrashService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TrashSubscriber implements EventSubscriberInterface
{
    private MoveToTrashService $trashService;

    public function __construct(MoveToTrashService $trashService)
    {
        $this->trashService = $trashService;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            CrudBeforeDeleteEvent::getEventName() => 'onCrudBeforeDelete',
            CrudAfterFindEvent::getEventName() => 'onClearEntityIsDeleted'
        ];
    }

    public function onClearEntityIsDeleted(CommonFormEventEntityInterface $event): void
    {
        $entity = $event->getEntity();
        if ($entity instanceof TrashEntityInterface && $entity->isDeleted()) {
            throw new NotFoundHttpException();
        }
    }

    public function onCrudBeforeDelete(CommonFormEventEntityInterface $event): void
    {
        $entity = $this->getEntity($event);
        $this->trashService->move($entity);

        if ($event instanceof CommonEventResponseInterface && !empty(($returnUrl = $event->getRedirectUrl()))) {
            $response = new RedirectResponse($returnUrl);
            $event->setResponse($response);
        }
    }

    private function getEntity(CommonFormEventEntityInterface $event): TrashEntityInterface
    {
        return $event->getEntity();
    }
}
