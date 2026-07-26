<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $users = User::query()
            ->when($request->filled('search'), fn ($q) => $q->where('name', 'like', '%'.$request->search.'%')
                ->orWhere('email', 'like', '%'.$request->search.'%'))
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function create(): View
    {
        return view('admin.users.create', ['user' => new User]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8', 'confirmed'],
            'role' => ['required', 'in:admin,editor'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => $validated['role'],
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user): View
    {
        $this->preventSelfDemoteGuard($user);

        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $this->preventSelfDemoteGuard($user);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,'.$user->id],
            'password' => ['nullable', 'min:8', 'confirmed'],
            'role' => ['required', 'in:admin,editor'],
        ]);

        if ($user->id !== Auth::id() && $validated['role'] !== 'admin') {
            $adminCount = User::where('role', 'admin')->count();
            $isLastAdmin = $adminCount === 1 && $user->role === 'admin';
            if ($isLastAdmin) {
                return back()->withInput()->withErrors(['role' => 'Cannot demote the last administrator.']);
            }
        }

        $update = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
        ];

        if (! empty($validated['password'])) {
            $update['password'] = $validated['password'];
        }

        $user->update($update);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === Auth::id()) {
            return back()->withErrors(['delete' => 'You cannot delete your own account.']);
        }

        $adminCount = User::where('role', 'admin')->count();
        if ($user->role === 'admin' && $adminCount <= 1) {
            return back()->withErrors(['delete' => 'Cannot delete the last administrator.']);
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    private function preventSelfDemoteGuard(User $user): void
    {
        if ($user->id === Auth::id()) {
            abort_if(\request()->isMethod('post') || \request()->isMethod('put') || \request()->isMethod('patch'), 403, 'You cannot modify your own account role via this form.');
        }
    }
}
