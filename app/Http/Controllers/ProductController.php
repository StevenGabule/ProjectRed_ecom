<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\User;
use App\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return string
     */
    public function index()
    {
        $products = Product::latest()->paginate(16);
        if (Auth::check()) {
            $vendor = auth()->user()->vendor;
            if ($vendor->is_active === 1) {
                return view('vendors.index', compact('vendor'));
            }
        }
        return view('welcome', compact('products'));
    }

    public function VendorProduct()
    {
        $vendor = auth()->user()->vendor;
        return view('vendors.products.index', compact('vendor'));
    }

    public function getProduct()
    {
        if (request()->ajax()) {
            return datatables()->of(Product::latest()->get())
                ->addColumn('action', static function($data) {
                   $button = <<<EOT
                    <div class="dropdown no-arrow" style="width: 50px">
                       <a class="dropdown-toggle btn border btn-dashboard" 
                       href="#" role="button" 
                       id="dropdownAction" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                         <span data-feather="more-horizontal"></span>
                       </a>
                       
                       <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownAction">
                           
                           <a class="dropdown-item font-weight-bold" id="$data->id" href="/drivers/$data->id" target="_blank">
                            <i class="far fa-envelope fa-sm fa-fw mr-2"></i>View Message
                           </a>
                           
                           <a class="dropdown-item font-weight-bold starred" id="$data->id" href="javascript:void(0)">
                            <i class="far fa-star fa-sm fa-fw mr-2"></i>Starred this message
                           </a>
                           
                           <a class="dropdown-item font-weight-bold important" id="$data->id" href="javascript:void(0)">
                            <i class="far fa-circle fa-sm fa-fw mr-2"></i>Mark as Important
                           </a>
                           
                           <a class="dropdown-item font-weight-bold spam" id="$data->id" href="javascript:void(0)">
                            <i class="fas fa-exclamation-triangle fa-sm fa-fw mr-2"></i>Mark as Spam
                           </a>
                           
                           <a class="dropdown-item font-weight-bold trash" id="$data->id" href="javascript:void(0)">
                            <i class="fas fa-trash fa-sm fa-fw mr-2"></i>Move To Trash
                           </a>
                           
                           <a class="dropdown-item font-weight-bold archive" id="$data->id" href="javascript:void(0)">
                            <i class="fas fa-envelope-open-text fa-sm fa-fw mr-2"></i>Archive
                           </a>
                           
                       </div>
                     </div>
EOT;
                    return $button;
                })->rawColumns(['action'])->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vendor = auth()->user()->vendor;
        $categories = Category::latest()->get();
        return view('vendors.products.create', compact('vendor', 'categories'));
    }


    public function store(Request $request, int $vendor_id)
    {
        $this->validate($request, [
            'category_id' => 'required',
            'name' => 'required|min:6',
            'price' => 'required',
            'qty' => 'required',
            'unit' => 'required',
            'short_description' => 'required|max:150',
            'full_description' => 'required|max:250',
            'product_avatar' => 'required|image'
        ]);


        if ($request->hasFile('product_avatar')) {
            $product_avatar = $request->product_avatar;
            $product_avatar_name = $product_avatar->getClientOriginalName();
            $product_avatar->move('images/uploads/products', $product_avatar_name);
        }

        Product::create([
            'vendor_id' => $vendor_id,
            'category_id' => $request->category_id,
            'supplier_id' => 2,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'price' => $request->price,
            'qty' => $request->qty,
            'unit' => $request->unit,
            'short_description' => $request->short_description,
            'full_description' => $request->full_description,
            'product_avatar' => $request->hasFile('product_avatar') ? $product_avatar_name : 'image-placeholder.jpg'
        ]);

        return redirect()->route('vendor.products');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
