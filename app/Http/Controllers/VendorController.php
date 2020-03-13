<?php

namespace App\Http\Controllers;

use App\Vendor;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('vendors.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:6',
            'vendor_avatar' => 'required|image',
            'short_description' => 'required|min:6',
            'description' => 'required|min:6',
            'street_address' => 'required|min:6',
            'phone_number' => 'required|min:6',
            'postal_code' => 'required|min:4',
            'owner' => 'required|min:6',
            'date_established' => 'required|date'
        ]);

        if ($request->hasFile('vendor_avatar')) {
            $vendor_avatar = $request->vendor_avatar;
            $vendor_avatar_name = $vendor_avatar->getClientOriginalName();
            $vendor_avatar->move('images/uploads/shops', $vendor_avatar_name);
        }

        Vendor::create([
            'title' => $request->title,
            'user_id' => Auth::id(),
            'vendor_avatar' => $request->hasFile('vendor_path') ? $vendor_avatar_name : 'image-placeholder.jpg',
            'short_description' => $request->short_description,
            'description' => $request->description,
            'street_address' => $request->street_address,
            'phone_number' => $request->phone_number,
            'postal_code' => $request->postal_code,
            'owner' => $request->owner,
            'date_established' => $request->date_established
        ]);

        return redirect()->route('vendor.register');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Vendor $vendor
     * @return \Illuminate\Http\Response
     */
    public function show(Vendor $vendor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Vendor $vendor
     * @return \Illuminate\Http\Response
     */
    public function edit(Vendor $vendor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Vendor $vendor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vendor $vendor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Vendor $vendor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vendor $vendor)
    {
        //
    }
}
