<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Vcard;
use App\Models\VcardBlog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Repositories\VcardBlogRepository;
use App\Http\Controllers\AppBaseController;

class BlogAPIController extends AppBaseController
{
    private $vcardBlogRepo;

    public function __construct(VcardBlogRepository $vcardBlogRepo)
    {
        $this->vcardBlogRepo = $vcardBlogRepo;
    }

    public function getVcardBlogs($vcardId)
    {
        $vcardBlog = VcardBlog::where('vcard_id', $vcardId)
            ->whereHas('vcard', function ($query) {
                $query->where('tenant_id', getLogInTenantId());
            })
            ->get();

        if (empty($vcardBlog)) {
            return $this->sendError('Blog not found.');
        }

        $vcardBlog->makeHidden(['created_at', 'updated_at', 'media'])->toArray();

        return $this->sendResponse($vcardBlog, 'Blogs retrieved successfully.');
    }

    public function show($testimonialId)
    {
        $blog = VcardBlog::where('id', $testimonialId)
            ->whereHas('vcard', function ($query) {
                $query->where('tenant_id', getLogInTenantId());
            })
            ->first();

        if (empty($blog)) {
            return $this->sendError('Blog not found.');
        }

        $product = $blog->makeHidden(['created_at', 'updated_at', 'media'])->toArray();

        return $this->sendResponse($blog, 'Blog retrieved successfully.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'vcard_id' => 'required',
            'blog_icon' => 'required|file|mimes:jpg,jpeg,png|max:2048',
        ]);
        $input = $request->all();

        $vcard = Vcard::findOrFail($request->vcard_id);

        if ($vcard->tenant_id != getLogInTenantId()) {
            return $this->sendError('Vcard not found.');
        }

        $blog = $this->vcardBlogRepo->store($input);

        return $this->sendSuccess('Blog created successfully.');
    }


    public function update(Request $request, $blogId)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'blog_icon' => 'file|mimes:jpg,jpeg,png|max:2048',
        ]);

        $blog = VcardBlog::where('id', $blogId)->whereHas('vcard', function ($query) {
            $query->where('tenant_id', getLogInTenantId());
        })->first();

        if (empty($blog)) {
            return $this->sendError('Blog not found.');
        }

        $input = $request->all();

        $testimonial = $this->vcardBlogRepo->update($input, $blog->id);

        return $this->sendSuccess('Blog updated successfully.');
    }


    public function destroy($id)
    {
        $blog = VcardBlog::where('id', $id)
            ->whereHas('vcard', function ($query) {
                $query->where('tenant_id', getLogInTenantId());
            })
            ->first();

        if (empty($blog)) {
            return $this->sendError('Blog not found.');
        }
        $blog->delete();

        return $this->sendSuccess('Blog deleted successfully.');
    }
}
