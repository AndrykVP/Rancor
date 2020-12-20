@extends(config('rancor.forums.layout'))

@section('content')
<div class="container">
   {!! $entries->links() !!}
   <div class="card">
      <table class="table">
         <thead>
            <tr>
               <th>ID</th>
               <th>Information</th>
               <th>Last Position</th>
               <th>Last Seen</th>
            </tr>
         </thead>
         <tbody>
            @foreach ($entries as $entry)
            <tr id="{{ $entry->id }}">
               <td>#{{ $entry->entity_id }}</td>
               <td>
                  <strong>Type:</strong> {{ $entry->type }}<br />
                  <strong>Name:</strong> {{ $entry->name }}<br />
                  <strong>Owner:</strong> {{ $entry->owner }}
               </td>
               <td>
                  <strong>System:</strong> (X, Y)<br />
                  <strong>Orbit:</strong> (X, Y)
               </td>
               <td>
                  On {{ $entry->last_seen->format(config('rancor.dateFormat')) }}<br />
                  By {{ $entry->contributor->name }}
               </td>
            </tr>
            @endforeach
         </tbody>
      </table>
   </div>
   {{-- {{ dd($entries) }} --}}
</div>
@endsection