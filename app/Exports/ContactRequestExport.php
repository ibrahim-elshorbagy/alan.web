<?php

namespace App\Exports;

use App\Models\ContactRequest;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ContactRequestExport implements FromView
{
    protected $vcardId;

    public function __construct($vcardId)
    {
        $this->vcardId = $vcardId;
    }
    public function view(): View
    {
        $contacts = ContactRequest::where('vcard_id', $this->vcardId)->get();

        return view('vcards.contact.vcard-contact-excel', [
            'contacts' => $contacts,
        ]);
    }
}
