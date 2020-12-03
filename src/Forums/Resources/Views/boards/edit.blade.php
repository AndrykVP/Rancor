@extends(config('rancor.forums.layout'))

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8">
         <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="/forums/" id="index-breadcrumb">{{ __('Index') }}</a></li>
               <li class="breadcrumb-item"><a href="/forums/{{$board->category->slug}}" id="category-breadcrumb">{{ __($board->category->title) }}</a></li>
               <li class="breadcrumb-item"><a href="/forums/{{$board->category->slug}}/{{$board->slug}}" id="board-breadcrumb">{{ __($board->title) }}</a></li>
               <li class="breadcrumb-item active">{{ __('Edit') }}</li>
            </ol>
         </nav>
         <div class="card mb-4">
            <div class="card-header">
               {{ __('Edit Board "'.$board->title).'"' }}
            </div>
            <div class="card-body">
               <form action="/forums/boards/{{ $board->id}}" method="POST">
                  @method('PATCH')
                  @csrf
                  <input type="hidden" name="id" id="id" value="{{ $board->id }}">
                  <div class="form-group">
                     <label for="title">Title</label>
                     <input type="text" class="form-control @error('title')border border-danger @enderror" name="title" id="title" aria-describedby="titleHelp" value="{{ $board->title }}">
                     @error('title')
                     <small id="titleHelp" class="form-text text-danger">{{ $message }}</small>
                     @enderror
                  </div>
                  <div class="form-group">
                     <label for="slug">Slug</label>
                     <input type="text" class="form-control @error('slug')border border-danger @enderror" name="slug" id="slug" aria-describedby="slugHelp" value="{{ $board->slug }}">
                     @error('slug')
                     <small id="slugHelp" class="form-text text-danger">{{ $message }}</small>
                     @enderror
                  </div>
                  <div class="form-group">
                     <label for="description">Description</label>
                     <textarea class="form-control @error('description')border border-danger @enderror" name="description" id="description" aria-describedby="descriptionHelp">{{ $board->description }}</textarea>
                     @error('description')
                     <small id="descriptionHelp" class="form-text text-danger">{{ $message }}</small>
                     @enderror
                  </div>
                  <div class="form-group">
                     <label for="category">Category</label>
                     <select class="form-control @error('category_id')border border-danger @enderror" name="category_id" id="category" aria-describedby="categoryHelp">
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                        @endforeach
                     </select>
                     @error('category_id')
                     <small id="categoryHelp" class="form-text text-danger">{{ $message }}</small>
                     @enderror
                  </div>
                  <div class="form-group">
                     <label for="board">Parent Board</label>
                     <select class="form-control @error('parent_id')border border-danger @enderror" name="parent_id" id="board" aria-describedby="boardHelp">
                        <option value="">None</option>
                        @foreach($boards as $board)
                        <option value="{{ $board->id }}">{{ $board->title }}</option>
                        @endforeach
                     </select>
                     @error('parent_id')
                     <small id="groupHelp" class="form-text text-danger">{{ $message }}</small>
                     @enderror
                  </div>
                  <div class="form-group">
                     <label for="order">Display Order</label>
                     <input type="number" class="form-control @error('order')border border-danger @enderror" name="order" id="order" aria-describedby="orderHelp" value="{{ $board->order }}">
                     @error('order')
                     <small id="orderHelp" class="form-text text-danger">{{ $message }}</small>
                     @enderror
                  </div>
                  <div class="form-group">
                     <label for="groups">Groups</label>
                     <select multiple class="form-control @error('groups')border border-danger @enderror" name="groups[]" id="groups" aria-describedby="groupsHelp">
                        @foreach($groups as $group)
                        <option value="{{ $group->id }}" {{ $board->groups->contains($group) ? 'selected' : ''}}>{{ $group->name }}</option>
                        @endforeach
                     </select>
                     @error('groups')
                     <small id="groupHelp" class="form-text text-danger">{{ $message }}</small>
                     @enderror
                  </div>
                  <button type="submit" class="btn btn-primary">Submit</button>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection