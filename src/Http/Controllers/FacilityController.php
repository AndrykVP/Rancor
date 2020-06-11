<?php

namespace AndrykVP\SWC\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use AndrykVP\SWC\Models\System;
use AndrykVP\SWC\Http\Resources\FacilityResource;

class FacilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        //
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
      $systems = System::all();
      $collection = [];
       
      foreach($systems as $system)
      {
         $distance = sqrt(pow(($system->x_coordinate - $request->input('x_coordinate')),2) + pow(($system->y_coordinate - $request->input('y_coordinate')),2));

         $collection[] = [
            'id' => $system->id,
            'dist' => $distance
         ];
         
      }
         
      usort($collection, function($a, $b) {
         return $a['dist'] <=> $b['dist'];
      });
      
      $nearest = array_slice($collection,0,5);
      $indexes = array_column($nearest,'id');

      $result = System::find($indexes);

      //return response()->json($indexes, 200);

      return FacilityResource::collection($result);
    }
}
