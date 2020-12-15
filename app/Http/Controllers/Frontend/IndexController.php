<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\commentRequest;
use App\Http\Requests\contactRequest;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Post;
use App\Models\User;
use App\Notifications\NewCommentForPostOwnerNotify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IndexController extends Controller
{
    function index()
    {
        $posts = Post::with(['media', 'user'])
            ->whereHas('category', function ($query) {
                $query->whereStatus(1);
            })->whereHas('user', function ($query) {
                $query->whereStatus(1);
            })->post()->active()->orderBy('id', 'desc')->paginate(5);
        return view('frontend.index', compact('posts'));
    }

    function show_post($slug)
    {
        $post = Post::with([
            'category', 'media', 'user',
            'approved_comments' => function ($query) {
                $query->OrderBy('id', 'desc');
            }
        ]);
        $post = $post->whereHas('category', function ($query) {
            $query->whereStatus(1);
        })->whereHas('user', function ($query) {
            $query->whereStatus(1);
        });

        $post = $post->whereSlug($slug);

        $post = $post->active()->first();


        if ($post) {

            $blade =  $post->post_type == 'post' ? 'post' : 'page';

            return view('frontend.' . $blade, compact('post'));
        } else {
            return redirect()->route('frontend.index');
        }
    }

    public function store_comment(commentRequest $request, $slug)
    {

        $post = Post::whereSlug($slug)->wherePostType('post')->whereStatus(1)->first();

        if ($post) {

            $userId = auth()->check() ? auth()->id() : null;

            $data['name'] = $request->name;
            $data['email'] = $request->email;
            $data['url'] = $request->url;
            $data['ip_address'] = $request->ip();
            $data['comment'] = $request->comment;
            $data['post_id'] = $post->id;
            $data['user_id'] = $userId;

            $comment =   $post->comments()->create($data);
            if (auth()->guest() || auth()->id() != $post->user_id) {
                $post->user->notify(new NewCommentForPostOwnerNotify($comment));
            }

            return redirect()->back()->with([
                'message' => 'Comment Added Succesfully',
                'alert-type' => 'success'
            ]);
        }
    }


    public function contact()
    {
        return view('frontend.contact');
    }

    public function add_contact(contactRequest $request)
    {
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['title'] = $request->title;
        $data['message'] = $request->message;
        $data['mobile'] = $request->mobile;

        Contact::create($data);

        return redirect()->back()->with([
            'message' => 'Message Sent Succesfully',
            'alert-type' => 'success'
        ]);
    }


    public function search(Request $request)
    {
        $keyword = isset($request->keyword) && $request->keyword != '' ? $request->keyword : null;

        $posts = Post::with(['media', 'user'])
            ->whereHas('category', function ($query) {
                $query->whereStatus(1);
            })
            ->whereHas('user', function ($query) {
                $query->whereStatus(1);
            });

        if ($keyword != null) {
            $posts = $posts->search($keyword, null, true);
        }

        $posts = $posts->post()->active()->orderBy('id', 'desc')->paginate(5);

        return view('frontend.index', compact('posts'));
    }

    public function category($slug)
    {
        //Get only the id from category
        $category = Category::whereSlug($slug)->orWhere('id', $slug)->whereStatus(1)->first()->id;

        if ($category) {
            $posts = Post::with(['user', 'media'])
                ->whereCategoryId($category) //in post table mean category_id
                ->post()
                ->active()
                ->orderBy('id', 'desc')
                ->paginate(5);

            return view('frontend.index', compact('posts'));
        }

        return redirect()->route('frontend.index');
    }

    public function archive($date)
    {
        // 12 - 2020 date like that
        $exploded_date = explode('-', $date); //هيقسم التاريخ لمصفوفة
        $month = $exploded_date[0];
        $year = $exploded_date[1];

        $posts = Post::with(['user', 'media'])
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->post()
            ->active()
            ->orderBy('id', 'desc')
            ->paginate(5);
        return view('frontend.index', compact('posts'));
    }

    public function author($username)
    {
        //Get only the id from category
        $user = User::whereUsername($username)->whereStatus(1)->first()->id;

        if ($user) {
            $posts = Post::with(['user', 'media'])
                ->whereUserId($user) //in post table mean category_id
                ->post()
                ->active()
                ->orderBy('id', 'desc')
                ->paginate(5);

            return view('frontend.index', compact('posts'));
        }

        return redirect()->route('frontend.index');
    }
}
