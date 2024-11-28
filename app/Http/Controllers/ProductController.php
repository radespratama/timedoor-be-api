<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $pagination = $request->query('page') ?? 10;
            $category = $request->query('category') ?? null;
            $brand = $request->query('brand') ?? null;
            $product = $request->query('product') ?? null;

            $query = Products::query();

            if ($product) {
                $query->where('title', 'LIKE', "%$product%");
            }

            if ($category) {
                $query->whereHas('category', function ($q) use ($category) {
                    $q->where('name', $category);
                });
            }

            if ($brand) {
                $query->whereHas('brand', function ($q) use ($brand) {
                    $q->where('name', $brand);
                });
            }

            $query->with(['category', 'brand']);
            $products = $query->paginate($pagination);

            if ($products->isEmpty() && $products->currentPage() > $products->lastPage()) {
                $products = $query->paginate($pagination, ['*'], 'page', $products->lastPage());
            }

            return response()->json([
                'message' => 'Products fetched successfully',
                'status' => true,
                'data' => $products,
                'code' => 200
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while fetching products',
                'status' => false,
                'data' => null,
                'code' => 500
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:80|unique:products',
                'price' => 'required|numeric|min:1',
                'stock' => 'required|numeric|min:1',
                'images' => 'nullable|string',
                'category_id' => 'required|exists:categories,id',
                'brand_id' => 'required|exists:brands,id',
            ], [
                'title.required' => 'Judul harus diisi!',
            ]);

            Products::create($validated);

            return response()->json([
                'message' => 'Product created successfully',
                'status' => true,
                'data' => null,
                'code' => 200
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => $e->errors(),
                'status' => false,
                'data' => null,
                'code' => 422
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => false,
                'data' => null,
                'code' => 500
            ], 500);
        }
    }


    public function uploadFile(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|string'
            ]);

            $base64Image = $request->input('file');

            if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $type)) {
                $extension = strtolower($type[1]);

                $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
                if (!in_array($extension, $allowedExtensions)) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Invalid image extension. Allowed extensions: jpg, jpeg, png, webp',
                        'data' => null,
                    ], 422);
                }

                $resultCheck = substr($base64Image, strpos($base64Image, ',') + 1);
                $photos = base64_decode($resultCheck);

                if ($photos === false) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Invalid base64 image data',
                        'data' => null,
                    ], 422);
                }

                $path = 'photos/products/' . time() . '.' . $extension;
                Storage::disk('public')->put($path, $photos);

                $url = Storage::url($path);

                return response()->json([
                    'status' => true,
                    'message' => 'Image uploaded successfully',
                    'data' => [
                        'url' => $url,
                    ],
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid base64 image data',
                    'data' => null,
                ], 422);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
                'data' => null,
            ], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $product = Products::find($id);

            if (!$product) {
                return response()->json([
                    'message' => 'Product not found',
                    'status' => false,
                    'data' => null,
                    'code' => 404
                ], 404);
            }

            return response()->json([
                'message' => 'Product fetched successfully',
                'status' => true,
                'data' => $product,
                'code' => 200
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while fetching product',
                'status' => false,
                'data' => null,
                'code' => 500
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $product = Products::find($id);

            if (!$product) {
                return response()->json([
                    'message' => 'Product not found',
                    'status' => false,
                    'data' => null,
                    'code' => 404
                ], 404);
            }

            $validated = $request->validate([
                'title' => 'required|string|max:80',
                'price' => 'required|numeric',
                'stock' => 'required|numeric',
            ]);

            $product->update($validated);

            return response()->json([
                'message' => 'Product updated successfully',
                'status' => true,
                'data' => null,
                'code' => 200
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating product',
                'status' => false,
                'data' => null,
                'code' => 500
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $product = Products::find($id);

            if (!$product) {
                return response()->json([
                    'message' => 'Product not found',
                    'status' => false,
                    'data' => null,
                    'code' => 404
                ], 404);
            }

            $product->delete();

            return response()->json([
                'message' => 'Product deleted successfully',
                'status' => true,
                'data' => null,
                'code' => 200
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while deleting product',
                'status' => false,
                'data' => null,
                'code' => 500
            ], 500);
        }
    }
}
