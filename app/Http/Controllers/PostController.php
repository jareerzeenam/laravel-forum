<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\TopicResource;
use App\Models\Post;
use App\Models\Topic;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use function dd;
use function redirect;
use function to_route;

class PostController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Post::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Topic $topic = null)
    {
        $posts = Post::with(['user','topic'])
            ->when($topic, fn(Builder $query) => $query->whereBelongsTo($topic))
            ->when(
                $request->query('query'),
                fn(Builder $query) => $query->whereAny(['title','body'], 'like', '%'.$request->query('query').'%')
            )
            ->latest()
            ->latest('id')
            ->paginate()
            ->withQueryString();

        return inertia('Posts/Index',[
            'posts' => PostResource::collection($posts),
            'topics' => fn() => TopicResource::collection(Topic::all()),
            'selectedTopic' => fn () => $topic ? TopicResource::make($topic) : null,
            'query' => $request->query('query'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Posts/Create',[
            'topics' => fn() => TopicResource::collection(Topic::all()),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'min:10', 'max:120'],
            'topic_id' => ['required','exists:topics,id'],
            'body' => ['required', 'string','min:100', 'max:10000'],
        ]);

        $post = Post::create([
            ...$data,
            'user_id' => $request->user()->id,
        ]);


        return redirect($post->showRoute());
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Post $post)
    {
        if (! Str::endsWith($post->showRoute(), $request->path())) {
            return redirect($post->showRoute($request->query()), status: 301);
        }

        $post->load('user','topic');
        return inertia('Posts/Show', [
            'post' => fn () => PostResource::make($post)->withLikePermission(),
            'comments' => function () use ($post) {
                $commentResource =  CommentResource::collection($post->comments()->with('user')->latest()->latest('id')->paginate(5));
                $commentResource->collection->transform(fn ($resource) => $resource->withLikePermission());

                return $commentResource;
            },
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
