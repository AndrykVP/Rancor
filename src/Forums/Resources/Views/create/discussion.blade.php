@extends('rancor::layouts.main')

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8">
         <div class="card mb-4">
            <div class="card-header">
               {{ __('New Discussion') }}
            </div>
            <div class="card-body">
               <form action="{{ route('forums.discussions.store')}}" method="POST">
                  @csrf
                  <input type="hidden" name="board_id" value="{{ $board->id }}">
                  <div class="form-group">
                     <label for="name">{{ __('Title') }}</label>
                     <input
                     type="text"
                     class="form-control @error('name')border border-danger @enderror"
                     name="name"
                     id="name"
                     aria-describedby="nameHelp"
                     placeholder="Enter a new Title"
                     autofocus required
                     value="{{ old('name') }}">
                     @error('name')
                     <small id="nameHelp" class="form-text text-danger">{{ $message }}</small>
                     @enderror
                  </div>
                  <div class="form-group">
                     <label for="body">{{ __('Content') }}</label>
                     <textarea
                     class="form-control @error('body')border border-danger @enderror"
                     name="body"
                     id="body"
                     aria-describedby="bodyHelp"
                     placeholder="Enter the Content"
                     required rows="7">{!! old('body') !!}</textarea>
                     @error('body')
                     <small id="bodyHelp" class="form-text text-danger">{{ $message }}</small>
                     @enderror
                  </div>
                  <div class="form-group">
                     <div class="form-check form-check-inline">
                        <input
                        type="checkbox"
                        class="form-check-input"
                        name="is_sticky"
                        id="is_sticky"
                        aria-describedby="is_stickyHelp"
                        {{ old('is_sticky') ? 'checked' : ''}}>
                        <label for="is_sticky">Make Sticky</label>
                     </div>
                     @error('is_sticky')
                     <small id="is_stickyHelp" class="form-text text-danger">{{ $message }}</small>
                     @enderror
                     <div class="form-check form-check-inline">
                        <input
                        type="checkbox"
                        class="form-check-input"
                        name="is_locked"
                        id="is_locked"
                        aria-describedby="is_lockedHelp"
                        {{ old('is_locked') ? 'checked' : ''}}>
                        <label for="is_locked">Locked</label>
                     </div>
                     @error('is_locked')
                     <small id="is_lockedHelp" class="form-text text-danger">{{ $message }}</small>
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