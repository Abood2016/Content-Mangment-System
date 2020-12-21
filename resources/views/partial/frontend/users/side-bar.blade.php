<div class="wn__sidebar">
    <aside class="widget recent_widget">
        <ul>
            <li class="list-group-item">
                <img src="{{ asset('assets/users/' . auth()->user()->image) }}" style="border-radius: 20px" alt="{{ auth()->user()->name }}">
            </li>
            <li class="list-group-item"><a href="{{ route('frontend.dashboard') }}">My Posts</a></li>
                <li class="list-group-item"><a href="{{ route('users.post.create') }}">Create Post</a></li>
          <li class="list-group-item"><a href="{{ route('user.comments') }}">Manage Comments</a></li>
                <li class="list-group-item"><a href="{{ route('users.edit.info') }}">Update Information</a></li>
                <li class="list-group-item"><a href="{{ route('front.logout') }}" onclick="event.preventDefault();
                 document.getElementById('logout-form').submit();">Logout</a></li>
                 <form id="logout-form" action="{{ route('front.logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
           

        </ul>
    </aside>
</div>