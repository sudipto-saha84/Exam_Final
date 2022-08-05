<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\ProductVariantPrice;
use App\Models\Variant;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        return view('products.index', [
            'products' => Product::paginate(10),
            'productsPrices' => ProductVariantPrice::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        $variants = Variant::all();
        return view('products.create', compact('variants'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $product = Product::create([
            'title' => $request->title,
            'sku' => $request->sku,
            'description' => $request->description,
        ]);
        if ($request->hasFile('product_image')) {
            foreach ($request->file('product_image') as $image) {
                $name = time() . '.' . $image->extension();
                $image->move(public_path() . '/files/', $name);
                ProductImage::create([
                    'product_id' => $product->id,
                    'file_path' => $name
                ]);
            }
        }
        foreach ($request->product_variants as $product_variant) {
            foreach ($product_variant as $variant) {
                $pV=ProductVariant::create([
                    'variant' => $variant,
                    'variant_id' => $product_variant->option,
                    'product_id' => $product->id,
                ]);
//                ProductVariantPrice::create([
//                    'product_variant_one'=>,
//                    'product_variant_two'=>,
//                    'product_variant_three'=>,
//
//                ]);
            }
        }
        return back()->with('success','Product Creaated');
    }


    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public
    function show($product)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public
    function edit(Product $product)
    {
        $variants = Variant::all();
        return view('products.edit', compact('variants'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public
    function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public
    function destroy(Product $product)
    {
        //
    }
}
