<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProgramResource;
use Illuminate\Http\Request;
use App\Models\Program;
use Illuminate\Support\Facades\Validator;

class ProgramController extends Controller
{
    // GET all programs
    public function index()
    {
        $programs = Program::all();

        if ($programs->count() > 0) {
            return ProgramResource::collection($programs);
        } else {
            return response()->json(['message' => 'No data available'], 200);
        }
    }

    // POST create program
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required|string|max:255',
            'description'=>'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $program = Program::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return response()->json([
            'message'=>'Program Created Successfully',
            'data'=> new ProgramResource($program)
        ], 201);
    }

    // GET single program
    public function show(Program $program)
    {
        return new ProgramResource($program);        
    }

    // PUT/PATCH update program
    public function update(Request $request, Program $program)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required|string|max:255',
            'description'=>'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $program->update([
            'name'=>$request->name,
            'description'=>$request->description,
        ]);

        return response()->json([
            'message'=>'Program Updated Successfully',
            'data'=> new ProgramResource($program)
        ], 200);   
    }

    // DELETE program
    public function destroy(Program $program)
    {
        $program->delete();

        return response()->json([
            'message' => 'Program Deleted Successfully'
        ], 200);
    }
}
