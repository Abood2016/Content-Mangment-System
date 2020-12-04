@extends('layouts.app')

@section('content')
   <div class="page-blog bg--white section-padding--lg blog-sidebar right-sidebar">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-12">
                    <div class="blog-page">

                        @forelse ($posts as $post)
                            <article class="blog__post d-flex flex-wrap">
                                <div class="thumb">
                                    <a href="#">
                                        @if ($post->media->count() > 0)
                                        <img src="{{ asset('front-end/posts/' . $post->media->first()->image_name) }}" alt="blog images">
                                        @else
                                        <img src="{{ asset('front-end/posts/default.jpg') }}" alt="{{ $post->title }}">
                                        @endif
                                    </a>
                                </div>
                                <div class="content">
                                    <h4><a href="{{ route('post.show',$post->slug) }}">{{ $post->title }}</a></h4>
                                    <ul class="post__meta">
                                        <li>Posts by : <a href="#">{{ $post->user->name }}</a></li>
                                        <li class="post_separator">/</li>
                                        <li>{{ $post->created_at->format('M d,Y') }}</li>
                                    </ul>
                                    <p>{!!  \Illuminate\Support\Str::limit($post->description,145 , '....') !!}</p>
                                    <div class="blog__btn">
                                        <a href="{{ route('post.show',$post->slug) }}">read more</a>
                                    </div>
                                </div>
                            </article>
                        @empty
                            <div class="text-center">
                                No Posts Found
                            </div>
                        @endforelse
                    </div>
                    {!! $posts->appends(request()->input())->links() !!}
                    
                </div>
                <div class="col-lg-3 col-12 md-mt-40 sm-mt-40">
                        @include('partial.frontend.side-bar')
                </div>
            </div>
        </div>
    </div>
@endsection