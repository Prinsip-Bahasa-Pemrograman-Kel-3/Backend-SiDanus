<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controller;
use app\Helpers\APIFormatter;
use App\Events\UserStatusUpdated;
use App\Events\TestBroadcastEvent;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->get();
        return response()->json($users);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role_id' => 'nullable|exists:roles,id',
            'current_team_id' => 'nullable|integer'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'current_team_id' => $request->current_team_id
        ]);

        return response()->json([
            'message' => 'User created successfully',
            'data' => $user
        ], 201);
    }

    public function show(string $id)
    {
        $user = user::with('role')->find($id);

        if (!$user) {
            return response()->json([
                'message' => 'user not found'
            ], 404);
        }

        return response()->json($user);
    }

    public function update(Request $request, string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'sometimes|required|string|min:8',
            'role_id' => 'nullable|exists:roles,id',
            'current_team_id' => 'nullable|integer',
        ]);

        $user->name = $request->name ?? $user->name;
        $user->email = $request->email ?? $user->email;
        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->role_id = $request->role_id ?? $user->role_id;
        $user->current_team_id = $request->current_team_id ?? $user->current_team_id;

        $user->save();

        return response()->json([
            'message' => 'User updated successfully',
            'data' => $user
        ]);
    }

    public function destroy(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully'
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'is_active' => 'required|boolean',
        ]);

        $user = User::findOrFail($id);
        $user->is_active = $request->is_active;
        $user->save();

        broadcast(new UserStatusUpdated($user))->toOthers();

        return APIFormatter::createAPI(200, 'User status updated successfully', 'success', $user);
    }

    public function getActiveUsers()
    {
        $activeUsers = User::where('is_active', true)->get();

        return APIFormatter::createAPI(200, 'Active users retrieved successfully', 'success', $activeUsers);
    }

    public function broadcastMessage(Request $request)
    {
        $message = $request->input('message', 'Default test message');
        
        // Trigger event broadcast
        broadcast(new TestBroadcastEvent($message));
        
        return response()->json(['status' => 'Message broadcasted!', 'message' => $message]);
    }
}
