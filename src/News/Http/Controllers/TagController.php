<?php

namespace AndrykVP\Rancor\News\Http\Controllers;

use AndrykVP\Rancor\News\Tag;
use AndrykVP\Rancor\News\Http\Requests\TagForm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::paginate(config('rancor.pagination'));

        return view('rancor::tags.index',compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Tag::class);

        return view('rancor::tags.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \AndrykVP\Rancor\News\Http\Requests\TagForm  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagForm $request)
    {
        $this->authorize('create', Tag::class);

        $data = $request->validated();
        $tag = Tag::create($data);
        
        return redirect(route('tags.index'))->with('success','Tag "'. $tag->name .'" has been successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        $this->authorize('view', $tag);
        $tag->loadCount('articles');

        return view('rancor::tags.show',compact('tag'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        $this->authorize('update', $tag);
        
        return view('rancor::tags.edit',compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \AndrykVP\Rancor\News\Http\Requests\TagForm  $request
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(TagForm $request, Tag $tag)
    {
        $this->authorize('update', $tag);

        $data = $request->validated();
        $tag->update($data);
        
        return redirect(route('tags.index'))->with('success','Tag "'. $tag->name .'" has been successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $this->authorize('delete', $tag);
        $tag->delete();

        return redirect(route('tags.index'))->with('success','Tag "'. $tag->name .'" has been successfully deleted');
    }
}
