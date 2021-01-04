@extends('rancor::layouts.main')

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8">
         <div class="card mb-4">
            <div class="card-header">
               {{ __('Edit Reply') }}
            </div>
            <div class="card-body">
               <form action="{{ route('forums.replies.update', ['reply' => $reply])}}" method="POST">
                  @csrf
                  <input type="hidden" name="discussion_id" value="{{ $reply->discussion_id }}">
                  <div class="form-group">
                     <label for="body">{{ __('Content') }}</label>
                     <textarea
                     class="form-control @error('body')border border-danger @enderror"
                     name="body"
                     id="body"
                     aria-describedby="bodyHelp"
                     placeholder="Enter the Content"
                     required rows="7">{!! old('body') ?? $reply->body !!}</textarea>
                     @error('body')
                     <small id="bodyHelp" class="form-text text-danger">{{ $message }}</small>
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