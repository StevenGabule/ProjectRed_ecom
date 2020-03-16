<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\ProductRequest;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    protected $uploadPath;

    public function __construct()
    {
        $this->middleware('auth')->except(['index']);
        $this->uploadPath = public_path(config('ecom.uploads.products.directory'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return string
     */
    public function index()
    {
        $products = Product::latest()->paginate(16);
        if (Auth::check() && auth()->user()->vendor) {
            $vendor = auth()->user()->vendor;
            if ($vendor->is_active === 1) {
                return view('vendors.index', compact('vendor'));
            }
            return view('welcome', compact('products'));
        }
        return view('welcome', compact('products'));
    }

    public function VendorProduct()
    {
        $vendor = auth()->user()->vendor;
        return view('vendors.products.index', compact('vendor'));
    }

    public function getProducts()
    {
        if (request()->ajax()) {
            $id = Auth::id();
            return datatables()->of(DB::table('vendorProducts')
                ->select('id', 'product_avatar', 'name', 'catname', 'qty', 'price', 'venId')
                ->where('vendor_id', $id)->get())
                ->addColumn('action', static function ($data) {
                    $button = <<<EOT
                    <div class="dropdown no-arrow" style="width: 50px">
                    
                       <a class="btn border btn-dashboard" 
                            href="javascript:void(0)" 
                            role="button" 
                            id="dropdownAction" 
                            data-toggle="dropdown" 
                            aria-haspopup="true" 
                            aria-expanded="false">
                        <i class="fas fa-sm fa-fw fa-ellipsis-h"></i>
                       </a>
                       
                       <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownAction">
                           
                           <a class="dropdown-item font-weight-bold" id="$data->id" href="/vendor/product/edit/$data->id">
                            <i class="fas fa-pencil-alt fa-sm fa-fw mr-2"></i> Edit
                           </a>
                           
                           <a class="dropdown-item font-weight-bold productDelete" data-toggle="modal" data-target="#productDeleteModal" id="$data->id-$data->venId" href="javascript:void(0)">
                            <i class="fas fa-trash fa-sm fa-fw mr-2"></i> Delete
                           </a>
                           
                       </div>
                     </div>
EOT;
                    return $button;
                })->addColumn('checkbox', '<div class="d-flex justify-content-center"><input type="checkbox" name="product_checkbox[]" id="{{ $id }}" class="product_checkbox" value="{{$id}}" /></div>')
                ->rawColumns(['action', 'checkbox'])->make(true);
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


    public function store(ProductRequest $request, int $vendor_id)
    {
        $this->handleRequest($request);

        if ($request->hasFile('product_avatar')) {
            $product_avatar = $request->product_avatar;
            $product_avatar_name = $product_avatar->getClientOriginalName();
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

    public function show(Product $product)
    {
    }


    public function edit(Product $product)
    {
        $vendor = auth()->user()->vendor;
        $categories = Category::latest()->get();
        return view('vendors.products.edit', compact('vendor', 'categories', 'product'));
    }

    public function update(ProductRequest $request, $venId, $prodId)
    {

        $product_avatar_name = '';

        $data = Product::findOrFail($prodId);
        $this->handleRequest($request);
        $oldAvatar = $data->product_avatar;

        if ($request->hasFile('product_avatar')) {
            $product_avatar = $request->product_avatar;
            $product_avatar_name = $product_avatar->getClientOriginalName();
        }

        $data->update([
            'vendor_id' => $venId,
            'category_id' => $request->category_id,
            'supplier_id' => 2,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'price' => $request->price,
            'qty' => $request->qty,
            'unit' => $request->unit,
            'short_description' => $request->short_description,
            'full_description' => $request->full_description,
            'product_avatar' => $request->hasFile('product_avatar') ? $product_avatar_name : $data->product_avatar
        ]);

        if ($oldAvatar !== $data->product_avatar) {
            $this->removeImage($oldAvatar);
        }

        return redirect()->route('vendor.products');
    }

    public function destroy($venId, $prodId)
    {
        $product = Product::findOrFail($prodId);
        $product->delete();
        $this->removeImage($product->product_avatar);
        return redirect()->route('vendor.products');
    }

    public function multiDestroy(Request $request)
    {
        $arr = $request->id;
        foreach ($arr as $id) {
            $product = Product::findOrFail($id);
            $product->delete();
            $this->removeImage($product->product_avatar);
        }
        return null;
    }

    public function handleRequest($request)
    {
        $data = $request->all();
        if ($request->hasFile('product_avatar')) {
            $image = $request->file('product_avatar');
            $filename = $image->getClientOriginalName();
            $destination = $this->uploadPath;
            $successUploaded = $image->move($destination, $filename);
            if ($successUploaded) {
                $width = config('ecom.uploads.products.thumbnail.width');
                $height = config('ecom.uploads.products.thumbnail.height');
                $extension = $image->getClientOriginalExtension();
                $thumbnail = str_replace(".{$extension}", "_thumb.{$extension}", $filename);
                Image::make($destination . '/' . $filename)->resize($width, $height)->save($destination . '/' . $thumbnail);
            }
            $data['product_avatar'] = $filename;
        }
        return $data;
    }

    private function removeImage($image)
    {
        if (!empty($image)) {
            $imagePath = $this->uploadPath . '/' . $image;
            $ext = substr(strstr($image, '.'), 1);
            $thumbnail = str_replace(".{$ext}", "_thumb.{$ext}", $image);
            $thumbnailPath = $this->uploadPath . '/' . $thumbnail;
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            if (file_exists($thumbnailPath)) {
                unlink($thumbnailPath);
            }
        }
    }

}
