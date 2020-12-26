@extends('rancor::layouts.main')

@section('content')

<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8">
         <div class="card mb-4">
            <div class="card-header">
               {{ __('New Tag') }}
            </div>
            <div class="card-body">
               <form action="{{ route('tags.store') }}" method="POST">
                  @csrf
                  <div class="form-group">
                     <label for="name">Tag Name</label>
                     <input type="text" class="form-control" name="name" id="name" aria-describedby="nameHelp" placeholder="Enter a new tag name" autofocus required value="{{ old('name') }}">
                     @error('name')
                     <small id="nameHelp" class="form-text text-danger">{{ $message }}</small>
                     @enderror
                  </div>
                  <div class="form-group">
                     <label for="color">Color</label>
                     <input type="color" class="form-control" name="color" id="color" aria-describedby="colorHelp" required value="{{ old('color') }}">
                     @error('color')
                     <small id="colorHelp" class="form-text text-danger">{{ $message }}</small>
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