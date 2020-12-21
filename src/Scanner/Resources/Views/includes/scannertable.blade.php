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
            <strong>Owner:</strong> {{ $entry->owner }}<br />
            <a class="btn btn-success btn-sm" href="{{ route('entries.show', ['entry' => $entry]) }}">View Changelog</a>
         </td>
         <td>
            <strong>System:</strong> ({{ $entry->position['galaxy']['x'] }}, {{ $entry->position['galaxy']['y'] }})<br />
            <strong>Orbit:</strong> ({{ $entry->position['system']['x'] }}, {{ $entry->position['system']['y'] }})
            @if(array_key_exists('surface', $entry->position))
            <br/><strong>Surface:</strong> ({{ $entry->position['surface']['x'] }}, {{ $entry->position['surface']['y'] }})
            @endif
            @if(array_key_exists('ground', $entry->position))
            <br/><strong>Ground:</strong> ({{ $entry->position['ground']['x'] }}, {{ $entry->position['ground']['y'] }})
            @endif
         </td>
         <td>
            On {{ $entry->last_seen->format(config('rancor.dateFormat')) }}<br />
            By {{ $entry->contributor->name }}
         </td>
      </tr>
      @endforeach
   </tbody>
</table>