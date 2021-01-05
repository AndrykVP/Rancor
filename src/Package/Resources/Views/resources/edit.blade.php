@extends('rancor::layouts.admin')

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8">
         <div class="card mb-4">
            <div class="card-header">
               {{ __('Edit') . ' ' . __(ucfirst($resource['name'])) }}
            </div>
            <div class="card-body">
               <form action="{{ route('admin.'.$resource['route'].'.update', $model)}}" method="POST">
                  @csrf
                  @method($form['method'])
                  <input type="hidden" name="id" value="{{ $model->id }}">
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
                        placeholder="Edit the {{ $field['label'] }}"
                        {{ array_key_exists('attributes',$field) ? $field['attributes'] : ''}}
                        value="{{ old($field['name']) ?? ($model->{$field['name']}) }}">
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
                        placeholder="Edit the {{ $field['label'] }}"
                        {{ array_key_exists('attributes',$field) ? $field['attributes'] : ''}}
                        >{!! old($field['name']) ?? ($model->{$field['name']}) !!}</textarea>
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
                           {{ $model->{$field['name']}->contains('id', $option->id) ? 'selected' : ''}}
                           @else
                           {{ $model->{$field['name']} == $option->id ? 'selected' : ''}}
                           @endif
                           >
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
                           id="{{ $field['name']}}"
                           aria-describedby="{{ $field['name'] }}Help"
                           {{ old($field['name']) || $model->{$field['name']} ? 'checked' : ''}}
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