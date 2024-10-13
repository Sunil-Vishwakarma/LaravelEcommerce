<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Auth;
use Validator;

class SubCategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{

            $SubCategoryList = SubCategory::join('categories','sub_categories.category_id','=','categories.id')->select('sub_categories.*','categories.category_name')->get();
            return $this->sendResponse($SubCategoryList, 'Sub-Category list fetched successfully.');

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
            'subcategory_name' => 'required',
            'subcategory_description' => 'required',
            'image' => 'sometimes'
        ]);
   
        if($validator->fails())
        {
            return $this->sendError('Field Validation Error.', $validator->errors()->all());       
        }

        $input = $request->all();

        try{

            $SubCategory = SubCategory::create($input);
            return $this->sendResponse($SubCategory->get(), 'Sub-Category created successfully.');

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
