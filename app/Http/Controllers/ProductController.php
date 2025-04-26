<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Products;
use App\Models\Categories;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Products::with('comments')->with('category')->where('is_deleted', false)->get();
        return view('products', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Categories::where('is_deleted', false)->get();

        return view('product_form', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_image' => 'nullable',
            'product_name' => 'required|unique:products,product_name',
            'task_description' => 'nullable|string',
            'category' => 'required|exists:categories,category_id',
            'task_date' => 'required|date',
            'comments' => 'nullable|string|max:255'
        ]);

        $validated['category_id'] = $request->category;

        if ($request->hasFile('product_image')) {
            $filenameWithExtensions = $request->file('product_image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExtensions, PATHINFO_FILENAME);
            $extensions = $request->file('product_image')->getClientOriginalExtension();
            $filenameToStore = $filename . '-' . time() . '_' . $extensions;
            $request->file('product_image')->storeAs('Uploads/Product Images', $filenameToStore);
            $validated['product_image'] = $filenameToStore;
        }

        $product = Products::create($validated);

        if (!$product) {
            return redirect()->route('product.create')->with([
                'message' => 'Unable to add product!',
                'type' => 'error'
            ]);
        }

        return redirect()->route('product.create')->with([
            'message' => 'Task added successfully!',
            'type' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $product_id)
    {
        $product = Products::findorfail($product_id);
        $categories = Categories::where('is_deleted', false)->get();

        return view('product_form', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $product_id)
    {
        $product = Products::findorfail($product_id);

        $validated = $request->validate([
            'product_image' => 'nullable',
            'product_name' => 'required|unique:products,product_name,' . $product_id . ',product_id',
            'task_description' => 'nullable|string',
            'category' => 'required|exists:categories,category_id',
            'task_date' => 'required|date',
            'comments' => 'nullable|string|max:255'
        ]);

        $validated['category_id'] = $request->category;

        if ($request->hasFile('product_image')) {
            $filenameWithExtensions = $request->file('product_image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExtensions, PATHINFO_FILENAME);
            $extensions = $request->file('product_image')->getClientOriginalExtension();
            $filenameToStore = $filename . '-' . time() . '_' . $extensions;
            $request->file('product_image')->storeAs('Uploads/Product Images', $filenameToStore);
            $validated['product_image'] = $filenameToStore;
        }

        if ($product->update($validated)) {
            return redirect()->route('products')->with([
                'message' => 'Task updated successfully!',
                'type' => 'success'
            ]);
        }

        return redirect()->route('products')->with([
            'message' => 'Unable to update product!',
            'type' => 'error'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $product_id)
    {
        $product = Products::findorfail($product_id);

        $product->is_deleted = true;

        $product->save();

        return redirect()->route('products')->with([
            'message' => 'Task deleted successfully!',
            'type' => 'success'
        ]);
    }
    public function addComment(Request $request, $id)
    {

        $request->validate([
            'comment' => 'required|string|max:255',
        ]);


        $comment = Comment::create([
            'product_id' => $id,
            'user_id' => Auth::user()->id,
            'comment' => $request->comment,

        ]);

        if ($comment) {
            return redirect()->back()->with('success', 'Comment added successfully!');
        }


        return redirect()->back()->with('error', 'Unable to comment!');
    }
}
