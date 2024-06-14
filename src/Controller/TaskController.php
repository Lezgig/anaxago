<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Task;
use App\Repository\TaskRepository;

class TaskController extends AbstractController
{
    #[Route('/tasks', name: 'app_task', methods: ['GET'])]
    public function tasks(TaskRepository $taskRepository): Response
    {
        $tasks = $taskRepository->findAll();

        return $this->render('task/index.html.twig', [
            'controller_name' => 'TaskController',
        ]);
    }

    #[Route('/tasks/{id}', name: 'app_task_show', methods: ['GET'])]
    public function show(TaskRepository $taskRepository, int $id): Response
    {
        $task = $taskRepository->find($id);

        return $this->render('task/show.html.twig', [
            'task' => $task,
        ]);
    }

    #[Route('/tasks/{id}', name: 'app_task_delete', methods: ['DELETE'])]
    public function delete(TaskRepository $taskRepository, int $id, EntityManagerInterface $entityManager): Response
    {
        $task = $taskRepository->find($id);

        $entityManager->remove($task);
        $entityManager->flush();

        return $this->redirectToRoute('app_task');
    }

    #[Route('/tasks/{id}', name: 'app_task_update', methods: ['PUT'])]
    public function update(TaskRepository $taskRepository, int $id, EntityManagerInterface $entityManager): Response
    {
        $task = $taskRepository->find($id);

        $entityManager->persist($task);
        $entityManager->flush();

        return $this->redirectToRoute('app_task_show', ['id' => $task->getId()]);
    }

    #[Route('/tasks', name: 'app_task_create', methods: ['POST'])]
    public function create(EntityManagerInterface $entityManager): Response
    {
        $task = new Task();
        $task->setTitle('New Task');
        $task->setDescription('Description of the new task');

        $entityManager->persist($task);
        $entityManager->flush();

        return $this->redirectToRoute('app_task_show', ['id' => $task->getId()]);
    }

}
