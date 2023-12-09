<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\ResponseHelper;
use Exception;


// validation
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('query');
        $limit = $request->query('limit');
        $page = $request->query('page');
        $customers = Category::when($search, function ($query) use ($search) {
            return $query->where('name', 'like', "%$search%");
        })->latest()->paginate($limit, ['*'], 'page', $page);
        return response()->json(["message" => "Resource retrieved successfully", "data" => $customers->items(), "total" =>  $customers->total(), "page" =>  $customers->currentPage(), "limit" => $customers->perPage()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        try {
            // The request is validated, and you can access the validated data using $request->validated()
            $category = Category::create($request->all());
            return ResponseHelper::success($category, "Category has been created!");
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $category = Category::find($id);
            if (!$category) {
                return ResponseHelper::notFound();
            }
            return  ResponseHelper::success($category);
        } catch (Exception $e) {
            return ResponseHelper::error($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, string $id)
    {
        try {
            $category = Category::find($id);
            if (!$category) {
                return ResponseHelper::notFound();
            }
            $category->update($request->all());
            return  ResponseHelper::success($category);
        } catch (Exception $e) {
            return ResponseHelper::success($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $category = Category::whereIn('status', ['active', 'inactive'])->where('id', $id)
                ->first();
            if (!$category) {
                return ResponseHelper::notFound();
            }
            $category->update(["status" => "deleted"]);
            return ResponseHelper::success((object)[], "Category has been deleted!");
        } catch (Exception $e) {
            return ResponseHelper::success($e->getMessage());
        }
    }
}
