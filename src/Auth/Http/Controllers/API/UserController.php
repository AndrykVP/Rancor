<?php

namespace AndrykVP\Rancor\Auth\Http\Controllers\API;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use AndrykVP\Rancor\Auth\Http\Requests\BanForm;
use AndrykVP\Rancor\Auth\Http\Requests\UserForm;
use AndrykVP\Rancor\Auth\Http\Requests\UserSearch;
use AndrykVP\Rancor\Auth\Http\Resources\UserResource;
use AndrykVP\Rancor\Auth\Services\AdminUpdatesUser;
use App\Models\User;

class UserController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $this->authorize('viewAny',User::class);
        
        $query = User::paginate(config('rancor.pagination'));

        return UserResource::collection($query);
    }

    public function show(User $user): UserResource
    {
        $this->authorize('view', $user);

        $user->load('rank.department.faction', 'awards.type', 'permissions', 'roles', 'groups');

        return new UserResource($user);
    }

    public function update(UserForm $request, User $user, AdminUpdatesUser $service): JsonResponse
    {
        $this->authorize('update',$user);
        $service($request, $user);

        return response()->json([
            'message' => 'User "'.$user->name.'" has been updated'
        ], 200);
    }

    public function destroy(User $user): JsonResponse
    {
        $this->authorize('delete', $user);
        
        $user->delete();

        return response()->json([
            'message' => 'User "'.$user->name.'" has been deleted'
        ], 200);
    }

    public function search(UserSearch $request): AnonymousResourceCollection
    {
        $this->authorize('viewAny',User::class);
        $search = $request->validated();
        $users = User::where($search['attribute'], 'like', '%' . $search['value'] . '%')
                ->paginate(config('rancor.pagination'));

        return UserResource::collection($users);
    }

    public function ban(BanForm $request, User $user): JsonResponse
    {
        $this->authorize('ban', $user);

        $data = $request->validated();
        $user->is_banned = $data['status'];
        $user->is_admin = false;

        DB::transaction(function () use($user, $data) {
            $user->save();
            $user->bans()->create($data);
        });

        return response()->json([
            'message' => 'User "'.$user->name.'" has been ' . ($data['status'] ? 'banned' : 'unbanned')
        ], 200);
    }
}