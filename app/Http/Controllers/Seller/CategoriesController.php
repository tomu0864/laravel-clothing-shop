<?php

namespace App\Http\Controllers\Seller;

use App\Models\Category;
use App\Models\MainCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoriesController extends Controller
{
    private $category;

    private $mainCategory;

    public function __construct(Category $category, MainCategory $mainCategory)
    {
        $this->category = $category;
        $this->mainCategory = $mainCategory;
    }

    public function index(Request $request)
    {
        if ($request->search_main_c) {
            $mainCategories = $this->mainCategory->where('name', 'LIKE', '%' . $request->search_main_c . '%')->paginate(10);
            $categories = $this->category->orderBy('name')->paginate(10);
        } elseif ($request->search_sub_c) {
            $categories = $this->category->where('name', 'LIKE', '%' . $request->search_sub_c . '%')->paginate(10);
            $mainCategories = $this->mainCategory->orderBy('name')->paginate(10);
        } else {
            $categories = $this->category->orderBy('name')->paginate(10);
            $mainCategories = $this->mainCategory->orderBy('name')->paginate(10);
        }

        return view('seller.categories.index')->with('categories', $categories)->with('mainCategories', $mainCategories);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50',
        ]);

        $this->category->name = ucwords($request->name);
        $this->category->save();

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $fieldName = "name$id";

        $request->validate([
            $fieldName => 'required|max:50|unique:categories,name,' . $id,
        ], [
            "$fieldName.required" => 'Category name can not be empty',
            "$fieldName.max" => 'Category name should be less than 50 characters',
            "$fieldName.unique" => 'The category name already exists',
        ]);

        $categoryName = $request->input($fieldName);

        $this->category->findOrFail($id)->update([
            'name' => $categoryName,
        ]);

        return redirect()->back();
    }

    public function delete($id)
    {
        $this->category->findOrFail($id)->delete();

        return redirect()->back();
    }

    public function mainCategorystore(Request $request)
    {
        $request->validate([
            'main_c_name' => 'required|max:50',
        ]);

        $this->mainCategory->name = ucwords($request->main_c_name);
        $this->mainCategory->save();

        return redirect()->back();
    }

    public function mainCategoryUpdate(Request $request, $id)
    {
        $fieldName = "main_c_name$id";

        $request->validate([
            $fieldName => 'required|max:50|unique:categories,name,' . $id,
        ], [
            "$fieldName.required" => 'Category name can not be empty',
            "$fieldName.max" => 'Category name should be less than 50 characters',
            "$fieldName.unique" => 'The category name already exists',
        ]);

        $categoryName = $request->input($fieldName);

        $this->mainCategory->findOrFail($id)->update([
            'name' => $categoryName,
        ]);

        return redirect()->back();
    }

    public function mainCategoryDelete($id)
    {
        $this->mainCategory->findOrFail($id)->delete();

        return redirect()->back();
    }
}
