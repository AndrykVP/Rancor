@extends(config('rancor.layout'))

@section('content')
<div class="container">
   <div class="row justify-between mb-4">
      <div class="col-6">
         <a class="btn btn-primary" href="{{ route('scanner.index')}}">Search</a>
         <a class="btn btn-success" href="{{ route('entries.create')}}">Upload</a>
      </div>
   </div>
   <div class="card">
      <div class="card-header">{{ __('Showing Entry') . ' #' . $entry->id }}<br />Last Scanned by {{ $entry->contributor->name }}<br />{{ $entry->updated_at->format(config('rancor.dateFormat'))}}</div>
      <div class="card-body">
         <div class="row mb-4">
            <div class="col-md-4">
               <h6 class="text-uppercase text-bold text-sm">Information</h6>
               <strong>Entity ID:</strong> #{{ $entry->entity_id }}<br />
               <strong>Type:</strong> {{ $entry->type }}<br />
               <strong>Name:</strong> {{ $entry->name }}<br />
               <strong>Owner:</strong> {{ $entry->owner }}
            </div>
            <div class="col-md-4">
               <h6 class="text-uppercase text-bold text-sm">Last Known Position</h6>
               <strong>System:</strong> ({{ $entry->position['galaxy']['x'] }}, {{ $entry->position['galaxy']['y'] }})<br />
               <strong>Orbit:</strong> ({{ $entry->position['system']['x'] }}, {{ $entry->position['system']['y'] }})
               @if(array_key_exists('surface', $entry->position))
               <br/><strong>Surface:</strong> ({{ $entry->position['surface']['x'] }}, {{ $entry->position['surface']['y'] }})
               @endif
               @if(array_key_exists('ground', $entry->position))
               <br/><strong>Ground:</strong> ({{ $entry->position['ground']['x'] }}, {{ $entry->position['ground']['y'] }})
               @endif
            </div>
         </div>
         <div class="row">
            <div class="col">
               <h4>Changelog</h4>
               <table class="table">
                  <thead>
                     <tr>
                        <th>Changes</th>
                        <th>Contributor</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach($entry->changelog as $log)
                     <tr>
                        <td>
                           @if($log->old_type)
                           <strong>Type:</strong> <span class="text-danger">{{ $log->old_type }}</span> -> <span class="text-success">{{ $log->new_type }}</span>
                           @endif
                           @if($log->old_name)
                           <strong>Name:</strong> <span class="text-danger">{{ $log->old_name }}</span> -> <span class="text-success">{{ $log->new_name }}</span>
                           @endif
                           @if($log->old_owner)
                           <strong>Owner:</strong> <span class="text-danger">{{ $log->old_owner }}</span> -> <span class="text-success">{{ $log->new_owner }}</span>
                           @endif
                        </td>
                        <td>
                           Updated by {{ $log->contributor->name }}<br />
                           {{ $log->created_at->format(config('rancor.dateFormat')) }}
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