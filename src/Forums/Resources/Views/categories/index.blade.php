@extends('rancor::layouts.main')

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8">
         <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="/forums/" id="index-breadcrumb">{{ __('Index') }}</a></li>
               <li class="breadcrumb-item active">{{ __('Categories') }}</li>
            </ol>
         </nav>
         <div class="d-flex flex-row justify-content-between align-items-center mb-2">
            <div class="btn-group">
               <a class="btn btn-sm btn-success" href="{{ route('forums.categories.create') }}">New Category</a>
            </div>
         </div>
         <div class="card mb-4">
            <div class="card-header">
               {{ __('List of Categories') }}
            </div>
            <div class="card-body">
               <table class="table table-striped">
                  <thead>
                    <tr>
                      <th scope="col">Order</th>
                      <th scope="col">Title</th>
                      <th scope="col">Color</th>
                      <th scope="col">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                     @foreach($categories as $category)
                     <tr>
                        <th scope="row">{{ $category->order }}</th>
                        <td>{{ $category->title }}</td>
                        <td>
                           <svg fill="{{ $category->color }}" height="20" width="20" class="bi bi-bootstrap-fill">
                              <circle cx="10" cy="10" r="10" fill-rule="evenodd" />
                           </svg>
                        </td>
                        <td>
                           <div class="btn-group">
                              <a class="btn btn-sm btn-success" href="/forums/{{ $category->slug }}">{{ _('Visit') }}</a>
                              <a class="btn btn-sm btn-primary" href="{{ route('forums.categories.edit',['category' => $category]) }}">{{ _('Edit') }}</a>
                              <a class="btn btn-sm btn-danger" href="#">{{ _('Delete') }}</a>
                           </div>
                        </td>
                     </tr>
                     @endforeach
                  </tbody>
                </table>
            </div>
      </div>
   </div>
</div>
@endsection