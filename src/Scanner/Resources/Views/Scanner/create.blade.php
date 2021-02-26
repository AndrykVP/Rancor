@extends(config('rancor.layout'))

@section('content')
<div class="container">
   <div class="row justify-content-center mb-4">
      <div class="col-md-8">
         <div class="card">
             <div class="card-header">{{ __('Upload XML Scans') }}</div>

             <div class="card-body">
               <form action="{{ route('scanner.upload')}}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="custom-file mb-4">
                     <input type="file" class="custom-file-input" id="files" name="files[]" multiple aria-describedby="filesHelp">
                     <label class="custom-file-label" for="files">Choose file</label>

                     @error('files')
                     <small id="filesHelp" class="form-text text-muted">
                        {{ $message }}
                     </small>
                     @enderror
                  </div>

                  <div class="form-group row mb-0">
                     <div class="col-md-8">
                         <button type="submit" class="btn btn-primary">
                             {{ __('Upload') }}
                         </button>
                     </div>
                 </div>
               </form>
             </div>
         </div>
      </div>
   </div>
</div>
@endsection