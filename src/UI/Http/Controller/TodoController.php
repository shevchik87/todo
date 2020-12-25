<?php

declare(strict_types=1);

namespace App\UI\Http\Controller;

use App\Domain\Todo\Command\Create\TaskCreateCommand;
use App\Domain\Todo\Command\Create\TaskCreateHandler;
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


        return $this->json($this->arrayResponse($task));

    }

    /**
     * @Route("/api/v1/tasks", methods={"POST"})
     * @param Request $request
     * @param TaskCreateHandler $handler
     * @throws DomainException
     */
    public function createTask(Request $request, TaskCreateHandler $handler)
    {
        $userId = $this->getUser()->getId();
        $data = json_decode($request->getContent(), true);
        $command = new TaskCreateCommand($userId, $data['content'], $data['due_date']);

        $handler->execute($command);

        $url = $this->generateUrl("get_task", ['id' => 1], UrlGeneratorInterface::ABSOLUTE_URL);
        return $this->json(null, Response::HTTP_CREATED, ["Location" => $url]);

    }

    public function closeTask(int $id)
    {

    }
}
