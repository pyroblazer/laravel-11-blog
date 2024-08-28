<?php

namespace App\Livewire;

use App\Models\Bookmark;
use App\Models\Post;
use Livewire\Component;

class PostDataCounter extends Component
{
    public $postBookmarks;

    public function mount(){
        $this->postBookmarks = Post::join('bookmarks','bookmarks.post_id','=','posts.id')->where('posts.user_id',auth()->user()->id)->count();
    }
    public function render()
    {
        return view('livewire.post-data-counter');
    }
}
