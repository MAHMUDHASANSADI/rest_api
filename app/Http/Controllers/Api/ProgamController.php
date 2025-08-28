<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProgramResource;
use Illuminate\Http\Request;
use App\Models\Progam;
use Illuminate\Support\Facades\Validator;

class ProgamController extends Controller
{
    public function index(){
        $programs = Progam::get();

        if($programs->count()>0){
            return ProgramResource::collection($programs);
        }
        else{
            return response()->json(['message'=>'No data available'],200);
        }
        
    }

    
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=>'required|string|max:255',
            'description'=>'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'validation error',
                'errors' => $validator->errors(),

            ],422);
        }

        $program = Progam::create([
            'name'=>$request->name,
            'description'=>$request->description,
        ]);

        return response()->json([
            'message'=>'Program Created Successfully',
            'data'=> new ProgramResource($program)
        ],200);
        
    }

    public function show(Progam $program){
        return new ProgramResource($program);        
    }
}
