@extends('rancor::layouts.main')

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8">
         <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="/forums/" id="index-breadcrumb">{{ __('Index') }}</a></li>
               <li class="breadcrumb-item active">{{ __($category->title) }}</li>
            </ol>
         </nav>
         <div class="card mb-4">
            <div class="card-header">
               {{ __('Boards in "'.$category->title.'"') }}
            </div>
            <div class="card-body">
               <table class="table table-striped">
                  <thead>
                    <tr>
                      <th scope="col">Order</th>
                      <th scope="col">Title</th>
                      <th scope="col">URL</th>
                    </tr>
                  </thead>
                  <tbody>
                     @foreach($category->boards as $board)
                     <tr>
                        <th scope="row">{{ $board->order }}</th>
                        <td>{{ $board->title }}</td>
                        <td><a href="/forums/{{ $board->slug }}">{{ $board->slug }}</a></td>
                     </tr>
                     @endforeach
                  </tbody>
                </table>
            </div>
      </div>
   </div>
</div>
@endsection