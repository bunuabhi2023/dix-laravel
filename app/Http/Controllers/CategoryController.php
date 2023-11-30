<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $data = [];
        try {
            $categories = Category::getCategoriesTree();
            
            $data['status'] = "Success";
            $data['data'] = $categories;

            return response()->json($data, 200);
        } catch (Exception $e) {
            $data['status'] = "Error";
            $data['message'] = $e->getMessage();
            return response()->json($data, 500);
        }
    }

    public function store(Request $request)
    {
        try{
            $request->validate([
                'name' => 'required|string',
                'parent_id' => 'nullable|exists:categories,id',
            ]);

            $category = Category::create([
                'name' => $request->input('name'),
                'parent_id' => $request->input('parent_id'),
            ]);

            return response()->json($category, 201);
        } catch (Exception $e) {
            $data['status'] = "Error";
            $data['message'] = $e->getMessage();
            return response()->json($data, 500);
        }
    }
}
