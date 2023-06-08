<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Scheduling;
use Validator;
use App\Http\Resources\SchedulingResource;

class SchedulingController extends BaseController
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schedulings = Scheduling::all();
    
        return $this->sendResponse(SchedulingResource::collection($schedulings), 'Scheduling retrieved successfully.');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'start_time' => 'required',
            'end_time' => 'required',
            'slot_1' => 'required',
            'slot_2' => 'required',
            'slot_3' => 'required',

        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $scheduling = Scheduling::create($input);
   
        return $this->sendResponse(new SchedulingResource($scheduling), 'Scheduling Schedule successfully.');
    } 
   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $scheduling = Scheduling::find($id);
  
        if (is_null($scheduling)) {
            return $this->sendError('Not Scheduling yet.');
        }
   
        return $this->sendResponse(new SchedulingResource($scheduling), 'Scheduling Schedule retrieved successfully.');
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Scheduling $scheduling)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'start_time' => 'required',
            'end_time' => 'required',
            'slot_1' => 'required',
            'slot_2' => 'required',
            'slot_3' => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $scheduling->start_time = $input['start_time'];
        $scheduling->end_time = $input['end_time'];
        $scheduling->slot_1 = $input['slot_1'];
        $scheduling->slot_2 = $input['slot_2'];
        $scheduling->slot_3 = $input['slot_3'];

        $scheduling->save();
   
        return $this->sendResponse(new SchedulingResource($scheduling), 'Scheduling schedule updated successfully.');
    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Scheduling $scheduling)
    {
        $scheduling->delete();
   
        return $this->sendResponse([], 'Scheduling schedule deleted successfully.');
    }
}
