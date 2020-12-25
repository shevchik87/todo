<?php

declare(strict_types=1);

namespace App\UI\Http\Controller;

use App\Domain\Todo\Command\Create\TaskCreateCommand;
use App\Domain\Todo\Command\Create\TaskCreateHandler;
use App\Domain\Todo\Exception\DomainException;
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
     * @param TaskCreateHandler $handler
     * @throws DomainException
     */
    public function createTask(Request $request, TaskCreateHandler $handler)
    {
        $user = $this->getUser();
        $data = json_decode($request->getContent(), true);
        $command = new TaskCreateCommand($data['content'], $data['due_date']);

        $handler->execute($command);

    }

    public function closeTask(int $id)
    {

    }
}
