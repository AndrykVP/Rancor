@extends('rancor::layouts.main')

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8">
         <div class="card mb-4">
            <div class="card-header">
               {{ __('New Role') }}
            </div>
            <div class="card-body">
               <form action="{{ route('roles.create')}}" method="POST">
                  @csrf
                  <div class="form-group">
                     <label for="name">Name</label>
                     <input type="text" class="form-control @error('name')border border-danger @enderror" name="name" id="name" aria-describedby="nameHelp" placeholder="Enter a new name" autofocus value="{{ old('name') }}">
                     @error('name')
                     <small id="nameHelp" class="form-text text-danger">{{ $message }}</small>
                     @enderror
                  </div>
                  <div class="form-group">
                     <label for="description">Description</label>
                     <textarea class="form-control @error('description')border border-danger @enderror" name="description" id="description" aria-describedby="descriptionHelp" placeholder="Enter a new description" a>{{ old('description') }}</textarea>
                     @error('description')
                     <small id="descriptionHelp" class="form-text text-danger">{{ $message }}</small>
                     @enderror
                  </div>
                  <div class="form-group">
                     <label for="permissions">Permissions</label>
                     <select class="form-control @error('permissions')border border-danger @enderror" name="permissions[]" id="permissions" aria-describedby="permissionsHelp" multiple>
                        @foreach($permissions as $permission)
                        <option value="{{ $permission->id }}">{{ $permission->name}}</option>
                        @endforeach
                     </select>
                     @error('permissions')
                     <small id="permissionsHelp" class="form-text text-danger">{{ $message }}</small>
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