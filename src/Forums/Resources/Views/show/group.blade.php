@extends('rancor::layouts.admin')

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8">
         <div class="row mb-4">
            <div class="col text-right">
               <a href="{{ route('admin.groups.edit', $group) }}" class="btn btn-primary">Update</a>
            </div>
         </div>
         <div class="card mb-4">
            <div class="card-header">
               {{ $group->name }}
            </div>
            <div class="card-body">
               <div class="row mb-2">
                  <div class="col-4 text-right">ID:</div>
                  <div class="col-8">{{ $group->id }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Name:</div>
                  <div class="col-8">{{ $group->name }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Description:</div>
                  <div class="col-8">{{ $group->description }}</div>
               </div>
               @if($group->categories->isNotEmpty())
               <div class="row mb-2">
                  <div class="col-4 text-right">Categories:</div>
                  <div class="col-8">
                     <ul>
                        @foreach($group->categories as $category)
                        <li>{{ $category->name }}</li>
                        @endforeach
                     </ul>
                  </div>
               </div>
               @endif
               @if($group->boards->isNotEmpty())
               <div class="row mb-2">
                  <div class="col-4 text-right">Boards:</div>
                  <div class="col-8">
                     <ul>
                        @foreach($group->boards as $board)
                        <li>{{ $board->name }}</li>
                        @endforeach
                     </ul>
                  </div>
               </div>
               @endif
               @if($group->users->isNotEmpty())
               <div class="row mb-2">
                  <div class="col-4 text-right">Users:</div>
                  <div class="col-8">
                     <ul>
                        @foreach($group->users as $user)
                        <li>{{ $user->name }}</li>
                        @endforeach
                     </ul>
                  </div>
               </div>
               @endif
            </div>
         </div>
      </div>
   </div>
</div>
@endsection