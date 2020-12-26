@extends('rancor::layouts.main')

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8">
         <div class="card mb-4">
            <div class="card-header">
               {{ __('Edit Permission') }}
            </div>
            <div class="card-body">
               <form action="{{ route('permissions.update', $permission)}}" method="POST">
                  @csrf
                  <input type="hidden" name="id" value="{{ $permission->id }}">
                  @method('PATCH')
                  <div class="form-group">
                     <label for="name">Name</label>
                     <input type="text" class="form-control @error('name')border border-danger @enderror" name="name" id="name" aria-describedby="nameHelp" placeholder="Enter a new name" autofocus value="{{ old('name') ? old('name') : $permission->name }}">
                     @error('name')
                     <small id="nameHelp" class="form-text text-danger">{{ $message }}</small>
                     @enderror
                  </div>
                  <div class="form-group">
                     <label for="description">Description</label>
                     <textarea class="form-control @error('description')border border-danger @enderror" name="description" id="description" aria-describedby="descriptionHelp">{{ old('description') ? old('description') : $permission->description }}</textarea>
                     @error('description')
                     <small id="descriptionHelp" class="form-text text-danger">{{ $message }}</small>
                     @enderror
                  </div>
                  <button type="submit" class="btn btn-primary">Submit</button>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection