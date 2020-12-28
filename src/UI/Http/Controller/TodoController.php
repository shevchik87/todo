<?php

declare(strict_types=1);

namespace App\UI\Http\Controller;

use App\Domain\Todo\Command\Complete\TaskCompleteCommand;
use App\Domain\Todo\Command\Complete\TaskCompleteHandlerTask;
use App\Domain\Todo\Command\Create\TaskCreateCommand;
use App\Domain\Todo\Command\Create\TaskCreateHandler;
use App\Domain\Todo\Entity\TaskEntity;
use App\Domain\Todo\Exception\DomainException;
use App\Domain\Todo\Query\Task\TaskQuery;
use App\Domain\Todo\Query\Task\TaskQueryHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends BaseApiController
{
    /**
     * @Route("/api/v1/tasks", methods={"GET"})
     * @param Request $request
     * @param TaskQueryHandler $queryHandler
     * @return array|null
     * @throws DomainException
     */
    public function listTasks(Request $request, TaskQueryHandler $queryHandler)
    {
        $userId = $this->getUser()->getId();
        $query = new TaskQuery($userId);
        $query->setLimit((int) $request->get('per_page', 20))
            ->setOffset((int) $request->get('page', 0))
            ->setSpecificDate($request->get('date'));

        return $this->arrayResponse($queryHandler->execute($query), ['create']);
    }

    /**
     * @Route("/api/v1/tasks/{id}", name="get_task", methods={"GET"})
     * @param int $id
     * @return array
     */
    public function getTask(int $id)
    {
        $task = $this->findTask($id);

        $this->denyAccessUnlessGranted('view', $task);

        return $this->arrayResponse($task, ['create']);

    }

    /**
     * @Route("/api/v1/tasks", methods={"POST"})
     * @param Request $request
     * @param TaskCreateHandler $handler
     * @return array|null
     * @throws DomainException
     */
    public function createTask(Request $request, TaskCreateHandler $handler)
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
     * @return bool
     * @throws DomainException
     */
    public function completeTask(int $id, TaskCompleteHandlerTask $handler)
    {
        $task = $this->findTask($id);

        $this->denyAccessUnlessGranted('edit', $task);

        $command = new TaskCompleteCommand($id);

        $handler->execute($command);

        return true;
    }


    private function findTask(int $id)
    {
        $task = $this->getDoctrine()->getRepository(TaskEntity::class)
            ->find($id);

        if (!$task) {
            throw $this->createNotFoundException();
        }

        return $task;
    }
}
