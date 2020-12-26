<?php

declare(strict_types=1);

namespace App\UI\Http\Controller;

use App\Domain\Todo\Command\Complete\TaskCompleteCommand;
use App\Domain\Todo\Command\Complete\TaskCompleteHandlerTask;
use App\Domain\Todo\Command\Create\TaskCreateCommand;
use App\Domain\Todo\Command\Create\TaskCreateHandlerTask;
use App\Domain\Todo\Entity\TaskEntity;
use App\Domain\Todo\Exception\DomainException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class TodoController extends BaseApiController
{
    /**
     * @Route("/api/v1/tasks", methods={"GET"})
     */
    public function listTasks()
    {
        return new JsonResponse("yes");
    }

    /**
     * @Route("/api/v1/tasks/{id}", name="get_task", methods={"GET"})
     * @param int $id
     */
    public function getTask(int $id)
    {
        $task = $this->getDoctrine()->getRepository(TaskEntity::class)
            ->find($id);

        if (!$task) {
            return $this->json("", Response::HTTP_NOT_FOUND);
        }

        $this->denyAccessUnlessGranted('view', $task);

        return $this->json($this->arrayResponse($task));

    }

    /**
     * @Route("/api/v1/tasks", methods={"POST"})
     * @param Request $request
     * @param TaskCreateHandlerTask $handler
     * @throws DomainException
     */
    public function createTask(Request $request, TaskCreateHandlerTask $handler)
    {
        $userId = $this->getUser()->getId();
        $data = json_decode($request->getContent(), true);
        $command = new TaskCreateCommand($userId, $data['content'], $data['due_date'] ?? null);

        $task = $handler->execute($command);

        return $this->arrayResponse($task, ['create']);
    }

    /**
     * @Route("/api/v1/tasks/{id}/complete", methods={"PATCH"})
     * @param int $id
     * @param TaskCompleteHandlerTask $handler
     * @return JsonResponse
     * @throws DomainException
     */
    public function completeTask(int $id, TaskCompleteHandlerTask $handler)
    {
        $task = $this->findTask($id);

        $this->denyAccessUnlessGranted('edit', $task);

        $command = new TaskCompleteCommand($id);

        $handler->execute($command);

        return new JsonResponse(null);
    }


    private function findTask(int $id)
    {
        $task = $this->getDoctrine()->getRepository(TaskEntity::class)
            ->find($id);

        if (!$task) {
            $this->createNotFoundException();
        }

        return $task;
    }
}
