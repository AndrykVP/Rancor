@extends('rancor::layouts.main')

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col">
         <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{ route('forums.index') }}" id="index-breadcrumb">{{ __('Index') }}</a></li>
               <li class="breadcrumb-item active">{{ __('Unread Posts') }}</li>
            </ol>
         </nav>
         <div class="row mb-4">
            <div class="col text-right">
               <a href="{{ route('forums.unread.mark') }}" class="btn btn-primary" title="{{ __('Mark All Read') }}"
               onclick="event.preventDefault();
               document.getElementById('markread').submit();">
                  {{ __('Mark All Read') }}
               </a>
               <form id="markread" action="{{ route('forums.unread.mark') }}" method="POST" style="display: none;">
                  @csrf
               </form>
            </div>
         </div>
         @include('rancor::forums.includes.discussionlist', ['header' => 'Unread Discussions', 'discussions' => $discussions])
      </div>
   </div>
</div>
@endsection