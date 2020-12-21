@extends(config('rancor.forums.layout'))

@section('content')
<div class="container">
   <div class="row justify-content-center mb-4">
      <div class="col-md-10">
         <form action="{{ route('scanner.search')}}" method="POST">
            @csrf
            <div class="form-row align-items-center">
               <div class="col-9">
                  <label class="sr-only" for="query">Search Query</label>
                  <div class="input-group mb-2">
                     <div class="input-group-prepend">
                        <div class="input-group-text">@</div>
                     </div>
                     <input type="text" class="form-control @error('value') is-invalid @enderror" id="query" name="value" value="{{ old('value') }}" placeholder="Search Query" autofocus required>
                  </div>
                  @error('value')
                     <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                     </span>
                  @enderror
               </div>
               <div class="col-auto">
                  <button type="submit" class="btn btn-primary mb-2">Search</button>
               </div>
            </div>
            <div class="form-row align-items-center">
               <div class="col-8">
                  <div class="form-check form-check-inline">
                     <input class="form-check-input" name="attribute" type="radio" id="entity_id" value="entity_id" checked>
                     <label class="form-check-label" for="entity_id">
                        ID
                     </label>
                  </div>
                  <div class="form-check form-check-inline">
                     <input class="form-check-input" name="attribute" type="radio" id="type" value="type">
                     <label class="form-check-label" for="type">
                        {{ __('Type') }}
                     </label>
                  </div>
                  <div class="form-check form-check-inline">
                     <input class="form-check-input" name="attribute" type="radio" id="name" value="name">
                     <label class="form-check-label" for="name">
                        {{ __('Name') }}
                     </label>
                  </div>
                  <div class="form-check form-check-inline">
                     <input class="form-check-input" name="attribute" type="radio" id="owner" value="owner">
                     <label class="form-check-label" for="owner">
                        {{ __('Owner') }}
                     </label>
                  </div>

                  @error('attribute')
                     <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                     </span>
                  @enderror
               </div>
            </div>
         </form>
      </div>
   </div>
   <div class="row justify-content-center">
      @if(isset($query))
      <div class="col">
         {!! $query->links() !!}
         
         <div class="card">
            <div class="card-header">{{ __('Search Results') }}</div>
            @include('rancor::includes.scannertable', ['entries' => $query] )
         </div>
      </div>
      @endif
   </div>
</div>
@endsection