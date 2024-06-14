<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\TaskRepository;

class TaskController extends AbstractController
{
    #[Route('/tasks', name: 'app_task', methods: ['GET'])]
    public function tasks(TaskRepository $taskRepository): Response
    {
        $tasks = $taskRepository->findAll();
        dd($tasks);


        return $this->render('task/index.html.twig', [
            'controller_name' => 'TaskController',
        ]);
    }
}
