<?php

namespace App\Livewire;

use App\Models\Blog;
use Livewire\Component;
use Livewire\WithPagination;

class BlogList4 extends Component
{
    use WithPagination;
    protected $paginationTheme = 'tailwind';
    public function render()
    {
        $blogs = Blog::where('status', '1')->orderBy('created_at', 'desc')->paginate(6);
        return view('livewire.blog-list4', compact('blogs'));
    }
}
