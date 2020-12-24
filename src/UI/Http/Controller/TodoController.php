<?php

declare(strict_types=1);

namespace App\UI\Http\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractController
{
    /**
     * @Route("/api/v1/tasks", methods={"GET"})
     */
    public function listTasks()
    {
        return new JsonResponse("yes");
    }

    /**
     * @Route("/api/v1/tasks", methods={"POST"})
     * @param Request $request
     */
    public function createTask(Request $request)
    {

    }

    public function closeTask(int $id)
    {

    }
}
