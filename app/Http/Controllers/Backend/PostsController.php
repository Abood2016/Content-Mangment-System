<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Http\Requests\backendRequests\StorePostRequest;
use App\Models\Post_images;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class PostsController extends Controller
{

    public function __construct()
    {
        if (auth()->check()) {
            $this->middleware('auth');
        } else {
            return view('backend.auth.login');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!\auth()->user()->ability('admin', 'manage_posts show_posts')) {
            return redirect('admin/index');
        }

        $keyword =     isset(\request()->keyword) && \request()->keyword != '' ? \request()->keyword : null;
        $categoryId =  isset(\request()->category_id) && \request()->category_id != '' ? \request()->category_id : null;
        $status =      isset(\request()->status) && \request()->status != '' ? \request()->status : null;
        $sort_by =     isset(\request()->sort_by) && \request()->sort_by != '' ? \request()->sort_by : 'id';
        $order_by =    isset(\request()->order_by) && \request()->order_by != '' ? \request()->order_by : 'desc';
        $limit_by =    isset(\request()->limit_by) && \request()->limit_by != '' ? \request()->limit_by : '10';

        $posts = Post::with(['user', 'category', 'comments'])->wherePostType('post');
        if ($keyword != null) {
            $posts = $posts->search($keyword);
        }
        if ($categoryId != null) {
            $posts = $posts->whereCategoryId($categoryId);
        }
        if ($status != null) {
            $posts = $posts->whereStatus($status);
        }

        $posts = $posts->orderBy($sort_by, $order_by);
        $posts = $posts->paginate($limit_by);

        $categories = Category::orderBy('id', 'desc')->select('id', 'name')->get();
        return view('backend.posts.index', compact('posts', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!\auth()->user()->ability('admin', 'create_posts')) {
            return redirect('admin/index');
        }
        $categories = Category::orderBy('id', 'desc')->select('id', 'name')->get();
        return view('backend.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        if (!\auth()->user()->ability('admin', 'create_posts')) {
            return redirect('admin/index');
        }

        $data['title']           = $request->title;
        $data['description']     = $request->description;
        $data['status']          = $request->status;
        $data['post_type']       = 'post';
        $data['comment_able']    = $request->comment_able;
        $data['category_id']     = $request->category_id;

        $post = auth()->user()->posts()->create($data);

        if ($request->images && count($request->images) > 0) {
            $i = 1;
            foreach ($request->images as $file) {
                $filename = $post->slug . '-' . time() . '-' . $i . '.' . $file->getClientOriginalExtension();
                $file_size = $file->getSize();
                $file_type = $file->getMimeType();
                $path = public_path('assets/posts/' . $filename);
                Image::make($file->getRealPath())->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path, 100);
                $post->media()->create([
                    'image_name' => $filename,
                    'image_size' => $file_size,
                    'image_type' => $file_type,
                ]);
                $i++;
            }
        }

        if ($request->status == 1) {
            Cache::forget('recent_posts');
        }

        return redirect()->route('admin.posts.index')->with([
            'message' => 'Post Added Successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!\auth()->user()->ability('admin', 'display_posts')) {
            return redirect('admin/index');
        }
        $post = Post::with(['media', 'user', 'category', 'comments'])->whereId($id)->wherePostType('post')->first();
        return view('backend.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!\auth()->user()->ability('admin', 'update_posts')) {
            return redirect('admin/index');
        }
        $categories = Category::orderBy('id', 'desc')->select('id', 'name')->get();
        $post = Post::with(['media'])->whereId($id)->wherePostType('post')->first();
        return view('backend.posts.edit', compact('categories', 'post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePostRequest $request, $post_id)
    {
        if (!\auth()->user()->ability('admin', 'update_posts')) {
            return redirect('admin/index');
        }

        $post = Post::whereId($post_id)->wherePostType('post')->first();
        if ($post) {
            $data['title']           = $request->title;
            $data['slug']            = null;
            $data['description']     = $request->description;
            $data['status']          = $request->status;
            $data['comment_able']    = $request->comment_able;
            $data['category_id']     = $request->category_id;

            $post->update($data);

            if ($request->images && count($request->images) > 0) {
                $i = 1;
                foreach ($request->images as $file) {

                    $filename = $post->slug . '-' . time() . '-' . $i . '.' . $file->getClientOriginalExtension();
                    $file_size = $file->getSize();
                    $file_type = $file->getMimeType();
                    $path = public_path('assets/posts/' . $filename);
                    Image::make($file->getRealPath())->resize(800, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($path, 100);

                    $post->media()->create([
                        'image_name' => $filename,
                        'image_size' => $file_size,
                        'image_type' => $file_type,
                    ]);
                    $i++;
                }
            }
            return redirect()->route('admin.posts.index')->with([
                'message' => 'Post Updated Successfully',
                'alert-type' => 'success',
            ]);
        }
        return redirect()->back()->with([
            'message' => 'Somethig Was Wrong',
            'alert-type' => 'danger',
        ]);
    }

    public function removeImage($media_id)
    {
        if (!\auth()->user()->ability('admin', 'delete_posts')) {
            return redirect('admin/index');
        }

        $media = Post_images::whereId($media_id)->first();
        if ($media) {
            if (File::exists('assets/posts/' . $media->image_name)) {
                unlink('assets/posts/' . $media->image_name);
            }
            $media->delete();
            return true;
        } else {
            return false;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!\auth()->user()->ability('admin', 'delete_posts')) {
            return redirect('admin/index');
        }

        $post = Post::whereId($id)->wherePostType('post')->first();

        if ($post) {
            if ($post->media->count() > 0) {
                foreach ($post->media as $media) {
                    if (File::exists('assets/posts/' . $media->image_name)) {
                        unlink('assets/posts/' . $media->image_name);
                    }
                }
            }
            $post->delete();

            return redirect()->route('admin.posts.index')->with([
                'message' => 'Post deleted successfully',
                'alert-type' => 'success',
            ]);
        }

        return redirect()->route('admin.posts.index')->with([
            'message' => 'Something was wrong',
            'alert-type' => 'danger',
        ]);
    }
}
