<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *      title="Update Item request",
 *      description="Update Item request body data",
 *      type="object",
 *      required={"name"}
 * )
 */
class UpdateItemRequest extends FormRequest
{
    /**
     * @OA\Property(
     *      title="name",
     *      description="Name of the new item",
     *      example="A nice item"
     * )
     *
     * @var string
     */
    public string $name;

    /**
     * @OA\Property(
     *      title="description",
     *      description="Description of the new item",
     *      example="This is new item's description"
     * )
     *
     * @var string
     */
    public string $description;

    /**
     * @OA\Property(
     *      title="completed",
     *      description="Status of the item",
     *      example="true"
     * )
     *
     * @var boolean
     */
    public bool $completed;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    #[ArrayShape(['name' => "string", 'description' => "string", 'completed' => "string"])]
    public function rules(): array
    {
        return [
            'name' => 'required|max:80',
            'description' => 'max:750',
            'completed' => 'boolean'
        ];
    }
}
