<?php

namespace App\Http\Controllers;

use App\Models\CustomPage;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use App\Repositories\CustomPageRepository;
use App\Http\Requests\CreateCustomPageRequest;
use App\Http\Requests\UpdateCustomPageRequest;

class CustomPageController extends AppBaseController
{
    private $customPageRepository;
    public function __construct(CustomPageRepository $customPageRepository)
    {
        $this->customPageRepository = $customPageRepository;
    }

    public function index()
    {
        return view('sadmin.custom_page.index');
    }

    public function create()
    {
        return view('sadmin.custom_page.create');
    }

    public function store(CreateCustomPageRequest $request)
    {
        $input = $request->all();
        $this->customPageRepository->store($input);
        Flash::success(__('messages.flash.custom_page_create'));
        return redirect(route('custom.page.index'));
    }

    public function edit(CustomPage $customPage)
    {
        return view('sadmin.custom_page.edit', compact('customPage'));
    }

    public function update(UpdateCustomPageRequest $request, $id)
    {
        $input = $request->all();
        $this->customPageRepository->update($input, $id);
        Flash::success(__('messages.flash.custom_page_update'));
        return redirect(route('custom.page.index'));
    }

    public function destroy(CustomPage $customPage)
    {
        $customPage->delete();
        return $this->sendSuccess(__('messages.flash.custom_page_delete'));
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

    public function updateCustomPageStatus(CustomPage $customPage)
    {
        $customPage->update([
            'status' => ! $customPage->status,
        ]);

        return $this->sendSuccess(__('messages.flash.custom_page_status'));
    }
}
