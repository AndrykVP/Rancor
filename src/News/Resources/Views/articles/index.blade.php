@extends('rancor::layouts.main')

@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8">
            <div class="row flex justify-between">
               <div class="col">
                  {!! $articles->links() !!}
               </div>
               <div class="col">
               <a href="{{ route('articles.create') }}" class="btn btn-primary">New Article</a>
            </div>
         </div>
         <div class="card mb-4">
            <div class="card-header">
               {{ __('List of Articles') }}
            </div>
            <div class="card-body">
               <table class="table table-striped">
                  <thead>
                     <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach($articles as $article)
                    <tr>
                        <th scope="row">{{ $article->id }}</th>
                        <td>{{ $article->title }}</td>
                        <td class="text-{{ $article->is_published ? "success" : "danger" }}">{{ $article->is_published ? "Published" : "Drafted" }}</td>
                        <td>
                           <a href="{{ route('articles.show',$article) }}" class="btn btn-primary btn-sm">{{ __('View') }}</a>
                           <a href="{{ route('articles.edit',$article) }}" class="btn btn-success btn-sm">{{ __('Edit') }}</a>
                           <a href="{{ route('articles.destroy',$article) }}" class="btn btn-danger btn-sm"
                              onclick="event.preventDefault();
                              document.getElementById('{{ 'delete-article-' . $article->id }}').submit();">
                              {{ __('Delete') }}
                           </a>

                           <form id="{{ 'delete-article-' . $article->id }}" action="{{ route('articles.destroy',$article) }}" method="POST" style="display: none;">
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