@extends(config('rancor.forums.layout'))

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col">
         <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="/forums/" id="index-breadcrumb">{{ __('Index') }}</a></li>
            </ol>
         </nav>
         @foreach($categories as $category)
         @include('rancor::forums.includes.categorycard', ['category' => $category])
         @endforeach
      </div>
   </div>
</div>
@endsection