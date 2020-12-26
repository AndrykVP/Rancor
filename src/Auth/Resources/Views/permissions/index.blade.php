@extends('rancor::layouts.main')

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8">
         <div class="row flex justify-between">
            {!! $permissions->links() !!}
         </div>
         <div class="card mb-4">
            <div class="card-header">
               {{ __('List of Permissions') }}
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
                     @foreach($permissions as $permission)
                    <tr>
                        <th scope="row">{{ $permission->id }}</th>
                        <td>{{ $permission->name }}</td>
                        <td>{{ $permission->description }}</td>
                        <td>
                           <a href="{{ route('permissions.edit',$permission) }}" class="btn btn-success btn-sm">{{ __('Edit') }}</a>
                           <a href="{{ route('permissions.destroy',$permission) }}" class="btn btn-danger btn-sm"
                              onclick="event.preventDefault();
                              document.getElementById('{{ 'delete-permission-' . $permission->id }}').submit();">
                              {{ __('Delete') }}
                           </a>

                           <form id="{{ 'delete-permission-' . $permission->id }}" action="{{ route('permissions.destroy',$permission) }}" method="POST" style="display: none;">
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