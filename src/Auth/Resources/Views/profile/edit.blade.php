@extends('rancor::layouts.main')

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8">
         <div class="card mb-4">
            <div class="card-header">
               {{ __('Edit User') }}
            </div>
            <div class="card-body">
               <form action="{{ route('profile.update')}}" method="POST">
                  @csrf
                  <input type="hidden" name="id" value="{{ $user->id }}">
                  @method('PATCH')
                  <div class="form-group">
                     <label for="name">Handle</label>
                     <input type="text" class="form-control @error('name')border border-danger @enderror" name="name" id="name" aria-describedby="nameHelp" placeholder="Enter a new name" autofocus value="{{ old('name') ? old('name') : $user->name }}">
                     @error('name')
                     <small id="nameHelp" class="form-text text-danger">{{ $message }}</small>
                     @enderror
                  </div>
                  <div class="form-group">
                     <label for="nickname">Nickname</label>
                     <input type="text" class="form-control @error('nickname')border border-danger @enderror" name="nickname" id="nickname" aria-describedby="nicknameHelp" placeholder="Enter a new nickname" value="{{ old('nickname') ? old('nickname') : $user->nickname }}">
                     @error('nickname')
                     <small id="nicknameHelp" class="form-text text-danger">{{ $message }}</small>
                     @enderror
                  </div>
                  <div class="form-group">
                     <label for="email">Email</label>
                     <input type="email" class="form-control @error('email')border border-danger @enderror" name="email" id="email" aria-describedby="emailHelp" placeholder="Enter a new email" value="{{ old('email') ? old('email') : $user->email }}">
                     @error('email')
                     <small id="emailHelp" class="form-text text-danger">{{ $message }}</small>
                     @enderror
                  </div>
                  <div class="form-group">
                     <label for="quote">Quote</label>
                     <input type="text" class="form-control @error('quote')border border-danger @enderror" name="quote" id="quote" aria-describedby="quoteHelp" placeholder="Enter a new quote" value="{{ old('quote') ? old('quote') : $user->quote }}">
                     @error('quote')
                     <small id="quoteHelp" class="form-text text-danger">{{ $message }}</small>
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