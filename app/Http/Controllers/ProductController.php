<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Validator;
use App\Models\Product;

date_default_timezone_set('America/Mexico_City');


class ProductController extends CatalogController
{
    public function clazz()
    {
        return Product::class;
    }

    protected function makeRelationship(&$entity)
    {
        if ($entity->id_category > 0) {
            $entity->category;
        }
    }

    protected function validator($input)
    {
        $validator = Validator::make($input, [
            'id_category' => 'required|numeric',
            'name' => 'required|string|unique:products',
            'description' => 'string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:0',
            'url' => 'required|string',
            'active' => 'required|boolean',
        ]);

        return $validator;
    }

    protected function validatorUpdate($input, $id)
    {
        $validator = Validator::make($input, [
            'id_category' => 'numeric',
            'name' => 'string|unique:products,name,'.$id,
            'description' => 'string',
            'price' => 'numeric|min:0',
            'stock' => 'numeric|min:0',
            'url' => 'string',
            'active' => 'boolean',
        ]);

        return $validator;
    }

    public function search(Request $request, $text){
        $products = Product::where('name', 'LIKE', '%' . $text . '%')->get();
        if ($products!=NULL) {

            foreach($products as $entity) {

                $this->makeRelationship($entity);
            }
        }
        return $this->sendResponse($products, 'OK');
    }

    public function store(Request $request)
    {
        $input = $request->getContent();
        $input = json_decode($input);
        $input = (array) $input;
        $validator = $this->validator($input);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        } else {
            if (Category::find($input['id_category']) == null) return $this->sendError('Validation error', 'id_category is not found', 400);
            $obj = $this->clazz()::create($input);
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
        //
        $object = Product::find($id);
        if($object == NULL) return $this->sendError('Not Found', 'USer id not found', 404);
        $input = $request->getContent();
        $input = json_decode($input);
        $input = (array) $input;
        $validator = $this->validatorUpdate($input, $id);

        if ($validator->fails()) return $this->sendError('Validation Error.', $validator->errors(), 400);

        if (json_last_error() !== 0)
            return $this->sendError('JSON Invalid', ['Malformed JSON'], 406);
        if (isset($input['id_category']) && $input['id_category'] !== '')
            $object->id_category = $input['id_category'];
        if (isset($input['name']) && $input['name'] !== '') 
            $object->name = $input['name'];
        if (isset($input['description']) && $input['description'] !== '')
            $object->description = $input['description'];
        if (isset($input['price']) && $input['price'] !== '')
            $object->price = $input['price'];
        if (isset($input['stock']) && $input['stock'] !== '')
            $object->stock = $input['stock'];
        if (isset($input['url']) && $input['url'] !== '')
            $object->url = $input['url'];
        if (isset($input['active']) && $input['active'] !== '')
            $object->active = $input['active'];

        $answer = $object->save();
        if ($answer) {
            if ($object->id_category > 0)
                $object->category = Category::find($input['id_category']);
            return response()->json($object, 200);
        }
        return $this->sendError('Update error', ['The object update is not valid'], 500);
    }
}
