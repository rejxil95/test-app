<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ActionLog;
use App\Http\Resources\ProductResource;


class ProductController extends Controller
{
    // GET /api/products - List all products
    public function index()
    {
        // Return all products from the database
        return ProductResource::collection(Product::paginate(10));
    }

    // GET /api/products/{id} - Show a single product by ID
    public function show($id)
    {
        // Find the product by ID or throw a 404 error if not found
        $product = Product::findOrFail($id);
        return new ProductResource($product);
    }

    // POST /api/products - Create a new product
    public function store(Request $request)
    {
        try {
            // Validate the incoming request data
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric',
                'stock' => 'required|integer',
                'description' => 'nullable|string',
            ]);

            // Create the product using validated data
            $product = Product::create($validated);

            // Log the creation action in the action_logs table
            ActionLog::create([
                'action' => 'create',
                'table' => 'products',
                'table_id' => $product->id,
                // 'created_by' => auth()->id(), // Uncomment if using authentication
            ]);

            // Return the newly created product with a 201 Created response
            return (new ProductResource($product))
            ->response()
            ->setStatusCode(201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Return validation errors with a 422 Unprocessable Entity response
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        }
    }

    // PUT/PATCH /api/products/{id} - Update an existing product
    public function update(Request $request, Product $product)
    {
        try {
            // Validate the incoming update data
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric',
                'stock' => 'required|integer',
                'description' => 'nullable|string',
            ]);

            // Update the product with validated data
            $product->update($validated);

            // Log the update action in the action_logs table
            ActionLog::create([
                'action' => 'update',
                'table' => 'products',
                'table_id' => $product->id,
                // 'created_by' => auth()->id(), // Uncomment if using authentication
            ]);

            // Return the updated product with a 200 OK response
            return new ProductResource($product);

        } catch (\Exception $e) {
            // Return a 500 Internal Server Error if update fails
            return response()->json([
                'message' => 'Failed to update product.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // DELETE /api/products/{id} - Delete a product
    public function destroy(Product $product)
    {
        try {
            // Store the product ID before deletion
            $id = $product->id;

            // Delete the product
            $product->delete();

            // Log the delete action in the action_logs table
            ActionLog::create([
                'action' => 'delete',
                'table' => 'products',
                'table_id' => $id,
                // 'created_by' => auth()->id(), // Uncomment if using authentication
            ]);

            // Return success response
            return response()->json([
                'message' => 'Product deleted successfully.'
            ], 200);

        } catch (\Exception $e) {
            // Return a 500 Internal Server Error if deletion fails
            return response()->json([
                'message' => 'Failed to delete product.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
