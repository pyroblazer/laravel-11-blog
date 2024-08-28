<?php

namespace App\Livewire;

use App\Models\Bookmark;
use Livewire\Component;

class BookmarkComponent extends Component
{
    public $post_id;
    public $isBookmarked;

    public function mount($postId){
        $this->post_id = $postId;
        // check if bookmarks table then assign isBookmarked corresponding value..
        $checker = Bookmark::where([['user_id',auth()->user()->id],['post_id',$this->post_id]])->first();
        $this->isBookmarked = $checker == null ? false : true;

    }

    public function bookmarkUnbookmark(){
        // here we will perform bookmark & unbookmark functionality
        if ($this->isBookmarked == false) {
            $this->isBookmarked = true;
            // here we create new  record in our bookmarks table
            $bookmarkPost = new Bookmark;
            $bookmarkPost->user_id = auth()->user()->id;
            $bookmarkPost->post_id = $this->post_id;
            $bookmarkPost->save();
        }else{
            // on unbookmark we need to delete the data..
            $this->isBookmarked = false;
            Bookmark::where([['user_id',auth()->user()->id],['post_id',$this->post_id]])
            ->delete();
        }
    }
    public function render()
    {
        return view('livewire.bookmark-component',[
            'bookmarksCount' => Bookmark::where('post_id',$this->post_id)->count()
        ]);
    }
}
