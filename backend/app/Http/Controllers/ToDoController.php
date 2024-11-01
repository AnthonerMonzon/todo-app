<?php

namespace App\Http\Controllers;

use App\Models\ToDo;
use Illuminate\Http\Request;

class ToDoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->query('status')){
            $status = $request->query('status');
            $query = ToDo::query();
            return response()->json([
                'status' => 200,
                'toDo' => $query->where('status', '=', $status)->get(),
                '__status' => $status
            ], 200);
            
        } else {
            return response()->json([
                'status' => 200,
                'toDo' => ToDo::all()
            ], 200);
        }

        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'status' => 'required'
        ]);

        $toDo = ToDo::create($fields);

        if ($toDo){
            return  response()->json([
                'status' => 200,
                'message' => 'To-Do Added Successfully',
            ], 200);
        } else {
            return  response()->json([
                'status' => 500,
                'message' => 'Something went wrong',
            ], 500);
        }
        
        
        // [
        //     'status' => '200', 
        //     'toDo' => $toDo
        // ];
    }

    /**
     * Display the specified resource.
     */
    public function show(ToDo $toDo)
    {
        return [
            'status' => '200', 
            'toDo' => $toDo
        ];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ToDo $toDo)
    {
        $fields = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'status' => 'required'
        ]);

        $toDo->update($fields);

        if ($toDo){
            return  response()->json([
                'status' => 200,
                'message' => 'To-Do Updated Successfully',
            ], 200);
        } else {
            return  response()->json([
                'status' => 500,
                'message' => 'Something went wrong',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ToDo $toDo)
    {
        $toDo->delete();

        return [
            'status' => '200',
            'message' => 'The To-Do was deleted'
        ];
    }
}
