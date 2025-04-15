<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UniversalController extends AbstractController
{
    #[Route('/{tableName}', methods: ['GET'])]
    public function getTableRecords(string $tableName, EntityManagerInterface $em): JsonResponse
    {

        $databaseTables = [
            'products' => \App\Entity\Product::class,
            'recipes' => \App\Entity\Recipe::class,
            'posts' => \App\Entity\Post::class,
            'users' => \App\Entity\User::class,
        ];

        
        if (!array_key_exists($tableName, $databaseTables)) {
            return $this->json(['error' => 'Таблицы '.$tableName.' не существует в базе данных'], 404);
        }

        
        $databaseTable = $databaseTables[$tableName];
        $records = $em->getRepository($databaseTable)->findAll();

        return $this->json($records);
    }
}
