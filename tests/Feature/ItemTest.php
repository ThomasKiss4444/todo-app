<?php

namespace Tests\Feature;

use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemTest extends TestCase
{
    use RefreshDatabase;

    private const BASE_URI = '/items';

    /** @test */
    public function should_return_first_page_items()
    {
        Item::factory()->count(44)->create();

        $response = $this->get(route('items.index'));

        $response->assertStatus(200);

        $response->assertJsonCount(25, 'data');
        $this->assertEquals(44, $response->json('meta.total'));
    }

    /** @test */
    public function should_return_last_page_items()
    {
        Item::factory()->count(44)->create();

        $response = $this->get(route('items.index', [ 'page' => 2]));

        $response->assertStatus(200);

        $response->assertJsonCount(19, 'data');
        $this->assertEquals(44, $response->json('meta.total'));
    }

    /** @test */
    public function should_create_an_item()
    {
        $itemData = [
            'name' => 'List item',
            'description' => 'List item description'
        ];

        $response = $this->post(
            route('items.store'),
            $itemData
        );

        $response->assertStatus(201);
        $this->assertEquals($itemData['name'], $response->json('data.name'));
        $this->assertEquals($itemData['description'], $response->json('data.description'));
        $this->assertEquals(0, $response->json('data.completed'));
    }

    /** @test */
    public function should_update_an_item()
    {
        $itemData = [
            'name' => 'List item',
            'description' => 'List item description'
        ];

        $item = Item::factory()->state($itemData)->create();

        $itemData['name'] = 'List item updated';

        $response = $this->put(
            route('items.update', [ 'item' => $item->getKey() ]),
            $itemData
        );

        $response->assertStatus(200);
        $this->assertEquals($itemData['name'], $response->json('data.name'));
        $this->assertEquals($itemData['description'], $response->json('data.description'));
        $this->assertEquals(0, $response->json('data.completed'));
    }

    /** @test */
    public function should_show_an_item()
    {
        $itemData = [
            'name' => 'List item',
            'description' => 'List item description'
        ];

        $item = Item::factory()->state($itemData)->create();

        $response = $this->get(route('items.show', [ 'item' => $item->getKey() ]));

        $response->assertStatus(200);
        $this->assertEquals($itemData['name'], $response->json('data.name'));
        $this->assertEquals($itemData['description'], $response->json('data.description'));
        $this->assertEquals(0, $response->json('data.completed'));
    }

    /** @test */
    public function should_delete_an_item()
    {
        $itemData = [
            'name' => 'List item',
            'description' => 'List item description'
        ];

        $item = Item::factory()->state($itemData)->create();

        $response = $this->delete(route('items.destroy', [ 'item' => $item->getKey() ]));

        $response->assertStatus(200);
        $this->assertDatabaseMissing('items', $itemData);
    }
}
