<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\backendRequests\StorePageRequest;
use App\Models\Category;
use App\Models\Page;
use Illuminate\Http\Request;
use App\Models\Post_images;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class PagesController extends Controller
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
        if (!\auth()->user()->ability('admin', 'manage_pages show_pages')) {
            return redirect('admin/index');
        }

        $keyword =     isset(\request()->keyword) && \request()->keyword != '' ? \request()->keyword : null;
        $categoryId =  isset(\request()->category_id) && \request()->category_id != '' ? \request()->category_id : null;
        $status =      isset(\request()->status) && \request()->status != '' ? \request()->status : null;
        $sort_by =     isset(\request()->sort_by) && \request()->sort_by != '' ? \request()->sort_by : 'id';
        $order_by =    isset(\request()->order_by) && \request()->order_by != '' ? \request()->order_by : 'desc';
        $limit_by =    isset(\request()->limit_by) && \request()->limit_by != '' ? \request()->limit_by : '10';

        $pages = Page::wherePostType('page');
        if ($keyword != null) {
            $pages = $pages->search($keyword);
        }
        if ($categoryId != null) {
            $pages = $pages->whereCategoryId($categoryId);
        }
        if ($status != null) {
            $pages = $pages->whereStatus($status);
        }

        $pages = $pages->orderBy($sort_by, $order_by);
        $pages = $pages->paginate($limit_by);

        $categories = Category::orderBy('id', 'desc')->select('id', 'name')->get();
        return view('backend.pages.index', compact('pages', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!\auth()->user()->ability('admin', 'create_pages')) {
            return redirect('admin/index');
        }
        $categories = Category::orderBy('id', 'desc')->select('id', 'name')->get();
        return view('backend.pages.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePageRequest $request)
    {
        if (!\auth()->user()->ability('admin', 'create_pages')) {
            return redirect('admin/index');
        }

        $data['title']           = $request->title;
        $data['description']     = $request->description;
        $data['status']          = $request->status;
        $data['post_type']       = 'page';
        $data['comment_able']    = 0;
        $data['category_id']     = $request->category_id;

        $page = auth()->user()->posts()->create($data);

        if ($request->images && count($request->images) > 0) {
            $i = 1;
            foreach ($request->images as $file) {
                $filename = $page->slug . '-' . time() . '-' . $i . '.' . $file->getClientOriginalExtension();
                $file_size = $file->getSize();
                $file_type = $file->getMimeType();
                $path = public_path('assets/posts/' . $filename);
                Image::make($file->getRealPath())->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path, 100);
                $page->media()->create([
                    'image_name' => $filename,
                    'image_size' => $file_size,
                    'image_type' => $file_type,
                ]);
                $i++;
            }
        }


        return redirect()->route('admin.pages.index')->with([
            'message' => 'Page Added Successfully',
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
        if (!\auth()->user()->ability('admin', 'display_pages')) {
            return redirect('admin/index');
        }
        $page = Page::with(['media'])->whereId($id)->wherePostType('page')->first();
        return view('backend.pages.show', compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!\auth()->user()->ability('admin', 'update_pages')) {
            return redirect('admin/index');
        }
        $categories = Category::orderBy('id', 'desc')->select('id', 'name')->get();
        $page = Page::with(['media'])->whereId($id)->wherePostType('page')->first();
        return view('backend.pages.edit', compact('categories', 'page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePageRequest $request, $post_id)
    {
        if (!\auth()->user()->ability('admin', 'update_pages')) {
            return redirect('admin/index');
        }

        $page = Page::whereId($post_id)->wherePostType('page')->first();
        if ($page) {
            $data['title']           = $request->title;
            $data['slug']            = null;
            $data['description']     = $request->description;
            $data['status']          = $request->status;
            $data['category_id']     = $request->category_id;

            $page->update($data);

            if ($request->images && count($request->images) > 0) {
                $i = 1;
                foreach ($request->images as $file) {

                    $filename = $page->slug . '-' . time() . '-' . $i . '.' . $file->getClientOriginalExtension();
                    $file_size = $file->getSize();
                    $file_type = $file->getMimeType();
                    $path = public_path('assets/posts/' . $filename);
                    Image::make($file->getRealPath())->resize(800, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($path, 100);

                    $page->media()->create([
                        'image_name' => $filename,
                        'image_size' => $file_size,
                        'image_type' => $file_type,
                    ]);
                    $i++;
                }
            }
            return redirect()->route('admin.pages.index')->with([
                'message' => 'Page Updated Successfully',
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
        if (!\auth()->user()->ability('admin', 'delete_pages')) {
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
        if (!\auth()->user()->ability('admin', 'delete_pages')) {
            return redirect('admin/index');
        }
        $page = Page::whereId($id)->wherePostType('page')->first();

        if ($page) {
            if ($page->media->count() > 0) {
                foreach ($page->media as $media) {
                    if (File::exists('assets/posts/' . $media->image_name)) {
                        unlink('assets/posts/' . $media->image_name);
                    }
                }
            }
            $page->delete();

            return redirect()->route('admin.pages.index')->with([
                'message' => 'Pages deleted successfully',
                'alert-type' => 'success',
            ]);
        }

        return redirect()->route('admin.pages.index')->with([
            'message' => 'Something was wrong',
            'alert-type' => 'danger',
        ]);
    }
}
