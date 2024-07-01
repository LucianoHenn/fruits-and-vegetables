<?php

namespace App\Tests\App\Service;

use App\Collection\FruitCollection;
use App\Entity\Fruit;
use App\Service\StorageService;
use PHPUnit\Framework\TestCase;

class StorageServiceTest extends TestCase
{
    protected $storageService;

    protected function setUp(): void
    {
        $request = file_get_contents('request.json');
        $this->storageService = new StorageService($request);
    }

    public function testReceivingRequest(): void
    {
        $this->assertNotEmpty($this->storageService->getRequest());
        $this->assertIsString($this->storageService->getRequest());
    }

    public function testLoadData(): void
    {
        $this->assertTrue($this->storageService->loadData());
    }

    /**
     * Tests the basic methods of the FruitCollection class, including adding items,
     * searching for an item, removing an item, and converting the collection to an array.
     */
    public function testCollectionBasicMethods(): void
    {
        $array = [
            [
                'id' => '1',
                'name' => 'Grapes',
                'quantity' => 10,
                'unit' => 'kg'
            ],
            [
                'id' => '2',
                'name' => 'Banana',
                'quantity' => 1000,
                'unit' => 'g'
            ],
        ];

        $collection = FruitCollection::fromMap($array, function (array $data) {
            return new Fruit($data['id'], $data['name'], $data['quantity'], $data['unit']);
        });

        $banana = new Fruit(2, 'Banana', 1, 'kg');

        $found = $collection->search('name', '=', 'Banana')->list();

        $this->assertEquals(array_values($found), [$banana]);

        $collection->remove(1);

        $arrayCollection = $collection->map(fn (Fruit $f) => $f->toArray());

        $this->assertEquals($arrayCollection, [[
            'id' => 1,
            'name' => 'Grapes',
            'quantity' => 10000, 
            'unit' => 'g' // fruits are always stored in g
        ]]);
    }
}
