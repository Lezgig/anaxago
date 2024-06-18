<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Task;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class TaskController extends AbstractController
{
    #[Route('/tasks', name: 'app_task', methods: ['GET'])]
    public function tasks(
        TaskRepository $taskRepository,
        UserRepository $userRepository,
        #[MapQueryParameter] int $page = 1,        
        ): Response
    {
        
        $tasks = $taskRepository->findAll();

        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function (object $object, string $format, array $context): string {
                return $object->getTitle();
            },
        ];

        $encoders = [new JsonEncoder()];
        $normalizer = [new ObjectNormalizer(null, null, null, null, null, null, $defaultContext)];
        $serializer = new Serializer($normalizer, $encoders);
        $jsonContent = $serializer->serialize($tasks, 'json' );
        return new JsonResponse($jsonContent, 200, [], true);
    }

    #[Route('/tasks/{id}', name: 'app_task_show', methods: ['GET'])]
    public function show(TaskRepository $taskRepository, int $id): Response
    {
        $task = $taskRepository->find($id);

        if(!$task) {
            $response = new Response();
            $response->setStatusCode(200);
            $response->setContent('Task not found');
            return $response;
        }

        $response = new Response();
        $response->setStatusCode(200);
        $response->setContent('Task updated successfully');
        return $response;
    }

    #[Route('/tasks/{id}', name: 'app_task_delete', methods: ['DELETE'])]
    public function delete(TaskRepository $taskRepository, int $id, EntityManagerInterface $entityManager): Response
    {
        $task = $taskRepository->find($id);
        $response = new Response();

        if(!$task) {
            $response->setStatusCode(200);
            $response->setContent('Task not found');
            return $response;
        }

        $entityManager->remove($task);
        $entityManager->flush();

        $response->setStatusCode(200);
        $response->setContent('Task updated successfully');
        return $response;
    }

    #[Route('/tasks/{id}', name: 'app_task_update', methods: ['PUT'])]
    public function update( Request $request, TaskRepository $taskRepository,int $id, EntityManagerInterface $entityManager): Response
    {
        
        $incomingTask = json_decode($request->getContent());

        $task = $taskRepository->find($id);
        if(!$task) {
            $response = new Response();
            $response->setStatusCode(200);
            $response->setContent('Task not found');
            return $response;
        }
        $task->setTitle($incomingTask->title);
        $task->setDescription($incomingTask->description);
        $task->setStatus($incomingTask->status);
        $task->setCreatedAt(new \DateTimeImmutable($incomingTask->createdAt));

        $entityManager->persist($task);
        $entityManager->flush();

        $response = new Response();
        $response->setStatusCode(200);
        $response->setContent('Task updated successfully');
        return $response;

    }

    #[Route('/tasks', name: 'app_task_create', methods: ['POST'])]
    public function create(EntityManagerInterface $entityManager, Request $request): Response
    {

        $incomingTask = json_decode($request->getContent());
        $task = new Task();

        $task->setTitle($incomingTask->title);
        $task->setDescription($incomingTask->description);
        $task->setStatus($incomingTask->status);
        $task->setCreatedAt(new \DateTimeImmutable($incomingTask->createdAt));

        $entityManager->persist($task);
        $entityManager->flush();

        $response = new Response();
        $response->setStatusCode(200);
        $response->setContent('Task updated successfully');
        return $response;
    }

}
