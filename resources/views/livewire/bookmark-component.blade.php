<div class="col-xl-6">
    <livewire:post-viewers-count :postId="$post_id" />
    @if ($isBookmarked == false)
        <i class="bi bi-bookmark float-end" style="cursor: pointer;" wire:click.prevent="bookmarkUnbookmark"></i> <span class="text-muted float-end mx-2">{{$bookmarksCount}}</span>
    @else
        <i class="bi bi-bookmark-fill float-end" style="cursor: pointer;" wire:click.prevent="bookmarkUnbookmark"></i><span class="text-muted float-end mx-2">{{$bookmarksCount}}</span>
    @endif
</div>