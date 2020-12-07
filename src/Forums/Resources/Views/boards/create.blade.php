@extends(config('rancor.forums.layout'))

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8">
         <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="/forums/" id="index-breadcrumb">{{ __('Index') }}</a></li>
               <li class="breadcrumb-item"><a href="/forums/boards" id="board-breadcrumb">{{ __('Boards') }}</a></li>
               <li class="breadcrumb-item active">{{ __('Create') }}</li>
            </ol>
         </nav>
         <div class="card mb-4">
            <div class="card-header">
               {{ __('New '.($parentBoard != null ? 'Child ' : '').'Board'. ($selCategory != null ? ' on "'.$selCategory->title.'"' : ''))}}
            </div>
            <div class="card-body">
               <form action="/forums/boards" method="POST" onsubmit="document.getElementById('category').disabled = false; document.getElementById('board').disabled = false;" >
                  @csrf
                  <div class="form-group">
                     <label for="title">Title</label>
                     <input type="text" class="form-control" name="title" id="title" aria-describedby="titleHelp" placeholder="Enter a new title">
                     @error('title')
                     <small id="titleHelp" class="form-text text-danger">{{ $message }}</small>
                     @enderror
                  </div>
                  <div class="form-group">
                     <label for="slug">Slug</label>
                     <input type="text" class="form-control" name="slug" id="slug" aria-describedby="slugHelp" placeholder="A URL-friendly version of title">
                     @error('slug')
                     <small id="slugHelp" class="form-text text-danger">{{ $message }}</small>
                     @enderror
                  </div>
                  <div class="form-group">
                     <label for="description">Description</label>
                     <textarea class="form-control @error('description')border border-danger @enderror" name="description" id="description" aria-describedby="descriptionHelp"></textarea>
                     @error('description')
                     <small id="descriptionHelp" class="form-text text-danger">{{ $message }}</small>
                     @enderror
                  </div>
                  <div class="form-group">
                     <label for="category">Category</label>
                     <select class="form-control @error('category_id')border border-danger @enderror" name="category_id" id="category" aria-describedby="categoryHelp" {{ $selCategory != null ? 'disabled' : ''}}>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $selCategory != null && $selCategory->id === $category->id ? 'selected' : ''}}>{{ $category->title }}</option>
                        @endforeach
                     </select>
                     @error('category_id')
                     <small id="categoryHelp" class="form-text text-danger">{{ $message }}</small>
                     @enderror
                  </div>
                  <div class="form-group">
                     <label for="board">Parent Board</label>
                     <select class="form-control @error('parent_id')border border-danger @enderror" name="parent_id" id="board" aria-describedby="boardHelp" {{ $parentBoard != null ? 'disabled' : ''}}>
                        <option value="">None</option>
                        @foreach($boards as $board)
                        <option value="{{ $board->id }}" {{ $parentBoard != null && $parentBoard->id === $board->id ? 'selected' : ''}}>{{ $board->title }}</option>
                        @endforeach
                     </select>
                     @error('parent_id')
                     <small id="groupHelp" class="form-text text-danger">{{ $message }}</small>
                     @enderror
                  </div>
                  <div class="form-group">
                     <label for="order">Display Order</label>
                     <input type="number" class="form-control" name="order" id="order" aria-describedby="orderHelp" placeholder="Number of order">
                     @error('order')
                     <small id="orderHelp" class="form-text text-danger">{{ $message }}</small>
                     @enderror
                  </div>
                  <div class="form-group">
                     <label for="groups">Groups</label>
                     <select multiple class="form-control @error('groups')border border-danger @enderror" name="groups[]" id="groups" aria-describedby="groupsHelp">
                        @foreach($groups as $group)
                        <option value="{{ $group->id }}">{{ $group->name }}</option>
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