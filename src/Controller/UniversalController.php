<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
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

    #[Route('/{table}', methods: ['POST'])]
    public function add(string $table, Request $request, EntityManagerInterface $em, SerializerInterface $serializer): JsonResponse
    {

        $databaseTable = [
            'products' => \App\Entity\Product::class,
            'recipes' => \App\Entity\Recipe::class,
            'posts' => \App\Entity\Post::class,
            'users' => \App\Entity\User::class,
        ];

        
        if (!isset($databaseTable[$table])) {
            return $this->json(['error' => 'Неизвестная таблица'], 400);
        }

        // класс сущности из маппинга
        $entityClass = $databaseTable[$table];

        // Преоброзование данных из запроса в сущность
        $data = $request->getContent();
        $entityObject = $serializer->deserialize($data, $entityClass, 'json');

        $em->persist($entityObject);
        $em->flush();

        return $this->json(['message' => "{$table} добавлен успешно"]);
    }
}
