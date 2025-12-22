<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Blog;

class BlogList3 extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        $blogs = Blog::where('status', '1')->orderBy('created_at', 'desc')->paginate(6);
        return view('livewire.blog-list3', compact('blogs'));
    }
}
