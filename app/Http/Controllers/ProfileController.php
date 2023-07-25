<?php

namespace App\Http\Controllers;



use Validator;
use App\Models\Profile;

date_default_timezone_set('America/Mexico_City');


class ProfileController extends CatalogController
{
    public function clazz() {
        return Profile::class;
    }

    protected function makeRelationship(&$entity) {

    }

    protected function validator($input) {
        $validator = Validator::make($input, [
            'name' => 'required|string'
        ]);

        return $validator;
    }
}
