<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVehicleRequest;
use App\Http\Requests\UpdateVehicleRequest;
use App\Http\Requests\DeleteVehicle;
use App\Models\Vehicle;
use App\Models\User;
use Illuminate\Http\Request;


class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreVehicleRequest $request)
    {
        $data = $request->validated();
        $user = $request->user();
        if ($user) {
            $driver = $user->driver;
            if ($driver) {
                $vehicle = $driver->vehicles()->create([
                    'make' => $data['make'],
                    'license_plate' => $data['license_plate'],
                    'model' => $data['model'],
                    'color' => $data['color'],
                    'year' => $data['year'],
                    'driver_id' => $driver->id,
                ]);
                return response()->json($vehicle, 201);
            }
        }
        return response()->json(['message' => 'Driver not found']);
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $user = auth()->user();
        if ($user) {
            $driver = $user->driver;
            if ($driver) {
                $vehicles = $driver->vehicles;
                return response()->json($vehicles);
            }
        }
        return response()->json(['message' => 'Driver or vehicles not found']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vehicle $vehicle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVehicleRequest $request, Vehicle $vehicle)
    {
        $user = $request->user();
        if ($user) {
            $driver = $user->driver;
            if ($driver) {
                $vehicle = $vehicle->where('driver_id', $driver->id)->where('license_plate', $request->license_plate)->first();
                if ($vehicle) {
                    $data = $request->validated();
                    $vehicle->update($data);
                    return response()->json($vehicle);
                }
            }
        }
        return response()->json(['message' => 'Driver or vehicle not found'], 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteVehicle $request, Vehicle $vehicle)
    {
        $data = $request->validated();
        $user = $request->user();
        if ($user) {
            $driver = $user->driver;
            if ($driver) {
                $vehicle = $vehicle->where('driver_id', $driver->id)->where('license_plate', $data['license_plate'])->first();
                if ($vehicle) {
                    $vehicle->delete();
                    return response()->json(['message' => 'Vehicle deleted'], 200);
                }
            }
        }
    }
}
