<?php

class UrlController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        /* $query = array(
     'status:[ 1 TO * ]',
      'checked:1',
      'type:2' ,
      'is_coupon:0',
      'created:[ 1401382800 TO 1401469199]'
 );*/

        $query= Request::get('query');
        if(is_null($query)){
            return Response::json(
                array(
                    'data'=> false,
                    'code'=>  200
                )
            );
        }
        $query = unserialize(urldecode($query));
        $result = Transaction::getTransactionByConditionFromSolr(null,false,$query,array(),0,0);
        return Response::json(
            array(
                'data'=> $result,
                'code'=>  200
            )
        );

	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $url = new Url;
        $url->url = Request::get('url');
        $url->description = Request::get('description');
        $url->user_id = Auth::user()->id;

        // Validation and Filtering is sorely needed!!
        // Seriously, I'm a bad person for leaving that out.

        $url->save();

        return Response::json(array(
                'error' => false,
                'urls' => $url->toArray()),
            200
        );
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
