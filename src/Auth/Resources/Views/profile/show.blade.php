@extends('rancor::layouts.main')

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col">
         <div class="row mb-4 align-items-center">
            <div class="col"><h3>{{ __('User Profile') }}</h3></div>
            <div class="col text-right">
               <a href="{{ route('forums.replies.index', ['user' => $user]) }}" class="btn btn-primary">Forum Replies</a>
               @if($user->id === Auth::id())
               <a href="{{ route('profile.edit') }}" class="btn btn-primary">Update</a>
               @endif
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
                        <div class="col-4 text-right">Handle:</div>
                        <div class="col-8">{{ $user->name }}</div>
                     </div>
                     <div class="row mb-2">
                        <div class="col-4 text-right">Nickname:</div>
                        <div class="col-8">{{ $user->nickname }}</div>
                     </div>
                     @if($user->show_email)
                     <div class="row mb-2">
                        <div class="col-4 text-right">Email:</div>
                        <div class="col-8">{{ $user->email }}</div>
                     </div>
                     @endif
                     <div class="row mb-2">
                        <div class="col-4 text-right">Quote:</div>
                        <div class="col-8"><i>"{{ $user->quote }}"</i></div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-6">
               <div class="row">
                  <div class="col-12">
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
                           <div class="row mb-2">
                              <div class="col-4 text-right">Joined:</div>
                              <div class="col-8">{{ $user->created_at->diffForHumans() }}</div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-12">
                     <div class="card mb-4">
                        <div class="card-header">{{ __('Forum Activity') }}</div>
                        <div class="card-body">
                           <div class="row mb-2">
                              <div class="col-4 text-right">Started Discussions:</div>
                              <div class="col-8">{{ number_format($user->boards_count) }}</div>
                           </div>
                           <div class="row mb-2">
                              <div class="col-4 text-right">Total Replies:</div>
                              <div class="col-8">{{ number_format($user->replies_count) }}</div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection