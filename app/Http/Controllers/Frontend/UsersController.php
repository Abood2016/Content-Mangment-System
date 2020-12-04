<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Post_images;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;


class UsersController extends Controller
{

    public function __construct()
    {
        $this->middleware([
            'auth', 'verified'
        ]);
    }


    public function index()
    {
        // $posts = Post::whereUserId(auth()->id()); // the same way
        $posts = auth()->user()->posts()
            ->with(['media', 'category', 'user'])
            ->withCount('comments')->orderBy('id', 'desc')->paginate(10);

        return view('frontend.users.dashboard', compact('posts'));
    }

    public function create_post()
    {
        $categories = Category::whereStatus(1)->select('id', 'name')->get();
        return view('frontend.users.create-post', compact('categories'));
    }

    public function store_post(StorePostRequest $request)
    {

        $data['title']           = $request->title;
        $data['description']     = $request->description;
        $data['status']          = $request->status;
        $data['comment_able']    = $request->comment_able;
        $data['category_id']     = $request->category_id;

        $post = auth()->user()->posts()->create($data);

        if ($request->images && count($request->images) > 0) {
            $i = 1;
            foreach ($request->images as $file) {
                $filename = $post->slug . '-' . time() . '-' . $i . '.' . $file->getClientOriginalExtension();
                $file_size = $file->getSize();
                $file_type = $file->getMimeType();
                $path = public_path('front-end/posts/' . $filename);
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

        return redirect()->back()->with([
            'message' => 'Post Added Successfully',
            'alert-type' => 'success',
        ]);
    }

    public function edit_post($post_id)
    {
        $post = Post::whereSlug($post_id)->orWhere('id', $post_id)->whereUserId(auth()->id())->first();
        if ($post) {
            $categories = Category::whereStatus(1)->select('id', 'name')->get();
            return view('frontend.users.edit-post', compact('categories', 'post'));
        }
        return redirect()->route('frontend.index');
    }

    public function update_post(StorePostRequest $request, $post_id)
    {
        $post = Post::whereSlug($post_id)->orWhere('id', $post_id)->whereUserId(auth()->id())->first();
        if ($post) {
            $data['title']           = $request->title;
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
                    $path = public_path('front-end/posts/' . $filename);
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
            return redirect()->back()->with([
                'message' => 'Post Updated Successfully',
                'alert-type' => 'success',
            ]);
        }
        return redirect()->back()->with([
            'message' => 'Somethig Was Wrong',
            'alert-type' => 'danger',
        ]);
    }

    public function delete_post($post_id)
    {
        $post = Post::whereSlug($post_id)->orWhere('id', $post_id)->whereUserId(auth()->id())->first();

        if ($post) {
            if ($post->media->count() > 0) {
                foreach ($post->media as $media) {
                    if (File::exists('front-end/posts/' . $media->image_name)) {
                        unlink('front-end/posts/' . $media->image_name);
                    }
                }
            }
            $post->delete();

            return redirect()->back()->with([
                'message' => 'Post deleted successfully',
                'alert-type' => 'success',
            ]);
        }

        return redirect()->back()->with([
            'message' => 'Something was wrong',
            'alert-type' => 'danger',
        ]);
    }

    public function destroy_post_media($media_id)
    {
        $media = Post_images::whereId($media_id)->first();
        if ($media) {
            if (File::exists('front-end/posts/' . $media->image_name)) {
                unlink('front-end/posts/' . $media->image_name);
            }
            $media->delete();
            return true;
        } else {
            return false;
        }
    }

  
}