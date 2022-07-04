<?php

namespace App\Http\Resources;

use App\Models\Item;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="ItemResource",
 *     description="Item resource",
 *     @OA\Xml(
 *         name="ItemResource"
 *     )
 * )
 */
class ItemResource extends JsonResource
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
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        return parent::toArray($request);
    }
}
