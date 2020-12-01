<?php

namespace MartenaSoft\Trash\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class TrashController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('@MartenaSoftTrash/trash/index.html.twig');
    }

}