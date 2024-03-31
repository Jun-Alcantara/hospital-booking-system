<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('id', '!=', Auth::user()->id)
            ->with('createdBy')
            ->get();

        return inertia('Console/Users/Index', compact('users'));
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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'unique:users|required',
            'role' => 'required',
            'defaultPassword' => 'required'
        ]);

        User::create([
            'name' => $validated['name'],
            'role_id' => $validated['role'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['defaultPassword']),
            'created_by' => Auth::user()->id,
            'status' => 1
        ]);

        return back()
            ->with('notification.success', 'A new user has been created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
