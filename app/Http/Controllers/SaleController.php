<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use App\Models\Sale;
use App\Models\Product;
use App\Models\SaleDetail;


class SaleController extends CatalogController
{
    public function clazz()
    {
        return Sale::class;
    }

    protected function makeRelationship(&$entity)
    {
        $entity->user;
    }

    protected function validator($input)
    {
        $validator = Validator::make($input, [
            'id_user' => 'required|numeric',
            'sale_date' => 'required|date',
            'total' => 'required|numeric',
            'details' => 'required|array'

        ]);
        return $validator;
    }

   

    /**
     * Override
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $input = $request->getContent();
        $input = json_decode($input);
        $input = (array) $input;
        $validator = $this->validator($input);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        } else {

            $obj = $this->clazz()::create($input);
            if($obj){
                foreach($input['details'] as $detail){
                    $newDetail = new SaleDetail();
                    $newDetail->id_sale = $obj['id'];
                    $newDetail->id_product = $detail->id_product;
                    $newDetail->amount = $detail->amount;
                    $newDetail->total = $detail->total;
                    if($newDetail->save()){
                        $product = Product::find($detail->id_product);
                        $product->stock -= $detail->amount;
                        $product->save();
                    }
                    


                }
            }
            return response()->json($obj, 200);
        }
       
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

        
    }


}
