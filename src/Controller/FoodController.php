<?php

namespace App\Controller;

use App\Entity\FruitCollection;
use App\Entity\VegetableCollection;
use App\Repository\AbstractFoodRepository;
use App\Repository\FruitCollectionRepository;
use App\Repository\VegetableCollectionRepository;
use App\Service\FoodStorageService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class FoodController extends AbstractController
{
    public function __construct(
        private VegetableCollectionRepository $vegetableCollectionRepository,
        private FruitCollectionRepository $fruitCollectionRepository
    ) {  
    }

    #[Route(
        '/food',
        name: 'show_food',
        methods: ['GET']
    )]
    public function showFood(
        Request $request
    ): JsonResponse {
        /**
         * @var null|string $name
         */
        $name = $request->query->get('name');

        /**
         * @var int $minWeight
         */
        $minWeight = (int)$request->query->get('minWeight');

        /**
         * @var int $maxWeight
         */
        $maxWeight = (int)$request->query->get('maxWeight');

        /**
         * @var null|VegetableCollection $vegetableCollection
         */
        $vegetableCollection = $this->vegetableCollectionRepository->find(1);

        /**
         * @var null|FruitCollection $fruitCollection
         */
        $fruitCollection = $this->fruitCollectionRepository->find(1);

        if (
            null == $vegetableCollection &&
            null == $fruitCollection
        ) {
            return $this->json(
                [
                    'message' => 'No data has been found.'
                ],
                Response::HTTP_NOT_FOUND
            );
        }

        $foodArray = array_merge(
            $vegetableCollection->list(
                $name,
                $minWeight,
                $maxWeight
            ),
            $fruitCollection->list(
                $name,
                $minWeight,
                $maxWeight
            )
        );

        return new JsonResponse(
            $foodArray,
            JsonResponse::HTTP_OK,
        );
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
                Response::HTTP_BAD_REQUEST
            );
        }

        // Verify if there is an existing collection
        $vegetableCollection = $this->vegetableCollectionRepository->find(1);
        $fruitCollection = $this->fruitCollectionRepository->find(1);

        $foodStorageService = new FoodStorageService($requestString);
        $foodCollections = $foodStorageService->createFoodCollections(
            $fruitCollection,
            $vegetableCollection
        );

        $em->persist($foodCollections['fruits']);
        $em->persist($foodCollections['vegetables']);
        $em->flush();

        return $this->json(
            [
                'message' => 'Fruits have been added to the database'
            ],
            Response::HTTP_CREATED
        );
    }
}
