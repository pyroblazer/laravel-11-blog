<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreatePost extends Component
{
    use WithFileUploads;
    
    public $post_title = '';
    public $content = '';
    public $category = '';
    public $photo;

    public function submit(){
        $this->validate([
            'post_title' => 'required',
            'content' => 'required',
            'category' => 'required',
            'photo' => 'required|image|max:1024', // Adjust validation as needed
        ]);

        $createPost = new Post;
        $createPost->post_title = $this->post_title;
        $createPost->content = $this->content;
        $createPost->category = $this->category;
        $createPost->user_id = auth()->user()->id;
        $createPost->save();

        // Add the image to the MediaLibrary
        $createPost->addMedia($this->photo->getRealPath())
                   ->toMediaCollection('posts'); // Specify the collection name

        $this->post_title = '';
        $this->content = '';
        $this->photo = null;

        session()->flash('message', 'The post was successfully created!');
        $this->redirect('/posts/user', navigate: true); 
    }

    public function render()
    {
        return view('livewire.create-post');
    }
}
