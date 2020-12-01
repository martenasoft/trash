<?php

namespace MartenaSoft\Trash\Controller;

use MartenaSoft\Common\Entity\CommonEntityInterface;
use MartenaSoft\Crud\Controller\AbstractCrudController;
use MartenaSoft\Trash\Entity\Trash;
use MartenaSoft\Trash\Service\MoveToTrashServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TrashAdminController extends AbstractCrudController
{
    public function rollback(Request $request, Trash $trash): Response
    {
        $entityClassName = $trash->getEntityClassName();
        $entity = new $entityClassName();



        return $this->confirmDelete(
            $request,
            $trash,
            'admin_trash_index',
            [],
            [
                'title' => 'Rollback',
                'submitButton' => '<button type="submit" class="btn btn-success" onclick="">Rollback</button>'
            ]
        );
       // return $this->render('@MartenaSoftTrash/admin/rollback.html.twig');
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
