<?php

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use App\Models\Post;
use Livewire\Attributes\On;

class DisplayPosts extends Component
{
    protected $listeners = ['postCreated' => '$refreshPosts'];
    public $posts;
    public $post_links = [];

    public function mount(): void
    {
        $this->refreshPosts();
    }

    #[On('postCreated')]
    #[On('PostDeleted')]
    public function refreshPosts(): void
    {
        $this->posts = Post::with(['files', 'user'])->orderByDesc('created_at')->get();
    }

    public function deletePost($id)
    {
        $post = Post::find($id);

        if ($post && $post->user_id === auth()->id()) {
            $post->delete();
        }

        $this->refreshPosts();
    }


    public function render(): View
    {
        return view('livewire.display-posts', ['posts' => $this->posts]);
    }
}
