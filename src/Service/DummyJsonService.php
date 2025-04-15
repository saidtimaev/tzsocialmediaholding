<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Doctrine\ORM\EntityManagerInterface;

class DummyJsonService
{
    private HttpClientInterface $client;

    // Маппинг имя сущности => класс сущности
    private array $entities = [
        'products' => \App\Entity\Product::class,
        'recipes' => \App\Entity\Recipe::class,
        'posts' => \App\Entity\Post::class,
        'users' => \App\Entity\User::class,
    ];

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function searchAndImport(string $entityName, string $searchFilter, EntityManagerInterface $em): void
    {
       
        // Получаем класс сущности
        $entityClass = $this->entities[$entityName];

        // Делаем запрос к API
        $url = "https://dummyjson.com/{$entityName}/search?q=" . urlencode($searchFilter);
        $response = $this->client->request('GET', $url);
        $data = $response->toArray();

        // Импорт данных в БД
        foreach ($data[$entityName] ?? [] as $record) {

            $entity = new $entityClass();

            foreach ($record as $field => $value) {
                // Если setter существует
                $setMethod = 'set' . ucfirst($field);
                if (method_exists($entity, $setMethod)) {
                    $entity->$setMethod($value);
                }
            }

            $em->persist($entity);
        }

        $em->flush();
    }
}