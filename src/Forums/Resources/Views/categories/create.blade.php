@extends(config('rancor.forums.layout'))

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8">
         <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="/forums/" id="index-breadcrumb">{{ __('Index') }}</a></li>
               <li class="breadcrumb-item active">{{ __('Create Categories') }}</li>
            </ol>
         </nav>
         <div class="card mb-4">
            <div class="card-header">
               {{ __('Create Forum Category') }}
            </div>
            <div class="card-body">
               <form action="/forums/categories" method="POST">
                  @csrf
                  <input type="hidden" name="id" id="id" value="{{ $category->id }}">
                  <div class="form-group">
                     <label for="title">Title</label>
                     <input type="text" class="form-control" name="title" id="title" aria-describedby="titleHelp" placeholder="Enter a new title">
                     @error('title')
                     <small id="titleHelp" class="form-text text-danger">{{ $message }}</small>
                     @enderror
                  </div>
                  <div class="form-group">
                     <label for="slug">Slug</label>
                     <input type="text" class="form-control" name="slug" id="slug" aria-describedby="slugHelp" placeholder="A URL-friendly version of title">
                     @error('slug')
                     <small id="slugHelp" class="form-text text-danger">{{ $message }}</small>
                     @enderror
                  </div>
                  <div class="row">
                     <div class="col">
                        <div class="form-group">
                           <label for="color">Color</label>
                           <input type="color" class="form-control" name="color" id="color" aria-describedby="colorHelp" placeholder="Category's color">
                           @error('color')
                           <small id="colorHelp" class="form-text text-danger">{{ $message }}</small>
                           @enderror
                        </div>
                     </div>
                     <div class="col">
                        <div class="form-group">
                           <label for="order">Display Order</label>
                           <input type="number" class="form-control" name="order" id="order" aria-describedby="orderHelp" placeholder="Number of order">
                           @error('order')
                           <small id="orderHelp" class="form-text text-danger">{{ $message }}</small>
                           @enderror
                        </div>
                     </div>
                  </div>
                  <button type="submit" class="btn btn-primary">Submit</button>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection