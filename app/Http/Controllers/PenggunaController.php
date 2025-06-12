<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class PenggunaController extends Controller
{
    public function index(Request $request)
    {
        // Search
        $search = $request->query('search');
        $typeFilter = $request->query('type'); // terima dari URL query
        $query = User::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('jawatan', 'like', '%' . $search . '%')
                    ->orWhere('jabatan', 'like', '%' . $search . '%');
            });
        }

        if ($typeFilter !== null && in_array($typeFilter, ['1', '2', '3', '4'])) {
            $query->where('type', $typeFilter);
        }

        // Sorting
        $sort = $request->query('sort');
        if ($sort) {
            if ($sort == 'name_asc') {
                $query->orderBy('name', 'asc');
            } elseif ($sort == 'name_desc') {
                $query->orderBy('name', 'desc');
            }
        } else {
            // Default: sort by name ascending
            $query->orderBy('name', 'asc');
        }

        $users = $query->paginate(10)->appends($request->query());

        return view('pengguna.pengguna', compact('users'));
    }

    public function create()
    {
        return view('pengguna.create');  // This is the view where you can add a new user
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'notel' => 'required|string|max:15',
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[a-z]/',      // mesti ada huruf kecil
                'regex:/[A-Z]/',      // mesti ada huruf besar
                'regex:/[0-9]/',      // mesti ada nombor
                'regex:/[\W_]/',      // mesti ada simbol
            ],
            'type' => 'required|integer|in:1,2,3,4',
            'jawatan' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
        ],
        [
            'password.regex' => 'Kata laluan mesti sekurang-kurangnya 8 aksara, mengandungi huruf besar, huruf kecil, nombor dan simbol.',
        ]);

        // dd('Validated type: ' . $validated['type']);

        // Create the new user
        $user = new User();
        $user->name = ucwords(strtolower($validated['name']));
        $user->notel = $validated['notel'];
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['password']);
        $user->type = $validated['type'];
        $user->jawatan = ucwords(strtolower($validated['jawatan']));
        $user->jabatan = $validated['jabatan'];

        $user->id_pekerja = $user->generateIdPekerja($user->type);

        $user->save();

        // Redirect or return with a success message
        return redirect()->route('pengguna')->with('success', 'Pengguna baru berjaya didaftarkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'notel' => 'nullable|string|max:15',
            'email' => 'required|email|unique:users,email,' . $id,
            'jawatan' => 'nullable',
            'jabatan' => 'nullable',
            'type' => 'required|in:1,2,3,4',
        ]);

        $user = User::findOrFail($id);
        $user->update($request->only(['name', 'email', 'jawatan', 'jabatan', 'type', 'notel']));

        return redirect()->route('pengguna')->with('success', 'Pengguna berjaya dikemaskini.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->permohonan()->delete();  // Padam semua permohonan berkaitan

        $user->delete();

        return redirect()->route('pengguna')->with('success', 'Pengguna berjaya dipadam.');
    }
}
