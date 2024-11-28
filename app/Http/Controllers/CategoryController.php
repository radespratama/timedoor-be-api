<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $categories = Categories::all();

            if ($categories->isEmpty()) {
                return response()->json([
                    'message' => 'No categories found',
                    'status' => false,
                    'data' => null,
                    'code' => 404
                ], 404);
            }

            return response()->json([
                'message' => 'Categories fetched successfully',
                'status' => true,
                'data' => $categories,
                'code' => 200
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while fetching categories',
                'status' => false,
                'data' => null,
                'code' => 500
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:80|unique:categories',
            ], [
                'name.required' => 'Nama harus diisi!',
            ]);

            Categories::create($validated);

            return response()->json([
                'message' => 'Category created successfully',
                'status' => true,
                'data' => null,
                'code' => 201
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => $e->errors(),
                'status' => false,
                'data' => null,
                'code' => 422
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while creating category',
                'status' => false,
                'data' => null,
                'code' => 500
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        try {
            $category = Categories::find($id);

            if (!$category) {
                return response()->json([
                    'message' => 'Category not found',
                    'status' => false,
                    'data' => null,
                    'code' => 404
                ], 404);
            }

            return response()->json([
                'message' => 'Category fetched successfully',
                'status' => true,
                'data' => $category,
                'code' => 200
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while fetching category',
                'status' => false,
                'data' => null,
                'code' => 500
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categories $categories)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $categoryId)
    {
        try {
            $category = Categories::find($categoryId);

            if (!$category) {
                return response()->json([
                    'message' => 'Category not found',
                    'status' => false,
                    'data' => null,
                    'code' => 404
                ], 404);
            }

            $validated = $request->validate([
                'name' => 'required|string|max:80|unique:categories',
            ], [
                'name.required' => 'Nama harus diisi!',
            ]);

            $category->update($validated);

            return response()->json([
                'message' => 'Category updated successfully',
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
                'message' => 'An error occurred while updating category',
                'status' => false,
                'data' => null,
                'code' => 500
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $categoryId)
    {
        try {
            $category = Categories::find($categoryId);

            if (!$category) {
                return response()->json([
                    'message' => 'Category not found',
                    'status' => false,
                    'data' => null,
                    'code' => 404
                ], 404);
            }

            $category->delete();

            return response()->json([
                'message' => 'Category deleted successfully',
                'status' => true,
                'data' => null,
                'code' => 200
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while deleting category',
                'status' => false,
                'data' => null,
                'code' => 500
            ], 500);
        }
    }
}
