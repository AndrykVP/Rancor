@extends('rancor::layouts.main')

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8">
         <div class="row mb-4">
            <div class="col text-right">
               <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-primary">Update</a>
            </div>
         </div>
         <div class="card mb-4">
            <div class="card-header">
               {{ $category->name }}
            </div>
            <div class="card-body">
               <div class="row mb-2">
                  <div class="col-4 text-right">ID:</div>
                  <div class="col-8">{{ $category->id }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Name:</div>
                  <div class="col-8">{{ $category->name }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">URL:</div>
                  <div class="col-8">{{ $category->slug }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Description:</div>
                  <div class="col-8">{{ $category->description }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Color:</div>
                  <div class="col-8">{{ strtoupper($category->color) }}
                     <svg fill="{{ $category->color }}" height="20" width="20" class="bi bi-bootstrap-fill">
                        <circle cx="10" cy="10" r="10" fill-rule="evenodd" />
                     </svg>
                  </div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Total Boards:</div>
                  <div class="col-8">{{ number_format($category->boards_count) }}</div>
               </div>
               <div class="row mb-2">
                  <div class="col-4 text-right">Total Discussions:</div>
                  <div class="col-8">{{ number_format($category->discussions_count) }}</div>
               </div>
               @if($category->groups->isNotEmpty())
               <div class="row mb-2">
                  <div class="col-4 text-right">Groups:</div>
                  <div class="col-8">
                     <ul>
                        @foreach($category->groups as $group)
                        <li>{{ $group->name }}</li>
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