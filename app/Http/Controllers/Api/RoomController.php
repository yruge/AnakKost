<?php

namespace App\Http\Controllers\Api;

use App\Models\Room;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::all();
        foreach ($rooms as $room) {
            $room->status = Str::title($room->status);
            $room->price_per_month = Str::of("Rp, ")->append($room->price_per_month);
        }
        return view('owner.room', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'room number' => 'required|string|max:3',
            'price_per_month' => 'required|integer|in:8000000,1000000,1200000',
            'size' => 'required|string|in:4x5m,5x5m,6x6m',
        ];

        $validator = Validator::make($request->all(), $rules);
        
        if($validator->fails())
        {
            return response()->json([
                'message' => 'Room not successfully created',
                'errors' => $validator->errors(),
            ], 422);
        }

        $roomValidated = $validator->validated();

        $roomCreated = Room::create($roomValidated);

        return response()->json([
            'message' => 'Success',
            'data' => $roomCreated,
        ], 200);        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $room = Room::find($id);
        
        if(!$room)
        {
            return response()->json([
                'message' => 'ID Not Found',
            ], 400);
        }
        
        return response()->json([
            'message' => 'Success',
            'data' => $room,
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = [
            'room number' => 'required|string|max:3',
            'price_per_month' => 'required|integer|in:8000000,1000000,1200000',
            'size' => 'required|string|in:4x5m,5x5m,6x6m',
        ];

        $validator = Validator::make($request->all(), $rules);

        $roomValidated = $validator->validated();

        $room = Room::find($id);

        if(!$room)
        {
            return response()->json([
                'message' => 'Update data failed', 
                'Error' => $validator->errors(),
            ]);
        }
        
        $room->update($roomValidated);
        $room->save();

        return response()->json([
            'message' => 'Update data success',
            'data' => $room,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $room = Room::find($id);

        if(!$room)
        {
            return response()->json([
                'message' => 'Room not found',
            ]);
        }

        $room->delete();

        return response()->json([
            'message' => 'Room deleted',
        ]);
    }
}
