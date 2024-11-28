<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $brands = Brand::all();

            if ($brands->isEmpty()) {
                return response()->json([
                    'code' => 404,
                    'data' => [],
                    'status' => false,
                    'message' => 'Data not found',
                ], 404);
            }

            return response()->json([
                'code' => 200,
                'data' => $brands,
                'status' => true,
                'message' => 'Data fetched successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'data' => [],
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:80',
                'description' => 'nullable|string',
                'image' => 'nullable|string',
                'address' => 'nullable|string',
            ]);

            Brand::create($validatedData);

            return response()->json([
                'code' => 201,
                'data' => null,
                'status' => true,
                'message' => 'Data created successfully',
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'code' => 422,
                'data' => [],
                'status' => false,
                'message' => $e->getMessage(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'data' => [],
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $brandId)
    {
        try {
            $brand = Brand::find($brandId);

            if (!$brand) {
                return response()->json([
                    'code' => 404,
                    'data' => [],
                    'status' => false,
                    'message' => 'Data not found',
                ], 404);
            }

            return response()->json([
                'code' => 200,
                'data' => $brand,
                'status' => true,
                'message' => 'Data fetched successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'data' => [],
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $brandId)
    {
        try {
            $brand = Brand::find($brandId);

            if (!$brand) {
                return response()->json([
                    'code' => 404,
                    'data' => [],
                    'status' => false,
                    'message' => 'Data not found',
                ], 404);
            }

            $validatedData = $request->validate([
                'name' => 'required|string|max:80',
                'description' => 'nullable|string',
                'image' => 'nullable|string',
                'address' => 'nullable|string',
            ]);

            $brand->update($validatedData);

            return response()->json([
                'code' => 200,
                'data' => null,
                'status' => true,
                'message' => 'Data updated successfully',
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'code' => 422,
                'data' => [],
                'status' => false,
                'message' => $e->getMessage(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'data' => [],
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $brandId)
    {
        try {
            $brand = Brand::find($brandId);

            if (!$brand) {
                return response()->json([
                    'code' => 404,
                    'data' => [],
                    'status' => false,
                    'message' => 'Data not found',
                ], 404);
            }

            $brand->delete();

            return response()->json([
                'code' => 200,
                'data' => null,
                'status' => true,
                'message' => 'Data deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'data' => [],
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
