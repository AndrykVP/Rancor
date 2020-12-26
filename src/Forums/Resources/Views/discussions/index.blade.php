@extends('rancor::layouts.main')

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8">
         <div class="card mb-4">
            <div class="card-header">
               {{ __('List of boards') }}
            </div>
            <div class="card-body">
               <table class="table table-striped">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Title</th>
                      <th scope="col">Category</th>
                      <th scope="col">URL</th>
                      <th scope="col">Order</th>
                    </tr>
                  </thead>
                  <tbody>
                     @foreach($boards as $board)
                    <tr>
                      <th scope="row">{{ $board->id }}</th>
                      <td>{{ $board->title }}</td>
                      <td>{{ $board->category->title }}</td>
                      <td>{{ $board->slug }}</td>
                      <td>{{ $board->order }}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
            </div>
      </div>
   </div>
</div>
@endsection