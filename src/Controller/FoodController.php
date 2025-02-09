<?php

namespace App\Controller;

use App\Repository\AbstractFoodRepository;
use App\Service\FoodStorageService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class FoodController extends AbstractController
{
    #[Route(
        '/food',
        name: 'show_food',
        methods: ['GET']
    )]
    public function showFood(
        AbstractFoodRepository $abstractFoodRepository
    ): JsonResponse {
        $foodArray = $abstractFoodRepository->findAll();

        return $this->json([
            $foodArray
        ]);
    }

    #[Route(
        '/food',
        name: 'create_food',
        methods: ['POST']
    )]
    public function createFood(
        Request $request,
        EntityManagerInterface $em
    ): JsonResponse {
        /**
         * @var null|string $requestString
         */
        $requestString = $request->getContent();

        if (
            null === $requestString ||
            '' === trim($requestString)
        ) {
            return $this->json(
                [
                    'message' => 'No data has been added.'
                ],
                Response::HTTP_NO_CONTENT
            );
        }

        $foodStorageService = new FoodStorageService($requestString);
        $foodArray = $foodStorageService->createFoodCollections();

        return $this->json([
            $foodArray
        ]);
    }
}
