<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Attributes\On;
use Livewire\Component;

class PersonalPosts extends Component
{
    public $posts;
    public function mount(): void
    {
        $this->refreshPosts();
    }

    #[On('postDeleted')]
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

        $this->dispatch("postDeleted");
    }

    public function render()
    {
        $user = auth()->user();
        $posts = Post::where('user_id', $user->id)->get();
        return view('livewire.display-posts', ['posts' => $posts]);
    }
}
