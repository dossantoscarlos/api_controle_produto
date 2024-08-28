<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) : JsonResponse
    {

        if(!$request->has('fields')){
            return response()->json(Product::paginate(20, ['*'], 'page'));
        }

        $request->validate(['fields' => 'string']);

        info("fields => ",[$request->input('fields')]);

        $product = Product::paginate(5, ['*'], 'page');

        info("product => ", [$product]);

        ProductResource::collection($product);

        info("product => ", [$product]);

        return response()->json($product);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request) : Response
    {
        info("info => ",$request->all());

        $product = Product::create($request->all());

        $url = URL::route('products.show', ['product' => $product->id]);

        return response(status:Response::HTTP_CREATED, headers: [
            'Location' => $url
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Product $product) : JsonResponse
    {
        if($request->has('fields')){
            return response()->json(data:ProductResource::make($product), status: JsonResponse::HTTP_OK);
        }
        return response()->json(data:$product, status: JsonResponse::HTTP_OK);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->deleteOrFail();
        return response(status:Response::HTTP_ACCEPTED);
    }
}
