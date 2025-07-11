<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    /**
     * Show the dashboard
     */
    public function index()
    {
        $user = auth()->user();
        $stats = [
            'total_users' => $user->isAdmin() ? User::count() : null,
            'admin_users' => $user->isAdmin() ? User::where('role', 'admin')->count() : null,
            'regular_users' => $user->isAdmin() ? User::where('role', 'user')->count() : null,
        ];

        return view('dashboard.index', compact('user', 'stats'));
    }

    /**
     * Show the profile page
     */
    public function profile()
    {
        return view('dashboard.profile', ['user' => auth()->user()]);
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:1000',
            'password' => 'nullable|string|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/',
        ]);

        $updateData = $request->only(['name', 'email', 'phone', 'bio']);
        
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        return back()->with('success', 'Profile updated successfully!');
    }

    /**
     * Upload avatar
     */
    public function uploadAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = auth()->user();

        // Delete old avatar if exists
        if ($user->avatar && Storage::exists('public/avatars/' . basename($user->avatar))) {
            Storage::delete('public/avatars/' . basename($user->avatar));
        }

        // Store new avatar
        $file = $request->file('avatar');
        $filename = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('public/avatars', $filename);
        
        $avatarUrl = Storage::url($path);
        $user->update(['avatar' => $avatarUrl]);

        return back()->with('success', 'Avatar updated successfully!');
    }

    /**
     * Show users list (admin only)
     */
    public function users()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $users = User::paginate(10);
        return view('dashboard.users', compact('users'));
    }

    /**
     * Delete user (admin only)
     */
    public function deleteUser($id)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return back()->with('error', 'Cannot delete your own account');
        }

        // Delete avatar file if exists
        if ($user->avatar && Storage::exists('public/avatars/' . basename($user->avatar))) {
            Storage::delete('public/avatars/' . basename($user->avatar));
        }

        $user->delete();

        return back()->with('success', 'User deleted successfully!');
    }
}

