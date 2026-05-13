<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function create()
    {
        return view('admin.create-admin');
    }

    public function store(Request $request)
    {
        $request->validate([
            'studentid' => 'required|unique:users',
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        User::create([
            'studentid' => $request->studentid,
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'admin'
        ]);

        return back()->with('success', 'Admin created successfully!');
    }

    public function listAdmins(Request $request)
    {
        $query = User::where('role', 'admin');

        // 🔍 Search function
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                ->orWhere('email', 'like', "%{$request->search}%")
                ->orWhere('studentid', 'like', "%{$request->search}%");
            });
        }

        $admins = $query->latest()->get();

        return view('admin.admin-list', compact('admins'));
    }

    public function edit($id)
    {
        $admin = User::findOrFail($id);

        return view('admin.edit-admin', compact('admin'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'nullable|min:8|confirmed',
        ]);

        $admin = User::findOrFail($id);

        // update basic info
        $admin->name = $request->name;
        $admin->email = $request->email;

        // 🔐 update password only if filled
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'confirmed|min:6'
            ]);

            $admin->password = Hash::make($request->password);
        }

        $admin->save();

        return redirect()->route('admin.list')->with('success', 'Admin updated successfully!');
    }

    public function destroy($id)
    {
        $admin = User::findOrFail($id);

        // ⚠️ prevent deleting yourself (optional but recommended)
        if ($admin->id == auth()->id()) {
            return back()->with('error', 'You cannot delete your own account!');
        }

        $admin->delete();

        return back()->with('success', 'Admin deleted successfully!');
    }
}