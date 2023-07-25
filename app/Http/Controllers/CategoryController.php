<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Category;

date_default_timezone_set('America/Mexico_City');

class CategoryController extends CatalogController
{
    public function clazz()
    {
        return Category::class;
    }

    protected function makeRelationship(&$entity)
    {
    }

    protected function validator($input)
    {
        $validator = Validator::make($input, [
            'name' => 'required|string',
            'active' => 'required|boolean',
        ]);

        return $validator;
    }

    public function store(Request $request)
    {
        //
        // $input = $request->all();
        $input = $request->getContent();
        $input = json_decode($input);
        $input = (array) $input;
        $validator = $this->validator($input);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        } else {
            if (Category::where('name', $input['name'])->first() != null) return $this->sendError('Validation error', 'Already exists a category with this name', 409);
            $obj = $this->clazz()::create($input);
            return response()->json($obj, 200);
        }
    }

    public function listAllWithProducts(Request $request)
    {
        $categories = Category::all();
        if ($categories != NULL) {
            foreach ($categories as $category) {
                $category->products;
            }
        }
        return $this->sendResponse($categories, 'Ok');
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
        $object = Category::find($id);
        $input = $request->getContent();
        if ($object == null) return $this->sendError('Object not found', ['The id is not found'], 404);
        if ($input == null) {
            return $this->sendError('JSON Invalid', ['Input needed'], 406);
        }
        $input = json_decode($input, true);

        $inputValidator = $input;
        $validator = $this->validator((array)$inputValidator);

        if ($validator->fails()) return $this->sendError('Validation Error.', $validator->errors());

        if (json_last_error() !== 0)
            return $this->sendError('JSON Invalid', ['Malformed JSON'], 406);
        if (isset($input['name']) && $input['name'] !== '')
            if (Category::where('id', '!=', $id)->where('name', $input['name'])->first() != null) return $this->sendError('Validation error', 'Already exists a product with this name', 409);
            $object->name = $input['name'];
        if (isset($input['active']) && $input['active'] !== '')
            $object->active = $input['active'];

        $answer = $object->save();
        if ($answer) {
            return response()->json($object, 200);
        }
        return $this->sendError('Update error', ['The object update is not valid'], 500);
    }
}
