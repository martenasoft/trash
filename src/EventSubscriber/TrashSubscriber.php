<?php


namespace MartenaSoft\Trash\EventSubscriber;

use Doctrine\ORM\EntityManagerInterface;
use MartenaSoft\Common\Event\CommonEventResponseInterface;
use MartenaSoft\Common\Event\CommonFormBeforeDeleteEvent;
use MartenaSoft\Common\Event\CommonFormEventEntityInterface;
use MartenaSoft\Trash\Entity\TrashEntityInterface;
use MartenaSoft\Trash\Service\MoveToTrashService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

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
            CommonFormBeforeDeleteEvent::getEventName() => 'onCommonFormBeforeDelete',
        ];
    }

    public function onCommonFormBeforeDelete(CommonFormEventEntityInterface $event): void
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
