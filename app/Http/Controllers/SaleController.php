<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

use Validator;
use App\Models\Sale;
use App\Models\Product;
use App\Models\SaleDetail;

date_default_timezone_set('America/Mexico_City');


class SaleController extends CatalogController
{
    public function clazz()
    {
        return Sale::class;
    }

    protected function makeRelationship(&$entity)
    {
        $entity->user;
        $entity->details;
        $entity->payment;

    }

    protected function makeRelationshipDetail(&$detail)
    {
        $detail->product;

    }
    

    protected function validator($input)
    {
        $validator = Validator::make($input, [
            'id_user' => 'required|numeric',
            'sale_date' => 'required|date',
            'total' => 'required|numeric',
            'details' => 'required|array',
            'payment' => 'required'

        ]);
        return $validator;
    }

    protected function validatorPayment($input)
    {
        $validator = Validator::make($input, [
            'sale_hour_date' => 'required|date',
            'street' => 'required|string|min:20|max:255'
        ]);

        return $validator;
    }

    public function show($id)
    {
        //
        $entity = $this->clazz()::find($id);
        if($entity==null) return $this->sendError("Object not found", 'Id not found', 404);

        $this->makeRelationship($entity);

        foreach($entity->details as $detail){
            $this->makeRelationshipDetail($detail);
        }

        return response()->json($entity, 200);
        // return $this->sendResponse($entity, 'FOUND');
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
        }
        $validatorPayment = $this->validatorPayment((array) $input['payment']);

        if ($validatorPayment->fails()) {
            return $this->sendError('Validation Payment Error.', $validatorPayment->errors());
        } else {

            $obj = $this->clazz()::create($input);
            if ($obj) {
                foreach ($input['details'] as $detail) {
                    $newDetail = new SaleDetail();
                    $newDetail->id_sale = $obj['id'];
                    $newDetail->id_product = $detail->id_product;
                    $newDetail->amount = $detail->amount;
                    $newDetail->total = $detail->total;
                    if ($newDetail->save()) {
                        $product = Product::find($detail->id_product);
                        $product->stock -= $detail->amount;
                        $product->save();
                    }
                }

                $newPayment = new Payment();
                $newPayment->id_sale = $obj['id'];
                $newPayment->sale_hour_date = $input['payment']->sale_hour_date;
                $newPayment->street = $input['payment']->street;
                $newPayment->amount = $obj['total'];
                $newPayment->status = 'Completado';
                $newPayment->save();
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
