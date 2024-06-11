<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDriverRequest;
use App\Http\Requests\UpdateDriverRequest;
use App\Http\Requests\ShowDriver;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Driver;

class DriverController extends Controller
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
    public function store(StoreDriverRequest $request)
    {
        $data = $request->validated();
        $user = User::create($data);
        $user->assignRole('Driver');
        return response()->json($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(ShowDriver $request)
    {
        $data = $request->validated();
        $user  = User::where('phone', $data['phone'])->where('user_type', 'Driver')->first();
        if ($user) {
            return response()->json($user);
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
}
