<?php

namespace App\Controller;

use App\Service\DummyJsonService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchAndImportController extends AbstractController
{
    private DummyJsonService $dummyJsonService;

    public function __construct(DummyJsonService $dummyJsonService)
    {
        $this->dummyJsonService = $dummyJsonService;
    }

    #[Route('/searchAndImport/{entity}', methods: ['GET'])]
    public function searchAndImportData(string $entity, Request $request, EntityManagerInterface $em): JsonResponse {

        $filter = $request->query->get('q', ''); // Фильтр

        $this->dummyJsonService->searchAndImport($entity, $filter, $em);

        return $this->json(['message' => "Импорт данных для таблицы {$entity} с фильтром '{$filter}' завершён."]);
    }
}
