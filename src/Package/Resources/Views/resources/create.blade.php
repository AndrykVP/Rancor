@extends('rancor::layouts.main')

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8">
         <div class="card mb-4">
            <div class="card-header">
               {{ __('New') . ' ' . __(ucfirst($resource['name'])) }}
            </div>
            <div class="card-body">
               <form action="{{ route('admin.'.$resource['route'].'.store')}}" method="POST">
                  @csrf
                  @method($form['method'])
                  @if(array_key_exists('hiddens',$form))
                     @foreach($form['hiddens'] as $field)
                     <input type="hidden" name="{{ $field['name'] }}" value="{{ $field['value'] }}">
                     @endforeach
                  @endif
                  @if(array_key_exists('inputs',$form))
                     @foreach($form['inputs'] as $field)
                     <div class="form-group">
                        <label for="{{ $field['name'] }}">{{ $field['label'] }}</label>
                        <input
                        type="{{ $field['type'] }}"
                        class="form-control @error($field['name'])border border-danger @enderror"
                        name="{{ $field['name'] }}"
                        id="{{ $field['name'] }}"
                        aria-describedby="{{ $field['name'] }}Help"
                        placeholder="Enter a new {{ $field['label'] }}"
                        {{ array_key_exists('attributes',$field) ? $field['attributes'] : ''}}
                        value="{{ $params[$field['name']] ?? old($field['name']) }}">
                        @error($field['name'])
                        <small id="{{ $field['name'] }}Help" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                     </div>
                     @endforeach
                  @endif
                  @if(array_key_exists('textareas',$form))
                     @foreach($form['textareas'] as $field)
                     <div class="form-group">
                        <label for="{{ $field['name'] }}">{{ $field['label'] }}</label>
                        <textarea
                        class="form-control @error($field['name'])border border-danger @enderror"
                        name="{{ $field['name'] }}"
                        id="{{ $field['name'] }}"
                        aria-describedby="{{ $field['name'] }}Help"
                        placeholder="Enter a new {{ $field['label'] }}"
                        {{ array_key_exists('attributes',$field) ? $field['attributes'] : ''}}>{!! $params[$field['name']] ?? old($field['name']) !!}</textarea>
                        @error($field['name'])
                        <small id="{{ $field['name'] }}Help" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                     </div>
                     @endforeach
                  @endif
                  @if(array_key_exists('selects',$form))
                     @foreach($form['selects'] as $field)
                     <div class="form-group">
                        <label for="{{ $field['name'] }}">{{ $field['label'] }}</label>
                        <select
                        class="form-control @error($field['name'])border border-danger @enderror"
                        name="{{ $field['name'].($field['multiple'] ? '[]' : '') }}"
                        id="{{ $field['name'] }}"
                        aria-describedby="{{ $field['name'] }}Help"
                        placeholder="Select a {{ $field['label'] }}"
                        {{ array_key_exists('attributes',$field) ? $field['attributes'] : ''}}>
                           @if(!$field['multiple'])
                           <option value="">Select a {{ $field['label'] }}</option>
                           @endif
                           @foreach($field['options'] as $option)
                           <option
                           value="{{ $option->id }}"
                           @if($field['multiple'])
                              @if(isset($params[$field['name']]))
                              {{ in_array($option->id, $params[$field['name']]) ? 'selected' : '' }}
                              @else
                              {{ old($field['name']) && in_array($option->id, old($field['name'])) ? 'selected' : ''}}
                              @endif
                           @else
                              @if(isset($params[$field['name']]))
                              {{ $params[$field['name']] == $option->id ? 'selected' : '' }}
                              @else
                              {{ old($field['name']) == $option->id ? 'selected' : ''}}
                              @endif
                           @endif>
                              {{ $option->name}}
                           </option>
                           @endforeach
                        </select>
                        @error($field['name'])
                        <small id="{{ $field['name'] }}Help" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                     </div>
                     @endforeach
                  @endif
                  @if(array_key_exists('checkboxes',$form))
                     @foreach($form['checkboxes'] as $field)
                     <div class="form-group">
                        <div class="form-check">
                           <input
                           type="checkbox"
                           class="form-check-input"
                           name="{{ $field['name'] }}"
                           id="{{ $field['name'] }}"
                           aria-describedby="{{ $field['name'] }}Help"
                           {{ old($field['name']) ? 'checked' : ''}}
                           {{ array_key_exists('attributes',$field) ? $field['attributes'] : ''}}>
                           <label for="{{ $field['name'] }}">{{ $field['label'] }}</label>
                        </div>
                        @error($field['name'])
                        <small id="{{ $field['name'] }}Help" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                     </div>
                     @endforeach
                  @endif
                  <button type="submit" class="btn btn-primary">Submit</button>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection