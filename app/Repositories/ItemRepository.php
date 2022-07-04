<?php

namespace App\Repositories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Builder;

class ItemRepository
{
    public function findAll(string $name = null, string $completed = null): Builder
    {
        $items = Item::query();

        if (!is_null($name)) {
            $items->where('name', 'like', "%$name%");
        }

        if (!is_null($completed)) {
            $items->where('completed', $completed);
        }

        return $items;
    }

    public function create(string $name, string $description = null): Item
    {
        $item = new Item();
        $item->fill([
            'name' => $name,
            'description' => $description
        ]);

        $item->save();

        return $item->refresh();
    }

    public function update(Item $existsItem, string $name, string $description = null, bool $completed = false): Item
    {
        $existsItem->fill([
            'name' => $name,
            'description' => $description,
            'completed' => $completed
        ]);

        $existsItem->save();

        return $existsItem->refresh();
    }
}
