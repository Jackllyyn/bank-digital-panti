<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function index()
    {
        $staffs = User::where('role', 'staff')
            ->orderBy('name')
            ->paginate(15);

        return view('admin.staff.index', compact('staffs'));
    }

    public function create()
    {
        return view('admin.staff.create');
    }

   public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|confirmed|min:6',
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'staff',
    ]);

    return redirect()
        ->route('admin.staff.index')
        ->with('success', "Staff '{$request->name}' berhasil ditambahkan! Staff bisa login dengan email: {$request->email} dan password yang sudah dibuat.");
}

    public function edit(User $staff)
    {
        // Pastikan hanya staff yang bisa diedit
        if ($staff->role !== 'staff') {
            abort(404);
        }

        return view('admin.staff.edit', compact('staff'));
    }

    public function update(Request $request, User $staff)
    {
        if ($staff->role !== 'staff') {
            abort(404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $staff->id,
            'password' => 'nullable|confirmed|min:6',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $staff->update($data);

        return redirect()
            ->route('admin.staff.index')
            ->with('success', 'Staff berhasil diperbarui');
    }

    public function destroy(User $staff)
    {
        if ($staff->role !== 'staff') {
            abort(404);
        }

        $staff->delete();

        return back()->with('success', 'Staff berhasil dihapus');
    }
}