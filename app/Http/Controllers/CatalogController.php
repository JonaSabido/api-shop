<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

abstract class CatalogController extends Controller {

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public abstract function clazz();

    protected abstract function makeRelationship(&$entity);

    protected abstract function validator($entity);
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        //
        $expr = "/(\*?)([A-Za-z0-9_]+)\^(.*)~(.*)/";
        ;
        $filters = $request->all();
        $seasons = $this->clazz()::select('*');
        $limit = 200;
        if (isset($filters)&&count($filters)>0) {

            if (array_key_exists('limit', $filters)) {
                $limit = $filters['limit'];
                unset( $filters['limit'] );
            }

            foreach($filters as $key=>$filter) {
                if($key!=='page'){
                    $seasons = $seasons->where($key, $filter);
                }
                if($key=='name'){
                    $seasons = $seasons->where('name', 'LIKE', '%'.$filter.'%');
                }
            }

            $entities = $seasons->paginate($limit)->appends($filters);

            if ($entities!=NULL) {
                foreach($entities as $entity) {
                    $this->makeRelationship($entity);
                }
            }
            return $this->sendResponse($entities, $filters);
        } else {
            $entities = $this->clazz()::paginate($limit);
            if ($entities!=NULL) {

                foreach($entities as $entity) {

                    $this->makeRelationship($entity);
                }
            }
            return $this->sendResponse($entities, $filters);
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
        $entity = $this->clazz()::find($id);
        if($entity==null) return $this->sendError("Object not found", 'Id not found', 404);

        $this->makeRelationship($entity);
        return response()->json($entity, 200);
        // return $this->sendResponse($entity, 'FOUND');
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
            return $this->sendError('Validation Error.', $validator->errors());
        } else {
            $obj = $this->clazz()::create($input);
            return response()->json($obj, 200);
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
        //
        $object = $this->clazz()::find($id);
        if ($object!==null)
        {
            $object->delete();

            return response()->json($object, 200);
        }
        else
            return $this->sendError('Not found', ['The object doesnt found']);

    }


    public function sendResponse($result, $message)
    {
    	$response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];


        return response()->json($response, 200);
    }



    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
    	$response = [
            'success' => false,
            'message' => $error,
        ];


        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }


        return response()->json($response, $code);
    }
}

