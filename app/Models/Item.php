<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Item",
 *     description="Item model",
 *     @OA\Xml(
 *         name="Item"
 *     )
 * )
 */
class Item extends Model
{
    use HasFactory;

    const DEFAULT_PER_PAGE = 25;

    protected $fillable = [
        'name',
        'description',
        'completed'
    ];

    /**
     * @OA\Property(
     *     title="ID",
     *     description="ID",
     *     example=1
     * )
     *
     * @var integer
     */
    private int $id;

    /**
     * @OA\Property(
     *      title="Name",
     *      description="Name of the new item",
     *      example="A nice item"
     * )
     *
     * @var string
     */
    public string $name;

    /**
     * @OA\Property(
     *      title="Description",
     *      description="Description of the new item",
     *      example="This is new item's description"
     * )
     *
     * @var string
     */
    public string $description;

    /**
     * @OA\Property(
     *     title="Created at",
     *     description="Created at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var DateTime
     */
    private DateTime $created_at;

    /**
     * @OA\Property(
     *     title="Updated at",
     *     description="Updated at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var DateTime
     */
    private DateTime $updated_at;

    /**
     * @OA\Property(
     *     title="Deleted at",
     *     description="Deleted at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var DateTime
     */
    private DateTime $deleted_at;
}
