<?php

namespace App\Http\Controllers\Seller;

use App\Models\Product;
use App\Models\Category;
use App\Models\MainCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
{
    private $product;
    private $category;

    private $mainCategory;
    public function __construct(Product $product, Category $category, MainCategory $mainCategory)
    {
        $this->product = $product;
        $this->category = $category;
        $this->mainCategory = $mainCategory;
    }

    public function index(Request $request)
    {
        if ($request->search) {
            $products = $this->product->where('name', 'LIKE', '%' . $request->search . '%')->paginate(10);
        } else {
            $products = $this->product->orderBy('name')->paginate(10);
        }

        return view('seller.products.index')->with('products', $products);
    }

    public function add()
    {
        $categories = $this->category->latest()->get();
        $mainCategories = $this->mainCategory->latest()->get();

        return view('seller.products.add')->with('categories', $categories)->with('mainCategories', $mainCategories);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'short_desc' => 'required',
            'description' => 'required',
            'price' => 'required',
            'gender' => 'required',
            'quantity' => 'required',
            'discount' => 'required',
            'category_id' => 'required',
            'main_category_id' => 'required',
            'image' => 'required|file|mimes:jpeg,png,pdf,jpg,gif',
        ]);

        // Product table

        $this->product->name = ucwords($request->name);
        $this->product->main_category_id = $request->main_category_id;
        $this->product->short_desc = $request->short_desc;
        $this->product->description = $request->description;
        $this->product->price = $request->price;
        $this->product->gender = $request->gender;
        $this->product->quantity = $request->quantity;
        $this->product->discount = $request->discount;
        $this->product->image = "data:image/" . $request->image->extension() .
            ";base64," . base64_encode(file_get_contents($request->image));
        $this->product->save();


        // productcategory Table
        $Product_category = [];
        foreach ($request->category_id as $category_id) {
            $Product_category[] = ['category_id' => $category_id];
        }

        $this->product->productCategory()->createMany($Product_category);

        return redirect()->route('seller.products');
    }

    public function edit($id)
    {
        $product = $this->product->findOrFail($id);
        $categories = $this->category->latest()->get();
        $mainCategories = $this->mainCategory->latest()->get();

        $selected_category = [];
        foreach ($product->productCategory as $category) {
            $selected_category[] = $category->category_id;
        }

        return view('seller.products.edit')->with('product', $product)
            ->with('categories', $categories)->with('selected_category', $selected_category)->with('mainCategories', $mainCategories);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'short_desc' => 'required',
            'description' => 'required',
            'price' => 'required',
            'gender' => 'required',
            'quantity' => 'required',
            'discount' => 'required',
            'category_id' => 'required',
            'main_category_id' => 'required',
            'image' => 'file|mimes:jpeg,png,pdf,jpg,gif',
        ]);

        $product = $this->product->findOrFail($id);

        $product->name = ucwords($request->name);
        $product->main_category_id = $request->main_category_id;
        $product->short_desc = $request->short_desc;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->gender = $request->gender;
        $product->quantity = $request->quantity;
        $product->discount = $request->discount;
        if ($request->image) {
            $product->image = "data:image/" . $request->image->extension() .
                ";base64," . base64_encode(file_get_contents($request->image));
        }
        $product->save();

        // productcategory Table
        $product->productCategory()->delete();

        $Product_category = [];
        foreach ($request->category_id as $category_id) {
            $Product_category[] = ['category_id' => $category_id];
        }

        $product->productCategory()->createMany($Product_category);

        return redirect()->route('seller.products');
    }

    public function delete($id)
    {
        $this->product->findOrFail($id)->delete();

        return redirect()->back();
    }
}
