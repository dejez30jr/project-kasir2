<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string)$request->query('q', ''));
        $query = User::query()->orderBy('name');
        if ($search !== '') {
            $query->where(function($q) use ($search) {
                $q->where('name','like',"%{$search}%")
                  ->orWhere('email','like',"%{$search}%")
                  ->orWhere('role','like',"%{$search}%");
            });
        }
        $users = $query->paginate(20)->withQueryString();
        return view('users.index', compact('users','search'));
    }

    public function create()
    {
        $roles = ['admin' => 'Admin', 'cashier' => 'Kasir', 'user' => 'User'];
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:100'],
            'phone' => ['nullable','string','max:50'],
            'email' => ['required','email','max:150', Rule::unique('users','email')->whereNull('deleted_at')],
            'role' => ['required', Rule::in(['admin','cashier','user'])],
            'password' => ['required','string','min:6','confirmed'],
        ]);
        User::create([
            'name' => $data['name'],
            'phone' => $data['phone'] ?? null,
            'email' => $data['email'],
            'role' => $data['role'],
            'password' => $data['password'], // hashed by cast
        ]);
        return redirect()->route('users.index')->with('success','Pengguna berhasil dibuat.');
    }

    public function edit(User $user)
    {
        $roles = ['admin' => 'Admin', 'cashier' => 'Kasir', 'user' => 'User'];
        return view('users.edit', compact('user','roles'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => ['required','string','max:100'],
            'phone' => ['nullable','string','max:50'],
            'email' => ['required','email','max:150', Rule::unique('users','email')->ignore($user->id)->whereNull('deleted_at')],
            'role' => ['required', Rule::in(['admin','cashier','user'])],
            'password' => ['nullable','string','min:6','confirmed'],
        ]);

        $user->fill([
            'name' => $data['name'],
            'phone' => $data['phone'] ?? null,
            'email' => $data['email'],
            'role' => $data['role'],
        ]);
        if (!empty($data['password'])) {
            $user->password = $data['password']; // hashed by cast
        }
        $user->save();

        return redirect()->route('users.index')->with('success','Pengguna diperbarui.');
    }

    public function destroy(User $user)
    {
        // Tidak boleh hapus diri sendiri
        if (Auth::id() === $user->id) {
            return back()->with('warning','Tidak bisa menghapus akun sendiri.');
        }
        // Hindari menghapus admin terakhir
        if ($user->role === 'admin') {
            $adminCount = User::where('role','admin')->count();
            if ($adminCount <= 1) {
                return back()->with('warning','Tidak bisa menghapus admin terakhir.');
            }
        }
        $user->delete(); // soft delete
        return back()->with('success','Pengguna dihapus.');
    }

    public function resetPassword(Request $request, User $user)
    {
        $data = $request->validate([
            'new_password' => ['required','string','min:6','confirmed']
        ]);
        $user->password = $data['new_password']; // hashed by cast
        $user->save();
        return back()->with('success','Password pengguna telah direset.');
    }
}
