<?php

namespace App\Http\Resources;

use App\Models\Item;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use JsonSerializable;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="ItemsResource",
 *     description="Items resource",
 *     @OA\Xml(
 *         name="ItemsResource"
 *     )
 * )
 */
class ItemCollection extends ResourceCollection
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var Item[]
     */
    private array $data;

    /**
     * Transform the resource collection into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        return parent::toArray($request);
    }
}
