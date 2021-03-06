<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerCollection;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
          return new CustomerCollection(Customer::orderBy('id', 'desc')->paginate(5));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // $image = $request->file('image');
    // $ext = $image->extension();
    // $file = time().'.'.$ext;
    // $image->storeAs('public/customer', $file);
    // $customer->image = $file;

    public function store(Request $request)
    {
        $input = $request->all();
         if ($request->hasFile('image')) {
            $image = $request->file('image');
            $ext = $image->getClientOriginalExtension();
            $file = time().'.'.$ext;
            $image->move('uploads/customers', $file);
            $input['image'] = $file;
        }
        Customer::create($input);
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
         $customer = Customer::findOrFail($id);

         $input = $request->all();

         if($request->hasFile('image')){
            $image = $request->file('image');
            $ext = $image->getClientOriginalExtension();
            $file = time().'.'.$ext;
            $image->move('uploads/customers', $file);
            $input['image'] = $file;
         }

        try{
            $customer->update($input);
            return response()->json(
                ['success' => 'Customer info successfully updated.', 
                'success code' => 201,
                'data' => $customer]);
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $imagePath = 'public/uploads/customers/'.$customer->image;
        if(file_exists($imagePath)){
            unlink($imagePath);
        }
        $customer->delete();
    }

    // search customer information
    public function search_customer_information($inputField, $searchKey){
             return new CustomerCollection(Customer::where($inputField, 'LIKE', '%'.$searchKey.'%')->latest()->paginate(5));
    }
}
