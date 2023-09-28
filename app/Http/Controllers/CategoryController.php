<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return response()->view('backend.category', ['categories' => $categories]);
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

        $validator = Validator($request->all(), [
            'name' => 'required|string|min:3|max:30',
            'time' => 'required|numeric',
            'date' => 'nullable',
        ]);

        if (!$validator->fails()) {
            $category = new Category();
            $category->name = $request->get('name');
            $category->time = $request->get('time');
            if ($request->get('date') != null) {
                $category->Close_date = $request->get('date');
            }
            $isSaved =  $category->save();
            return response()->json([
                'message' => $isSaved ? "Saved Successfully" : "Failed to save"
            ], $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
        } else {
            //VALIDATION FAILED
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator($request->all(), [
            'name' => 'required|string|min:3|max:30',
            'time' => 'required|numeric',
            'date' => 'nullable',
        ]);
        $category = Category::find($id);
        if (!$validator->fails()) {
            $category->name = $request->get('name');
            $category->time = $request->get('time');
            if ($request->get('date') != null) {
                $category->Close_date = $request->get('date');
            }
            $isSaved =  $category->save();
            return response()->json([
                'message' => $isSaved ? "Updated Successfully" : "Failed to Updated"
            ], $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
        } else {
            //VALIDATION FAILED
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // $category = Category::find($id);
        $isDeleted = $category->delete();
        if ($isDeleted) {
            //
            $doctorsInCategory = DB::table('doctors')->where('category_id', $category->id)->pluck('id');
            DB::table('days')->whereIn('doctor_id', $doctorsInCategory)->delete();
            DB::table('doctors')->where('category_id', $category->id)->delete();
            return response()->json(['icon' => 'success', 'title' => 'Success!', 'text' => 'Deleted successfully'], Response::HTTP_OK);
        } else {
            return response()->json(['icon' => 'error', 'title' => 'Failed!', 'text' => 'Delete failed'], Response::HTTP_BAD_REQUEST);
        }
    }
}
