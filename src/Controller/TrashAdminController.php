<?php

namespace MartenaSoft\Trash\Controller;

use MartenaSoft\Common\Entity\CommonEntityInterface;
use MartenaSoft\Common\Event\CommonConfirmAfterSubmitEvent;
use MartenaSoft\Common\Event\CommonEventResponseInterface;
use MartenaSoft\Common\Event\CommonFormEventInterface;
use MartenaSoft\Common\Library\CommonValues;
use MartenaSoft\Crud\Controller\AbstractCrudController;
use MartenaSoft\Trash\Entity\Trash;
use MartenaSoft\Trash\Entity\TrashEntityInterface;
use MartenaSoft\Trash\Service\MoveToTrashServiceInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TrashAdminController extends AbstractCrudController
{
    public const ROLLBACK_SUCCESS_MESSAGE = 'Data rollback success';

    public function rollback(Request $request, Trash $trash): Response
    {
        $this->getEventDispatcher()->addListener(
            CommonConfirmAfterSubmitEvent::getEventName(),
            function (CommonConfirmAfterSubmitEvent $event) use ($trash) {
                if ($event->getForm()->getData()->isSafeDelete() &&
                    ($entity = $event->getEntity()) instanceof TrashEntityInterface) {
                    $entity->setIsDeleted(false);
                    try {
                        $this->getEntityManager()->remove($trash);
                        $this->getEntityManager()->flush();

                        $this->addFlash(CommonValues::FLASH_SUCCESS_TYPE, self::ROLLBACK_SUCCESS_MESSAGE);
                        if ($event instanceof CommonEventResponseInterface) {
                            $response = new RedirectResponse($this->generateUrl('admin_trash_index'));
                            $event->setResponse($response);
                        }
                    } catch (\Throwable $exception) {
                        $this->getLogger()->error(
                            CommonValues::ERROR_FORM_SAVE_LOGGER_MESSAGE,
                            [
                                'file' => __CLASS__,
                                'func' => __FUNCTION__,
                                'line' => __LINE__,
                                'message' => $exception->getMessage(),
                                'code' => $exception->getCode()
                            ]
                        );
                        $this->addFlash(
                            CommonValues::FLASH_ERROR_TYPE,
                            CommonValues::FLASH_ERROR_SYSTEM_MESSAGE
                        );
                    }
                }
        });


        return $this->confirmDelete(
            $request,
           $this
               ->getEntityManager()
               ->getRepository($trash->getEntityClassName())
               ->find($trash->getEntityId()),
            'admin_trash_index',
            [],
            [
                'title' => 'Rollback',
                'submitButton' => '<button type="submit" class="btn btn-success" onclick="">Rollback</button>'
            ]
        );

    }

    protected function getButtonRoutes(): array
    {
        $return = parent::getButtonRoutes();
        $return['routeRollback'] = 'admin_trash_rollback';
        return $return;
    }
    protected function getItemActionButtons(): string
    {
        return '@MartenaSoftTrash/admin/action_buttons_items_list.html.twig';
    }

    protected function itemsFields(): array
    {
        return ['name'];
    }

    protected function getH1(): string
    {
        return 'Trash admin';
    }

    protected function getTitle(): string
    {
        return 'Trash admin';
    }

    protected function getConfigButtonUrl(): string
    {
        return '';
    }

    protected function getCreateButtonUrl(): string
    {
        return '';
    }

    protected function deleteItem(
        CommonEntityInterface $entity,
        MoveToTrashServiceInterface $trashService,
        bool $isSafeDelete
    ): void {

    }
}
