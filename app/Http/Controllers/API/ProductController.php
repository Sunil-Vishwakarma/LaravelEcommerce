<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Products;
use Illuminate\Support\Facades\Auth;
use Validator;
use Storage;

class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{

            $ProductsList = Products::join('categories','products.category_id','=','categories.id')->join('sub_categories','products.subcategory_id','=','sub_categories.id')->select('products.*','categories.category_name','sub_categories.subcategory_name')->where(['createdby'=>Auth::user()->id])->get();
            return $this->sendResponse($ProductsList, 'Products list fetched successfully.');

            } catch (\Exception$e) {

            return $this->sendError('Exception Error.', $e->getMessage(),500); 
        }
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'product_name' => 'required',
            'product_description' => 'required',
            'images' => 'required',
            'price' => 'required',
            'discount' => 'required',
            'quantity' => 'required',
            'stock' => 'required'
        ]);
   
        if($validator->fails())
        {
            return $this->sendError('Field Validation Error.', $validator->errors()->all());       
        }

        $input = $request->all();
        $input['createdby'] = Auth::user()->id;

        try{
            // upload base64 image
            $image_64 = $request->images;
            $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png
              $replace = substr($image_64, 0, strpos($image_64, ',')+1);
             $image = str_replace($replace, '', $image_64); 
             $image = str_replace(' ', '+', $image); 
             $imageName = rand().'.'.$extension;
            Storage::disk('public')->put($imageName, base64_decode($image));
            $input['images'] = $imageName;

            $Products = Products::create($input);
            return $this->sendResponse($Products->get(), 'Product created successfully.');

            } catch (\Exception$e) {

            return $this->sendError('Exception Error.', $e->getMessage(),500); 
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
