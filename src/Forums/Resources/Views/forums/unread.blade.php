@extends('rancor::layouts.main')

@section('content')
<div class="container">
   <nav class="col" aria-label="breadcrumb">
      <ol class="breadcrumb">
         <li class="breadcrumb-item"><a href="{{ route('forums.index') }}" id="index-breadcrumb">{{ __('Index') }}</a></li>
         <li class="breadcrumb-item active"><a href="{{ route('forums.unread') }}" id="unread-breadcrumb">{{ __('Unread Posts') }}</a></li>
      </ol>
   </nav>
   @if(session('success'))
   <div class="alert alert-success" role="alert">
      {{ session('success') }}
   </div>
   @endif
   @include('includes/discussionlist', ['header' => 'Unread Discussions', 'discussions' => $discussions])
</div>
@endsection