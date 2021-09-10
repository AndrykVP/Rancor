<?php

namespace AndrykVP\Rancor\Auth\Services;

use Illuminate\Support\Facades\DB;
use AndrykVP\Rancor\Audit\Events\UserAwards;
use AndrykVP\Rancor\Auth\Http\Requests\UserForm;
use App\Models\User;

class AdminUpdatesUser
{
   /**
    * Updates the given User model based on Permissions
    *
    * @param \AndrykVP\Rancor\Auth\Http\Requests\UserForm  $request
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
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->nickname = $data['nickname'];
            $user->quote = $data['quote'];
            $user->avatar = $data['avatar'];
            $user->signature = $data['signature'];
         }

         // Change User Rank
         if($request->user()->can('changeRank', $user))
         {
            $user->rank_id = $data['rank_id'];
         }

         // Upload Artwork
         if($request->user()->can('uploadArt', $user))
         {
            if($request->hasFile('avatarFile'))
            {
               $avatarPath = $request->file('avatarFile')->storePubliclyAs('ids/avatars/', $user->id . '.png', 'public');
            }
            if($request->hasFile('signatureFile'))
            {
               $signaturePath = $request->file('signatureFile')->storePubliclyAs('ids/signatures/', $user->id . '.png', 'public');
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

   }
}