@extends('rancor::layouts.admin')

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-10">
         <div class="row mb-4">
            <div class="col text-right">
               <a href="{{ route('profile.show', $user) }}" class="btn btn-success">View Profile</a>
               <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">Update</a>
            </div>
         </div>
         <div class="card mb-4">
            <div class="card-header">
               {{ $user->name }}
            </div>
            <div class="card-body">
               <div class="row mb-2">
                  <div class="col-4 text-right">ID:</div>
                  <div class="col-8">{{ $user->id }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Handle:</div>
                  <div class="col-8">{{ $user->name }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Email:</div>
                  <div class="col-8">{{ $user->email }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Faction:</div>
                  <div class="col-8">{{ $user->rank->department->faction->name }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Department:</div>
                  <div class="col-8">{{ $user->rank->department->name }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Rank:</div>
                  <div class="col-8">{{ $user->rank->name }}</div>
               </div>
               @if($user->roles->isNotEmpty())
               <div class="row mb-2">
                  <div class="col-4 text-right">Roles:</div>
                  <div class="col-8">
                     <ul class="list">
                        @if($user->is_admin)
                        <li>Super Admin</li>
                        @endif
                        @foreach($user->roles as $role)
                        <li>{{ $role->name }}</li>
                        @endforeach
                     </ul>
                  </div>
               </div>
               @endif
               <div class="row mb-2">
                  <div class="col-4 text-right">Joined:</div>
                  <div class="col-8">{{ $user->created_at->diffForHumans() }}</div>
               </div>
            </div>
         </div>
         <div class="card mb-4">
            <div class="card-header">
               {{ __('History') }}
            </div>
            <div class="card-body">
               @foreach($user->changelog as $log)
               <div class="text-sm border-bottom pb-2 mb-2">
                  <span class="text-{{ $log->color }}" style="color:{{ $log->color }}">
                     {{ $log->action }}
                  </span>
                  <small>
                     <span>{{ $log->created_at->diffForHumans() }}</span>
                     @if($log->has('creator'))
                        By <a href="{{ route('profile.show', $log->creator) }}">{{  $log->creator->name  }}</a>
                     @endif
                  </small>
               </div>
               @endforeach
            </div>
         </div>
      </div>
   </div>
</div>
@endsection