<div class="wn__sidebar">
    <!-- Start Single Widget -->
    <aside class="widget search_widget">
        <h3 class="widget-title">Search</h3>
        <form action="{{ route('post.search') }}" method="GET">
            <div class="form-input">
                <input type="text" name="keyword" value="{{ request()->keyword }}" placeholder="Search...">
                <button type="submit"><i class="fa fa-search"></i></button>
            </div>
        </form>
    </aside>


    <!-- End Single Widget -->
    <!-- Start Single Widget -->
    <aside class="widget recent_widget">
        <h3 class="widget-title">Recent Posts</h3>
        <div class="recent-posts">
            <ul>
                @foreach ($recent_posts as $recent_post)
                <li>
                    <div class="post-wrapper d-flex">
                        <div class="thumb">
                            <a href="{{ route('post.show',$recent_post->slug) }}">
                                @if ($recent_post->media->count() > 0)
                                <img src="{{ asset('front-end/posts/' . $recent_post->media->first()->image_name) }}"
                                    alt="blog images">
                                @else
                                <img src="{{ asset('front-end/posts/default-small.jpg') }}"
                                    alt="{{ $recent_post->title }}">
                                @endif
                            </a>
                        </div>
                        <div class="content">
                            <h4><a
                                    href="{{ route('post.show',$recent_post->slug) }}">{{ \Illuminate\Support\Str::limit($recent_post->title , 15 ,'...') }}</a>
                            </h4>
                            <p> {{ $recent_post->created_at->format('M d,Y ') }} </p>
                        </div>
                    </div>
                </li>
                @endforeach

            </ul>
        </div>
    </aside>
    <!-- End Single Widget -->
    <!-- Start Single Widget -->
    <aside class="widget comment_widget">
        <h3 class="widget-title">Leatest Comments</h3>
        <ul>
            @foreach ($recent_comments as $recent_comment)
            <li>
                <div class="post-wrapper">
                    <div class="thumb">
                        <img src="{{ get_gravatar($recent_comment->email, 46) }}" alt="Comment images">
                    </div>
                    <div class="content">
                        <p>{{ $recent_comment->name }} says:</p>
                        <a href="#">{{ \Illuminate\Support\Str::limit($recent_comment->comment,15,'...') }}</a>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
    </aside>
    <!-- End Single Widget -->
    <!-- Start Single Widget -->
    <aside class="widget category_widget">
        <h3 class="widget-title">Categories</h3>
        <ul>
            @foreach ($recent_categoreis as $recent_category)

            <li><a href="{{ route('category.posts',$recent_category->slug) }}">{{ $recent_category->name }}</a></li>

            @endforeach
        </ul>
    </aside>
    <!-- End Single Widget -->
    <!-- Start Single Widget -->
    <aside class="widget archives_widget">
        <h3 class="widget-title">Archives</h3>
        <ul>
            @foreach ($archive as $key => $value)
            <li><a href="{{ route('archive.posts',$key. '-' .$value) }}">{{ date("F" , mktime(0,0,0,$key,1)) .'  '. $value}}</a></li> 
            @endforeach
        </ul>
    </aside>
    <!-- End Single Widget -->
</div>