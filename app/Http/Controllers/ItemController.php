<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemListRequest;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Http\Resources\ItemCollection;
use App\Http\Resources\ItemResource;
use App\Models\Item;
use App\Repositories\ItemRepository;
use OpenApi\Annotations as OA;

class ItemController extends Controller
{
    private ItemRepository $repository;

    public function __construct(ItemRepository $itemRepository)
    {
        $this->repository = $itemRepository;
    }

    /**
     *
     * @OA\Get(
     *      path="/items",
     *      operationId="getItemsList",
     *      tags={"Items"},
     *      summary="Get list of items",
     *      description="Returns list of items",
     *      @OA\Parameter(
     *          name="page",
     *          description="Page number",
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="per_page",
     *          description="Number of item on page",
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="name",
     *          description="Search for name",
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="completed",
     *          description="Search for completed",
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/ItemCollection")
     *       ),
     *      @OA\Response(
     *          response=500,
     *          description="Server Error",
     *      )
     * )
     *
     * Display a listing of the resource.
     *
     * @param ItemListRequest $request
     * @return ItemCollection
     */
    public function index(ItemListRequest $request): ItemCollection
    {
        $limit = $request->has('per_page')
            ? $request->input('per_page')
            : Item::DEFAULT_PER_PAGE;

        return new ItemCollection(
            $this->repository->findAll(
                $request->input('name'),
                $request->input('completed')
            )
                ->paginate($limit)
                ->withQueryString()
        );
    }

    /**
     * @OA\Post(
     *      path="/items",
     *      operationId="storeItem",
     *      tags={"Items"},
     *      summary="Store new item",
     *      description="Returns item data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreItemRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Item")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error"
     *      )
     * )
     *
     * Store a newly created resource in storage.
     *
     * @param StoreItemRequest $request
     * @return ItemResource
     */
    public function store(StoreItemRequest $request): ItemResource
    {
        $newItem = $this->repository->create(
            $request->input('name'),
            $request->input('description')
        );

        return ItemResource::make($newItem);
    }

    /**
     * @OA\Get(
     *      path="/items/{id}",
     *      operationId="getItemById",
     *      tags={"Items"},
     *      summary="Get item information",
     *      description="Returns item data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Item id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Item")
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Item not found"
     *      )
     * )
     * Display the specified resource.
     *
     * @param Item $item
     * @return ItemResource
     */
    public function show(Item $item): ItemResource
    {
        return ItemResource::make($item);
    }

    /**
     * @OA\Put(
     *      path="/items/{id}",
     *      operationId="updateItem",
     *      tags={"Items"},
     *      summary="Update existing item",
     *      description="Returns updated item data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Item id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UpdateItemRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Item")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Item not found"
     *      )
     * )
     * Update the specified resource in storage.
     *
     * @param UpdateItemRequest $request
     * @param Item $item
     * @return ItemResource
     */
    public function update(UpdateItemRequest $request, Item $item): ItemResource
    {
        $updatedItem = $this->repository->update(
            $item,
            $request->input('name'),
            $request->input('description'),
            $request->input('completed') ?? false
        );

        return ItemResource::make($updatedItem);
    }

    /**
     * @OA\Delete(
     *      path="/items/{id}",
     *      operationId="deleteItem",
     *      tags={"Items"},
     *      summary="Delete existing item",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="Project id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Item not found"
     *      )
     * )
     * Remove the specified resource from storage.
     *
     * @param Item $item
     */
    public function destroy(Item $item)
    {
        $item->delete();
    }
}
