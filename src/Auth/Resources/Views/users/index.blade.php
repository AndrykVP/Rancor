@extends('rancor::layouts.main')

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8">
         <div class="row flex justify-between">
            {!! $users->links() !!}
         </div>
         <div class="card mb-4">
            <div class="card-header">
               {{ __('List of users') }}
            </div>
            <div class="card-body">
               <table class="table table-striped">
                  <thead>
                     <tr>
                        <th scope="col">#</th>
                        <th scope="col">Handle</th>
                        <th scope="col">Email</th>
                        <th scope="col">Actions</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach($users as $user)
                    <tr>
                        <th scope="row">{{ $user->id }}</th>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                           <a href="{{ route('users.show',$user) }}" class="btn btn-primary btn-sm">{{ __('View') }}</a>
                           <a href="{{ route('users.edit',$user) }}" class="btn btn-success btn-sm">{{ __('Edit') }}</a>
                           <a href="{{ route('users.destroy',$user) }}" class="btn btn-danger btn-sm"
                              onclick="event.preventDefault();
                              document.getElementById('{{ 'delete-user-' . $user->id }}').submit();">
                              {{ __('Delete') }}
                           </a>

                           <form id="{{ 'delete-user-' . $user->id }}" action="{{ route('users.destroy',$user) }}" method="POST" style="display: none;">
                              @method('DELETE')
                              @csrf
                           </form>
                        </td>
                    </tr>
                    @endforeach
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection