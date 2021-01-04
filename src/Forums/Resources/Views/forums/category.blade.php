@extends('rancor::layouts.main')

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col">
         <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{ route('forums.index') }}" id="index-breadcrumb">{{ __('Index') }}</a></li>
               <li class="breadcrumb-item active">{{ $category->name }}</li>
            </ol>
         </nav>
         @include('rancor::forums.includes.categoryactions', ['category' => $category])
         @include('rancor::forums.includes.categorycard', ['category' => $category])
      </div>
   </div>
</div>
@endsection