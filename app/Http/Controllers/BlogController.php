<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Models\Blog;
use App\Repositories\BlogRepository;
use Flash;
use Illuminate\Http\Request;

class BlogController extends AppBaseController
{

    /**
     * @var BlogRepository
     */
    private $blogRepository;

    /**
     * BlogController constructor.
     */
    public function __construct(BlogRepository $blogRepository)
    {
        $this->blogRepository = $blogRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('sadmin.blog.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sadmin.blog.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateBlogRequest $request)
    {
        $input = $request->all();
        $this->blogRepository->store($input);
        Flash::success(__('messages.flash.blog_create'));
        return redirect(route('blogs.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        return view('sadmin.blog.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        return view('sadmin.blog.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogRequest $request, $id)
    {
        $input = $request->all();
        $this->blogRepository->update($input, $id);
        Flash::success(__('messages.flash.blog_update'));
        return redirect(route('blogs.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();
        return $this->sendSuccess('Blog deleted successfully.');
    }


    public function slug(Request $request)
    {
        $text = $request->text;
        if ($text == '') {
            $text = '';
        }
        $slug = preg_replace('/[^\p{L}\p{N}]+/u', '-', trim($text));
        
        return $this->sendResponse($slug, __('messages.placeholder.content_generated_successfully'));
    }


    public function updateBlogStatus(Blog $blog)
    {
        $blog->update([
            'status' => ! $blog->status,
        ]);

        return $this->sendSuccess(__('messages.flash.blog_status'));
    }
}
