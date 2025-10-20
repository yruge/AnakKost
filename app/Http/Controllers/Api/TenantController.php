<?php

namespace App\Http\Controllers\Api;


use App\Models\Room;
use App\Models\Tenant;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TenantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tenants = Tenant::all();

        return response()->json([
            'status' => 'success',
            'data' => $tenants,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'phone_number' => 'required|string',
            'move_in_date' => 'required|date',
            'room_id' => 'required|integer|exists:rooms,id,status,available',            
        ]);  

        if($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        $tenant = Tenant::create($validator->validated());

        $room = Room::find($tenant -> room_id);
        $room->update(['status' => 'occupied']);

        return response()->json([
            'status' => 'success',
            'message' => 'Tenant created successfully',
            'data' => $tenant,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tenant = Tenant::find($id);

        if(!$tenant)
        {
            return response()->json([
                'message' => 'Tenant not found',
            ], 404);
        }

        // return view('show', ['tenant' => $tenant]);
        return response()->json([
            'message' => 'Tenant Found',
            'data' => $tenant,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'phone_number' => 'required|string',
        ]);

        $tenant = Tenant::find($id);

        if(!$tenant)
        {
            return response()->json([
                'message' => 'Can not find tenant',
            ], 404);
        }

        $tenant->update([
            'name' => $validated['name'],
            'phone_number' => $validated['phone_number'],
        ]);

        return response()->json([
            'message' => 'Successfully updated',
            'tenant' => $tenant,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tenant = Tenant::find($id);

        if($tenant)
        {
            $room_id = $tenant->room_id;
            $tenant->delete();

            $room = Room::find($room_id);

            if($room)
            {
                $room->status = 'available';
                $room->save();
            }
        }
        else
        {
            return response()->json([
                'message' => 'ID Not Found',
            ], 400);
        }

        return response()->json([
            'message' => 'Tenant successfully checked out. Room status updated to available.',
        ], 200);
    }
}
