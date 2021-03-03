@extends('rancor::layouts.main')

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-12">
         <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{ route('holocron.index') }}" id="index-breadcrumb">{{ __('Index') }}</a></li>
               <li class="breadcrumb-item"><a href="{{ route('holocron.node.index') }}" id="node-breadcrumb">{{ __('Nodes') }}</a></li>
               <li class="breadcrumb-item active">{{ $node->name }}</li>
            </ol>
         </nav>
      </div>
      <div class="col-12">
         <div class="row justify-between">
            @can('update', $node)
            <a href="{{ route('admin.nodes.edit',$node) }}" class="btn btn-success" title="{{ __('Edit') }}">
               {{ __('Edit') }}
            </a>
            @endcan
            @can('delete', $node)
            <button class="btn btn-danger ml-2" title="{{ __('Delete') }}">
               {{ __('Delete') }}
            </button>
            @endcan
         </div>
      </div>
      <div class="col-12">
         <div class="card mb-4">
            <div class="card-header" id="heading{{ $node->id }}">
               {{ $node->name }}
            </div>

            <div id="{{ $node->id }}" aria-labelledby="heading{{ $node->id }}">
               <div class="card-body">
                  {!! $node->body !!}
                  <hr>
                  <div class="row">
                     <div class="col">
                        @foreach($node->collections as $collection)
                        <a href="{{ route('holocron.collection.show', ['collection' => $collection]) }}"><span class="badge badge-primary">{{ $collection->name }}</span></a>
                        @endforeach
                     </div>
                     <div class="col text-right">
                        <small>Created {{ $node->created_at->diffForHumans() }} by <a href="{{ route('admin.users.show', $node->author) }}">{{ $node->author->name }}</a></small><br />
                        @if($node->editor != null)
                        <small>Last edited {{ $node->updated_at->diffForHumans() }} by <a href="{{ route('admin.users.show', $node->editor) }}">{{ $node->editor->name }}</a></small><br />
                        @endif
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection