<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\User;

class UserController extends CatalogController
{
    public function clazz()
    {
        return User::class;
    }

    protected function makeRelationship(&$entity)
    {

        $entity->oProfile;
    }

    protected function validator($input)
    {
        $validator = Validator::make($input, [
            'id_profile' => 'required',
            'name' => 'required|string|between:2,100',
            'last_name' => 'required|string|between:2,100',
            'nick' => 'required|string|between:2,100|unique:users',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6',
            'active' => 'required|boolean'
        ]);

        return $validator;
    }

    protected function validatorUpdate($input, $id)
    {
        $validator = Validator::make($input, [
            'name' => 'string|between:2,100',
            'last_name' => 'string|between:2,100',
            'nick' => 'string|between:2,100|unique:users,nick,'.$id,
            'email' => 'string|email|max:100|unique:users,email,'.$id,
            'password' => 'string|min:6',
            'active' => 'boolean'
        ]);

        return $validator;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // $input = $request->all();
        $input = $request->getContent();
        $input = json_decode($input);
        $input = (array) $input;
        $validator = $this->validator($input);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 400);
        } else {
            $input['password'] = bcrypt($input['password']);
            $obj = $this->clazz()::create($input);
            return $this->sendResponse([$obj], 'success');
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
    
        $user = User::find($id);
        if($user == NULL) return $this->sendError('Not Found', 'USer id not found', 404);
        $input = $request->getContent();
        $input = json_decode($input);
        $input = (array) $input;
        $validator = $this->validatorUpdate($input, $id);

        if ($validator->fails()) return $this->sendError('Validation Error.', $validator->errors(), 400);

        if (isset($input['password'])) {
            $tmp_pass = bcrypt($input['password']);
            if (strcmp($user->password, $tmp_pass) !== 0) {
                $user->password = $tmp_pass;
            }
        }
        if (isset($input['name'])) {
            $user->name = $input['name'];
        }
        if (isset($input['nick'])) {
            $user->name = $input['nick'];
        }
        if (isset($input['email'])) {
            $user->email = $input['email'];
        }
        if (isset($input['status'])) {
            $user->status = $input['status'];
        }
        if (isset($input['id_profile'])) {

            $user->id_profile = $input['id_profile'];
        }
        $user->save();


        return response()->json($user, 200);
    }

    public function updateOnlyProfile(Request $request, $id)
    {
        //
        $user = User::find($id);
        // Esto hay que implementarlo
        // $input = $request->getContent();
        // $input = json_decode($input);
        $input = $request->all();

        if (isset($input['profile'])) {
            $user->profile = $input['profile'];
        }
        $user->save();
        return response()->json($user, 200);
    }
}
