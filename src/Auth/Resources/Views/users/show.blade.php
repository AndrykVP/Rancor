@extends('rancor::layouts.main')

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col">
         <div class="row mb-4 align-items-center">
            <div class="col"><h6>{{ __('User Profile') }}</h6></div>
            <div class="col text-right">
               <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">Update</a>
            </div>
         </div>
         <div class="row">
            <div class="col-md-6">
               <div class="card mb-4">
                  <div class="card-header">{{ __('Identity') }}</div>
                  <div class="card-body">
                     <div class="row align-items-end mb-2">
                        <div class="col-4 text-right">Avatar:</div>
                        <div class="col-8"><img src="{{ $user->avatar }}" /></div>
                     </div>
                     <div class="row mb-2">
                        <div class="col-4 text-right">ID:</div>
                        <div class="col-8">{{ $user->id }}</div>
                     </div>
                     <div class="row mb-2">
                        <div class="col-4 text-right">Handle:</div>
                        <div class="col-8">{{ $user->name }}</div>
                     </div>
                     <div class="row mb-2">
                        <div class="col-4 text-right">Nickname:</div>
                        <div class="col-8">{{ $user->nickname }}</div>
                     </div>
                     <div class="row mb-2">
                        <div class="col-4 text-right">Email:</div>
                        <div class="col-8">{{ $user->email }}</div>
                     </div>
                     <div class="row mb-2">
                        <div class="col-4 text-right">Quote:</div>
                        <div class="col-8"><i>"{{ $user->quote }}"</i></div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-6">
               <div class="card mb-4">
                  <div class="card-header">{{ __('Service') }}</div>
                  <div class="card-body">
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
            </div>
            <div class="col-12">
               <div class="card mb-4">
                  <div class="card-header">{{ __('History') }}</div>
                  <div class="card-body">
                     <table class="table table-striped">
                        <thead>
                           <tr>
                              <th scope="col">Date</th>
                              <th scope="col">Action</th>
                              <th scope="col">Updated By</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach($user->changelog as $log)
                           <tr>
                              <td scope="row">
                                 {{ $log->created_at->diffForHumans() }}
                              </td>
                              <td scope="row" style="color:{{ $log->color }}" class="text-{{ $log->color }}">
                                 {{ $log->action }}
                              </td>
                              <td scope="row">
                                 {{ $log->has('creator') ? $log->creator->name : '-' }}
                              </td>
                           </tr>
                           @endforeach
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection