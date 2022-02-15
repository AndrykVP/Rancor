<?php

namespace Rancor\Auth\Services;

use Illuminate\Support\Facades\DB;
use Rancor\Audit\Events\UserAwards;
use Rancor\Audit\Events\UserUpdate;
use Rancor\Auth\Http\Requests\UserForm;
use App\Models\User;

class AdminUpdatesUser
{
   /**
    * Updates the given User model based on Permissions
    *
    * @param \Rancor\Auth\Http\Requests\UserForm  $request
    * @param \App\Models\User  $user
    */
   public function __invoke(UserForm $request, User &$user)
   {           
      $data = $request->validated();
      $generateId = false;
      DB::transaction(function () use(&$user, $data, $request, &$generateId) {

         // Change User Data
         if($request->user()->can('update', $user))
         {
            $user->first_name = $data['first_name'];
            $user->last_name = $data['last_name'];
            $user->email = $data['email'];
            $user->nickname = $data['nickname'];
            if($user->isDirty('first_name') || $user->isDirty('last_name') || $user->isDirty('nickname')) $generateId = true;
            $user->quote = $data['quote'];
            $user->avatar = $data['avatar'];
            $user->signature = $data['signature'];
         }
         
         // Change User Rank
         if($request->user()->can('changeRank', $user))
         {
            $user->rank_id = $data['rank_id'];
            $user->duty = $data['duty'];
            if($user->isDirty('rank_id') || $user->isDirty('duty')) $generateId = true;
         }

         // Upload Artwork
         if($request->user()->can('uploadArt', $user))
         {
            if($request->hasFile('avatarFile'))
            {
               $avatarPath = $request->file('avatarFile')->storeAs('images/avatars/', $user->id . '.png', 'idgen');
               $generateId = true;
            }
            if($request->hasFile('signatureFile'))
            {
               $signaturePath = $request->file('signatureFile')->storeAs('images/signatures/', $user->id . '.png', 'idgen');
               $generateId = true;
            }
         }

         // Sync Related Models
         if($request->has('roles') && $request->user()->can('changeRoles', $user))
         {
            $user->roles()->sync($data['roles']);
         }
         if($request->has('awards') && $request->user()->can('changeAwards', $user))
         {
            UserAwards::dispatch($user, $data['awards']);
            $user->awards()->sync($data['awards']);
         }
         if($request->has('groups') && $request->user()->can('changeGroups', $user))
         {
            $user->groups()->sync($data['groups']);
         }

         // Update User Model in Database
         $user->save();
      });

      UserUpdate::dispatch($user, $generateId);
   }
}