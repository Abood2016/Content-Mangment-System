<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\commentRequest;
use App\Http\Requests\editCommentRequest;
use App\Http\Requests\editUserRequest;
use App\Http\Requests\StorePostRequest;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Post_images;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;


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
                $path = public_path('assets/posts' . $filename);
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
                    $path = public_path('assets/posts' . $filename);
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
                    if (File::exists('assets/posts/' . $media->image_name)) {
                        unlink('assets/posts/' . $media->image_name);
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
            if (File::exists('assets/posts/' . $media->image_name)) {
                unlink('assets/posts/' . $media->image_name);
            }
            $media->delete();
            return true;
        } else {
            return false;
        }
    }

    public function user_comments(Request $request)
    {
        // $posts_id = auth()->user()->posts()->select('id')->get();  the same way !

        $comments = Comment::query();

        if (isset($request->post) && $request->post != '') {
            $comments = $comments->wherePostId($request->post);
        } else {
            $posts_id = auth()->user()->posts->pluck('id')->toArray();
            $comments = $comments->whereIn('post_id', $posts_id);
        }

        $comments = $comments->orderBy('id','desc');
        $comments = $comments->paginate(10);

        return view('frontend.users.comments', compact('comments'));
    }


    public function edit_comment($comment_id)
    {
        $comment = Comment::whereId($comment_id)
            ->whereHas('post', function ($query) {
                $query->where('posts.user_id', auth()->id());
            })->first();

        if ($comment) {
            return view('frontend.users.edit_comments', compact('comment'));
        } else {
            return redirect()->back()->with([
                'message' => 'Something was wrong',
                'alert-type' => 'danger',
            ]);
        }
    }

    public function update_comment(editCommentRequest $request, $comment_id)
    {

        $comment = Comment::whereId($comment_id)
            ->whereHas('post', function ($query) {
                $query->where('posts.user_id', auth()->id());
            })->first();

        if ($comment) {

            $data['name'] = $request->name;
            $data['email'] = $request->email;
            $data['url'] = $request->url != '' ? $request->url : null;
            $data['status'] = $request->status;
            $data['comment'] = $request->comment;

            $comment->update($data);
            if ($request->status == 1) {
                Cache::forget('recent_comments');
            }
            return redirect()->back()->with([
                'message' => 'Comment Updated Successfully',
                'alert-type' => 'success',
            ]);
        } else {
            return redirect()->back()->with([
                'message' => 'Something was wrong',
                'alert-type' => 'danger',
            ]);
        }
    }

    public function delete_comment($comment_id)
    {
        $comment = Comment::whereId($comment_id)
            ->whereHas('post', function ($query) {
                $query->where('posts.user_id', auth()->id());
            })->first();

        if ($comment) {
            $comment->delete();

            Cache::forget('recent_comments');

            return redirect()->back()->with([
                'message' => 'Comment Deleted Successfully',
                'alert-type' => 'success',
            ]);
        } else {
            return redirect()->back()->with([
                'message' => 'Something was wrong',
                'alert-type' => 'danger',
            ]);
        }
    }

    public function edit_info()
    {
        return view('frontend.users.edit_info');
    }

    public function update_info(editUserRequest $request)
    {

        $data['name']           = $request->name;
        $data['email']          = $request->email;
        $data['mobile']         = $request->mobile;
        $data['bio']            = $request->bio;
        $data['receive_emails']  = $request->receive_emails;


        if ($image = $request->file('image')) {
            if (auth()->user()->image != '') {
                if (File::exists('/assets/users/' . auth()->user()->image)) {
                    unlink('/assets/users/' . auth()->user()->image);
                }
            }
            $filename = Str::slug(auth()->user()->username) . '.' . $image->getClientOriginalExtension();
            $path = public_path('assets/users/' . $filename);
            Image::make($image->getRealPath())->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path, 100);

            $data['image'] = $filename;
        }

        $update = auth()->user()->update($data);
        if ($update) {
            return redirect()->back()->with([
                'message' => 'Information Updated Successfully',
                'alert-type' => 'success',
            ]);
        } else {
            return redirect()->back()->with([
                'message' => 'Somethig Went Wrong',
                'alert-type' => 'danger',
            ]);
        }
    }

    public function update_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password'  => 'required',
            'password'          => 'required|confirmed'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = auth()->user();
        if (Hash::check($request->current_password, $user->password)) {
            $update = $user->update([
                'password' => bcrypt($request->password),
            ]);

            if ($update) {
                return redirect()->back()->with([
                    'message' => 'Password updated successfully',
                    'alert-type' => 'success',
                ]);
            } else {
                return redirect()->back()->with([
                    'message' => 'Something was wrong',
                    'alert-type' => 'danger',
                ]);
            }
        } else {
            return redirect()->back()->with([
                'message' => 'Something was wrong',
                'alert-type' => 'danger',
            ]);
        }
    }
}
