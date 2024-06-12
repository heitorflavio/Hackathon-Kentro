<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDriverRequest;
use App\Http\Requests\UpdateDriverRequest;
use App\Http\Requests\ShowDriver;
use App\Http\Requests\ChangeStatusDriver;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Driver;
use App\Models\Vehicle;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $drivers = Driver::where('is_available', 1)->get();
        return response()->json([
            'has_drivers' => $drivers->count() > 0 ? true : false,
            'message' => $drivers->count() > 0 ? 'Drivers available' : 'No drivers available',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDriverRequest $request)
    {
        $data = $request->validated();
        // return response()->json($data);
        $user = User::create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'user_type' => 'Driver'
        
        ]);

        $user->driver()->create([
            'license_number' => $data['license_number'],
            'license_expiry' => $data['license_expiry'],
            'user_id' => $user->id,
        ]);
        
        return response()->json($user->load('driver'));
    }

    /**
     * Display the specified resource.
     */
    public function show(ShowDriver $request)
    {
        $data = $request->validated();
        $user  = User::where('phone', $data['phone'])->where('user_type', 'Driver')->first();
        if ($user) {
            return response()->json($user->load('driver'));
        }
        return response()->json(['message' => 'Driver not found'], 404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Driver $driver)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDriverRequest $request, Driver $driver)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Driver $driver)
    {
        //
    }

    public function status(ChangeStatusDriver $request)
    {
        $data = $request->validated();
        $driver = auth()->user()->driver;
        $vehicles = Vehicle::where('driver_id', $driver->id)->where('default', 1)->get();

        if ($driver && $vehicles->count() > 0){
            $driver->update([
               'is_available' => $data['is_available']
            ]);
            return response()->json($driver);
        }

        return response()->json(['message' => 'Driver or vehicle not found'], 404);
    }
}
