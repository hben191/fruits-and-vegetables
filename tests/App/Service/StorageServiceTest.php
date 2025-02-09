<?php

namespace App\Tests\App\Service;

use App\Service\StorageService;
use PHPUnit\Framework\TestCase;

class StorageServiceTest extends TestCase
{
    public function testReceivingRequest(): void
    {
        $request = file_get_contents('request.json');

        if (!$request) {
            throw new \Exception('File does not exist.');
        }

        $storageService = new StorageService($request);

        $this->assertNotEmpty($storageService->getRequest());
        $this->assertIsString($storageService->getRequest());
    }
}
