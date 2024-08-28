<div class="row">
    {{-- here we will loop through all posts.. --}}
        @foreach ($posts as $post)
            <div class="col-xl-4">
            <div class="card">

                <img src="{{ $post->getFirstMediaUrl('posts') }}" height="200px" alt="" class="card-img-top">
                <div class="card-body">
                    <h2 class="font-weight-bold mt-2">{{$post->post_title}}</h2>    
                    <ul class="d-flex flex-wrap list-unstyled">
                        <li class="">
                            Category: 
                            <a class="btn btn-outline-primary bg-light text-primary rounded py-1 px-2" href="category/all">
                                {{$post->category}}
                            </a>
                        </li>
                    </ul>
                    <p>{{str($post->content)->words(10)}}<a href="/view/post/{{$post->id}}" wire:navigate wire:click="addViewers({{$post->id}})" class="card-link mx-1">read more</a></p>
                    <div class="row">
                        <div class="col-xl-6">
                            <small class="text-muted">{{date('d-m-Y h:i',strtotime($post->created_at))}}</small>
                        </div>
                        <livewire:bookmark-component :postId="$post->id" />
                    </div>
                </div>
                <div class="card-footer">
                    {{-- here we use anchor tag to make both profile-image component and name be clickable --}}
                    <a href="/view/profile/{{$post->user_id}}" wire:navigate>
                        <livewire:profile-image :userId="$post->user_id" />
                        <span class="text-muted mx-3 text-capitalize my-1"> {{$post->name}}</span>
                    </a>
                    <livewire:follow-component :followedId="$post->followedId" /> 
                </div>
            </div>
        </div>
        @endforeach
    </div>