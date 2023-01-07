<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantPrice;
use App\Models\Variant;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        return view('products.index');
    }


    public function getProductList(Request $request){

        // var_dump($request->all());
        // exit();

        $data = Product::with('product_variant_price');

        return Datatables::of($data)->addIndexColumn()

            ->editColumn('title', function ($row) {
                return  ''.$row->title.' <br> Created at : '.date('d-F-Y', strtotime($row->created_at)).'';
            })

            ->addColumn('varient', function ($row) {
                $html ='';
                    $html =
                        '<dl class="row mb-0" style="height: 80px; overflow: hidden" id="variant">';
                            foreach ($row->product_variant_price as $value) {
                                $three = $value->variant_three->variant ?? '';
                                $html .='
                                <dt class="col-sm-3 pb-0">
                                    '.$value->variant_one->variant.'/'.$value->variant_two->variant.'/'.$three.'
                                </dt>
                                <dd class="col-sm-9">
                                    <dl class="row mb-0">
                                        <dt class="col-sm-4 pb-0">Price : '.number_format($value->price,2) .'</dt>
                                        <dd class="col-sm-8 pb-0">InStock : '.number_format($value->stock,2) .'</dd>
                                    </dl>
                                </dd>';
                            }
                            
                        $html .= '</dl> <button onclick="$("#variant").toggleClass("h-auto")" class="btn btn-sm btn-link">Show more</button>';
                return $html;
            })

            ->addColumn('action', function ($row) {
                $btn = '<div class="btn-group btn-group-sm">
                            <a href="'.route('product.edit', $row->id).'" class="btn btn-success">Edit</a>
                        </div>';
                return $btn;
            })

            ->rawColumns(['title','varient','action'])->make(true);
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

    }


    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show($product)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
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
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
