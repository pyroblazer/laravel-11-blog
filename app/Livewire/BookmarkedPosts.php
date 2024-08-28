<?php

namespace App\Livewire;

use App\Models\Bookmark;
use App\Models\Post;
use Livewire\Component;

class BookmarkedPosts extends Component
{
    public $bookmarked_posts;

    public function unbookmarkPost($postId)
    {
        $user_id = auth()->user()->id;

        $bookmark = Bookmark::where('user_id', $user_id)
                            ->where('post_id', $postId)
                            ->first();

        if ($bookmark) {
            $bookmark->delete();

            $this->bookmarked_posts = $this->bookmarked_posts->filter(function ($post) use ($postId) {
                return $post->id !== $postId;
            });
        }
    }
    public function mount()
    {
        $user_id = auth()->user()->id;

        $bookmarkedPostIds = Bookmark::where('user_id', $user_id)
                                     ->pluck('post_id');
        
        $this->bookmarked_posts = Post::whereIn('id', $bookmarkedPostIds)->get();
    }

    public function render()
    {
        return view('livewire.bookmarked-posts', [
            'posts' => $this->bookmarked_posts,
        ]);
    }
}
