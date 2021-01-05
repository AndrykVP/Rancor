@extends('rancor::layouts.admin')

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8">
         <div class="row mb-4">
            <div class="col text-right">
               <a href="{{ route('admin.boards.edit', $board) }}" class="btn btn-primary">Update</a>
            </div>
         </div>
         <div class="card mb-4">
            <div class="card-header">
               {{ $board->name }}
            </div>
            <div class="card-body">
               <div class="row mb-2">
                  <div class="col-4 text-right">ID:</div>
                  <div class="col-8">{{ $board->id }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Name:</div>
                  <div class="col-8">{{ $board->name }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">URL:</div>
                  <div class="col-8">{{ $board->slug }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Description:</div>
                  <div class="col-8">{{ $board->description }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Category:</div>
                  <div class="col-8">{{ $board->category->name }}</div>
               </div>
               @if($board->parent != null)
               <div class="row mb-2">
                  <div class="col-4 text-right">Parent Board:</div>
                  <div class="col-8">{{ $board->parent->name }}</div>
               </div>
               @endif
               <div class="row mb-2">
                  <div class="col-4 text-right">Total Discussions:</div>
                  <div class="col-8">{{ number_format($board->discussions_count) }}</div>
               </div>
               @if($board->children->isNotEmpty())
               <div class="row mb-2">
                  <div class="col-4 text-right">Children Boards:</div>
                  <div class="col-8">
                     <ul>
                        @foreach($board->children as $child)
                        <li>{{ $child->name }}</li>
                        @endforeach
                     </ul>
                  </div>
               </div>
               @endif
               @if($board->groups->isNotEmpty())
               <div class="row mb-2">
                  <div class="col-4 text-right">Groups:</div>
                  <div class="col-8">
                     <ul>
                        @foreach($board->groups as $group)
                        <li>{{ $group->name }}</li>
                        @endforeach
                     </ul>
                  </div>
               </div>
               @endif
               @if($board->moderators->isNotEmpty())
               <div class="row mb-2">
                  <div class="col-4 text-right">Moderators:</div>
                  <div class="col-8">
                     <ul>
                        @foreach($board->moderators as $moderator)
                        <li>{{ $moderator->name }}</li>
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