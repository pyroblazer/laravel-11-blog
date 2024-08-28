<div class="card">
    {{-- here create a form to add new post --}}
    <div class="card-header">
        Add New Post
    </div>
    <div class="card-body">
        <form class="my-3" wire:submit.prevent="submit"> 
            <div class="col-sm-10">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" wire:model="post_title" id="floatingInput" placeholder="Post Title">
                    <label for="floatingInput">Post Title</label>
                </div>
                @error('post_title')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-sm-10">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" wire:model="category" id="floatingInput" placeholder="Post Category">
                    <label for="floatingTextarea">Post Category</label>
                </div>
                @error('content')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-sm-10">
                <div class="form-floating mb-3">
                    <textarea class="form-control" placeholder="Post details" wire:model="content" id="floatingTextarea" style="height: 100px;"></textarea>
                    <label for="floatingTextarea">Your post goes here..</label>
                </div>
                @error('content')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-sm-10">
                <div class="form-floating mb-3">
                    <input type="file" class="form-control" wire:model="photo" id="">
                    <label for="photo">Your post image</label>
                </div>
                @error('photo')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="/user/home" wire:navigate class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
