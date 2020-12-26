@extends('rancor::layouts.main')

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8">
         <div class="row flex justify-between">
            {!! $roles->links() !!}
         </div>
         <div class="card mb-4">
            <div class="card-header">
               {{ __('List of Roles') }}
            </div>
            <div class="card-body">
               <table class="table table-striped">
                  <thead>
                     <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach($roles as $role)
                    <tr>
                        <th scope="row">{{ $role->id }}</th>
                        <td>{{ $role->name }}</td>
                        <td>{{ $role->description }}</td>
                        <td>
                           <a href="{{ route('roles.edit',$role) }}" class="btn btn-success btn-sm">{{ __('Edit') }}</a>
                           <a href="{{ route('roles.destroy',$role) }}" class="btn btn-danger btn-sm"
                              onclick="event.preventDefault();
                              document.getElementById('{{ 'delete-role-' . $role->id }}').submit();">
                              {{ __('Delete') }}
                           </a>

                           <form id="{{ 'delete-role-' . $role->id }}" action="{{ route('roles.destroy',$role) }}" method="POST" style="display: none;">
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