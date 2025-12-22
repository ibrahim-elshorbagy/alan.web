<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLinkedinEmbedRequest;
use App\Http\Requests\UpdateLinkedinEmbedRequest;
use App\Models\LinkedinEmbed;
use App\Repositories\LinkedinEmbedRepository;
use Illuminate\Http\Request;

class linkedinEmbedController extends AppBaseController
{
    /**
     * @var LinkedinEmbedRepository
     */
    private $linkedinembedRepo;

    public function __construct(LinkedinEmbedRepository $linkedinembedRepo)
    {
        $this->linkedinembedRepo = $linkedinembedRepo;
    }

    public function store(CreateLinkedinEmbedRequest $request)
    {
        $input = $request->all();

        $this->linkedinembedRepo->store($input);

        return $this->sendSuccess(__('messages.placeholder.embedtag_created'));
    }

    public function edit(LinkedinEmbed $linkedinembed)
    {
        return $this->sendResponse($linkedinembed, 'linkedinembed successfully retrieved.');
    }

    public function update(UpdateLinkedinEmbedRequest $request, LinkedinEmbed $linkedinembed)
    {
        $input = $request->all();
        $this->linkedinembedRepo->update($input, $linkedinembed->id);

        return $this->sendSuccess(__('messages.placeholder.embedtag_updated'));
    }

    public function destroy($linkedinembed)
    {
        LinkedinEmbed::destroy($linkedinembed);

        return $this->sendSuccess('Linkedin Embed deleted successfully.');
    }

}
