<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateContactEnquiryRequest;
use App\Models\ContactRequest;
use App\Models\Vcard;
use Auth;
use DB;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Yajra\DataTables\Exceptions\Exception;

class ContactRequestController extends AppBaseController
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateContactEnquiryRequest $request)
    {
        $contactRequest = ContactRequest::where('email', $request->email)->latest()->first();
        if ($contactRequest) {
            return redirect()->route('add-contact', $request->vcard_id);
        } else {
            $input = $request->all();
            try {
                DB::beginTransaction();
                $contactRequest = ContactRequest::create($input);
                DB::commit();

                setLocalLang(getLocalLanguage());

                return $contactRequest;
            } catch (Exception $e) {
                DB::rollBack();
                throw new UnprocessableEntityHttpException($e->getMessage());
            }
        }
        return redirect()->back();
    }
}
