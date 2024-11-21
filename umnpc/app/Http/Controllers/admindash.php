<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class admindash extends Controller
{
    public function index()
    {
        // Calculate the required statistics
        $totalUsers = User::count(); // Total number of users
        $userUsers = User::where('roles', 'user')->count(); // Users with 'user' role
        $pendingUsers = User::where('is_approved', false)->count(); // Users pending approval

        // Pass these variables to the view
        return view('admin.dashboard', [
            'totalUsers' => $totalUsers,
            'userUsers' => $userUsers,
            'pendingUsers' => $pendingUsers,
        ]);
    }

    public function manageUsers(Request $request)
    {
        $query = User::query();
    
        // Pencarian
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }
    
        // Filter berdasarkan tanggal
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }
    
        // Pagination dengan 10 item per halaman
        $users = $query->paginate(10);
    
        return view('admin.manage-users', compact('users'));
    }
    

    public function updateUser(Request $request, User $user)
    {
        try {
            // Validate the incoming request
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
            ]);

            // Update the user
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            
            // Explicitly handle the is_approved checkbox
            $user->is_approved = $request->has('is_approved') ? 1 : 0;
            
            $user->save();

            // Redirect with success message
            return redirect()->route('admin.manage-users')->with('success', 'User updated successfully.');
        } catch (\Exception $e) {
            // Log the error
            \Log::error('User update error: ' . $e->getMessage());
            
            // Redirect with error message
            return redirect()->back()->withInput()->with('error', 'Failed to update user: ' . $e->getMessage());
        }
    }

    // Menghapus pengguna
    public function deleteUser(User $user)
    {
        $user->delete();

        return redirect()->route('admin.manage-users')->with('success', 'User deleted successfully.');
    }

// Di dalam AdminDash Controller
    public function userApprovals()
    {
        // Mengambil semua pengguna yang belum disetujui
        $users = User::where('is_approved', false)->get();

        // Mengirim data pengguna ke view
        return view('admin.approvals', compact('users'));
    }


// Di dalam AdminDash Controller
    public function approveUser(User $user)
    {
        // Mengupdate status approval user
        $user->is_approved = true;
        $user->save();

        // Redirect dengan pesan sukses
        return redirect()->route('admin.approvals')->with('success', 'User approved successfully!');
    }


    public function bulkApprove(Request $request)
    {
        // Ambil data user_ids dari form
        $userIds = $request->input('user_ids');

        // Jika tidak ada checkbox yang dipilih
        if (!$userIds || count($userIds) === 0) {
            return redirect()->route('admin.approvals')->with('error', 'No users selected for approval.');
        }

        // Lanjutkan proses approve
        User::whereIn('id', $userIds)->update(['is_approved' => true]);

        // Redirect dengan pesan sukses
        return redirect()->route('admin.approvals')->with('success', 'Selected users approved successfully!');
    }

    public function settings()
    {
        return view('admin.settings');
    }
}