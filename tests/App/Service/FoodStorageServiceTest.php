<?php

namespace App\Tests\App\Service;

use App\Entity\Fruit;
use App\Entity\FruitCollection;
use App\Entity\Vegetable;
use App\Entity\VegetableCollection;
use App\Service\FoodStorageService;
use PHPUnit\Framework\TestCase;

class FoodStorageServiceTest extends TestCase
{
    public function testCreateFoodCollections(): void
    {
        $foodStorageServiceMock = $this->getMockBuilder(FoodStorageService::class)
                    ->setConstructorArgs(['mockString'])
                    ->onlyMethods(['getRequest'])
                    ->getMock();
        
        $testVegetableArray = [
            [
                "id" => 1,
                "name" => "Carrot",
                "type" => "vegetable",
                "quantity" => 10922,
                "unit" => "g"
            ],
            [
                "id" => 13,
                "name" => "Cucumber",
                "type" => "vegetable",
                "quantity" => 8,
                "unit" => "kg"
            ],
            [
                "id" => 12,
                "name" => "Onion",
                "type" => "vegetable",
                "quantity" => 50,
                "unit" => "kg"
            ]
        ];

        $testFruitArray = [
            [
                "id" => 2,
                "name" => "Apples",
                "type" => "fruit",
                "quantity" => 20,
                "unit" => "kg"
            ],
            [
                "id" => 14,
                "name" => "Bananas",
                "type" => "fruit",
                "quantity" => 100,
                "unit" => "kg"
            ]
        ];

        $testFoodArray = array_merge($testFruitArray, $testVegetableArray);
        
        $jsonRequestMock = json_encode($testFoodArray);

        $foodStorageServiceMock->method('getRequest')
                            ->willReturn($jsonRequestMock);
        
        /**
         * @var FoodStorageService $foodStorageServiceMock
         */
        $result = $foodStorageServiceMock->createFoodCollections(); // @phpstan-ignore-line 

        $fruitCollectionComparison = new FruitCollection();
        foreach ($testFruitArray as $testFruit) {
            $fruit = new Fruit();
            $fruit->setName($testFruit['name'])
                ->setQuantity($testFruit['quantity'])
                ->setUnit($testFruit['unit']);
            $fruitCollectionComparison->add($fruit);
        }

        $vegetableCollectionComparison = new VegetableCollection();
        foreach ($testVegetableArray as $testVegetable) {
            $vegetable = new Vegetable();
            $vegetable->setName($testVegetable['name'])
                ->setQuantity($testVegetable['quantity'])
                ->setUnit($testVegetable['unit']);
            $vegetableCollectionComparison->add($vegetable);
        }

        // Assert the result has the correct structure
        $this->assertArrayHasKey('fruits', $result);
        $this->assertArrayHasKey('vegetables', $result);

        // And now assert they have the same collections
        $this->assertEquals($fruitCollectionComparison, $result['fruits']);

        // Assert the vegetables collection matches
        $this->assertEquals($vegetableCollectionComparison, $result['vegetables']);
    }
}
