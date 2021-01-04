@extends('rancor::layouts.main')

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8">
         <div class="row flex justify-between align-items-center mb-4">
            <div class="col">
               {!! $models->links() !!}
            </div>
            @if(Route::has('admin.'.$resource['route'].'.create'))
            <div class="col text-right">
               <a href="{{ route('admin.'.$resource['route'].'.create') }}" class="btn btn-primary">{{ __('New'.' '.$resource['name'])}} </a>
            </div>
            @endif
         </div>
         <div class="card mb-4">
            <div class="card-header">
               {{ __($resource['name'] . ' List') }}
            </div>
            <div class="card-body">
               <table class="table table-striped">
                  <thead>
                     <tr>
                        <th scope="col">{{ __('ID') }}</th>
                        <th scope="col">{{ __('Name') }}</th>
                        <th scope="col">{{ __('Actions') }}</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach($models as $model)
                    <tr>
                        <th scope="row">{{ $model->id }}</th>
                        <td>{{ $model->name }}</td>
                        <td>
                           @if(Route::has('admin.'.$resource['route'].'.show'))
                           <a href="{{ route('admin.'.$resource['route'].'.show',$model) }}" class="btn btn-primary text-white btn-sm" title="{{ __('View') }}">
                              <svg width="18" height="18" stroke="none" fill="currentColor" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" preserveAspectRatio="xMidYMid meet" data-attributes-set=",xmlns:xlink,xmlns,viewBox,preserveAspectRatio">
                                 <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                 <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                              </svg>
                           </a>
                           @endif
                           @if(Route::has('admin.'.$resource['route'].'.edit'))
                           <a href="{{ route('admin.'.$resource['route'].'.edit',$model) }}" class="btn btn-success btn-sm" title="{{ __('Edit') }}">
                              <svg width="18" height="18" stroke="none" fill="currentColor" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" preserveAspectRatio="xMidYMid meet" data-attributes-set=",xmlns:xlink,xmlns,viewBox,preserveAspectRatio">
                                 <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zm-2.207 2.207L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                              </svg>
                           </a>
                           @endif
                           @if(Route::has('admin.'.$resource['route'].'.destroy'))
                           <a href="{{ route('admin.'.$resource['route'].'.destroy',$model) }}" class="btn btn-danger btn-sm" title="{{ __('Delete') }}"
                           onclick="event.preventDefault();
                           document.getElementById('{{ 'delete-model-' . $model->id }}').submit();">
                              <svg width="18" height="18" stroke="none" fill="currentColor" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" preserveAspectRatio="xMidYMid meet" data-attributes-set=",xmlns:xlink,xmlns,viewBox,preserveAspectRatio">
                                 <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                              </svg>
                           </a>
                           @endif

                           <form id="{{ 'delete-model-' . $model->id }}" action="{{ route('admin.'.$resource['route'].'.destroy',$model) }}" method="POST" style="display: none;">
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