@extends('rancor::layouts.main')

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8">
         <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="/forums/" id="index-breadcrumb">{{ __('Index') }}</a></li>
               <li class="breadcrumb-item"><a href="/forums/categories" id="category-breadcrumb">{{ __('Categories') }}</a></li>
               <li class="breadcrumb-item"><a href="/forums/{{$category->slug}}" id="id-breadcrumb">{{ __($category->title) }}</a></li>
               <li class="breadcrumb-item active">{{ __('Edit') }}</li>
            </ol>
         </nav>
         <div class="card mb-4">
            <div class="card-header">
               {{ __('Edit Category "'.$category->title).'"' }}
            </div>
            <div class="card-body">
               <form action="/forums/categories/{{ $category->id}}" method="POST">
                  @method('PATCH')
                  @csrf
                  <input type="hidden" name="id" id="id" value="{{ $category->id }}">
                  <div class="form-group">
                     <label for="title">Title</label>
                     <input type="text" class="form-control @error('title')border border-danger @enderror" name="title" id="title" aria-describedby="titleHelp" value="{{ $category->title }}">
                     @error('title')
                     <small id="titleHelp" class="form-text text-danger">{{ $message }}</small>
                     @enderror
                  </div>
                  <div class="form-group">
                     <label for="slug">Slug</label>
                     <input type="text" class="form-control @error('slug')border border-danger @enderror" name="slug" id="slug" aria-describedby="slugHelp" value="{{ $category->slug }}">
                     @error('slug')
                     <small id="slugHelp" class="form-text text-danger">{{ $message }}</small>
                     @enderror
                  </div>
                  <div class="row">
                     <div class="col">
                        <div class="form-group">
                           <label for="color">Color</label>
                           <input type="color" class="form-control @error('color')border border-danger @enderror" name="color" id="color" aria-describedby="colorHelp" value="{{ $category->color }}">
                           @error('color')
                           <small id="colorHelp" class="form-text text-danger">{{ $message }}</small>
                           @enderror
                        </div>
                     </div>
                     <div class="col">
                        <div class="form-group">
                           <label for="order">Display Order</label>
                           <input type="number" class="form-control @error('order')border border-danger @enderror" name="order" id="order" aria-describedby="orderHelp" value="{{ $category->order }}">
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