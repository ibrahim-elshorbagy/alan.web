<?php
namespace App\Http\Controllers;
use App\Models\Vcard;
use App\Models\CustomLink;
use Illuminate\Http\Request;
use App\Repositories\CustomLinkRepository;
use App\Http\Requests\CreateCustomLinkRequest;
use App\Http\Requests\UpdateCustomLinkRequest;

class CustomLinkController extends AppBaseController
{
    private $customLinkRepo;

    public function __construct(CustomLinkRepository $customLinkRepo)
    {
        $this->customLinkRepo = $customLinkRepo;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function getCustomLink(Vcard $vcard)
    {
        $isNative = $vcard->tenant_id == getLogInTenantId();

        if (!$isNative) {
            return $this->sendError('vCard not found.');
        }
        $customLinks = CustomLink::where('vcard_id', $vcard->id)->get();
        if (empty($customLinks)) {
            return $this->sendResponse([], 'Custom links retrieved successfully.');
        }
        $customLinks = $customLinks->makeHidden(['created_at', 'updated_at','media'])->toArray();

        return $this->sendResponse($customLinks, 'Custom links retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCustomLinkRequest $request)
    {
        $input = $request->all();
        $customLink = $this->customLinkRepo->store($input );

        return $this->sendResponse($customLink, __('messages.flash.custom_link_created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(CustomLink $customLink)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CustomLink $customLink)
    {
        return $this->sendResponse($customLink, 'Custom Link successfully retrieved.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomLinkRequest $request,$id)
    {
        $input = $request->all();
        $customLink = $this->customLinkRepo->update($input, $id);
        return $this->sendResponse($customLink, __('messages.flash.custom_link_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CustomLink $customLink)
    {
        $customLink->delete();

        return $this->sendSuccess(__('messages.flash.custom_link_deleted'));
    }

    public function updateShowAsButton(CustomLink $customLink)
    {
        $customLink->update([
            'show_as_button' => ! $customLink->show_as_button,
        ]);

        return $this->sendSuccess(__('messages.flash.show_as_button'));
    }

    public function updateOpenNewTab(CustomLink $customLink)
    {
        $customLink->update([
            'open_new_tab' => ! $customLink->open_new_tab,
        ]);

        return $this->sendSuccess(__('messages.flash.open_new_tab'));
    }
}
