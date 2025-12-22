<?php

namespace App\Http\Controllers;

use App\Models\Nfc;
use App\Models\Setting;
use App\Models\NfcOrders;
use Laracasts\Flash\Flash;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\NfcOrderTransaction;
use App\Repositories\NfcRepository;
use App\Http\Requests\CreateNfcRequest;
use App\Http\Requests\UpdateNfcCardRequest;

class NfcController extends AppBaseController
{
    private $NfcRepository;

    public function __construct(NfcRepository $NfcRepository)
    {
        $this->NfcRepository = $NfcRepository;
    }

    public function index(Request $request)
    {
        return view('sadmin.nfc.index');
    }

    public function store(CreateNfcRequest $request)
    {

        $input = $request->all();

        $nfc = $this->NfcRepository->store($input);

        return $this->sendResponse($nfc,__('messages.nfc.nfc_card_created_success'));
    }

    public function edit($id){

       $nfc = Nfc::with('media')->find($id);

        return $this->sendResponse($nfc, 'Nfc Type  successfully retrieved.');
    }

    public function update(UpdateNfcCardRequest $request,$id){
        $input = $request->all();

        $nfc = $this->NfcRepository->update($input, $id);

        return $this->sendResponse($nfc,__('messages.nfc.nfc_card_updated_success'));

    }

    public function destroy($id)
    {
        $nfcOrder = NfcOrders::where('card_type',$id)->exists();

        if($nfcOrder){
            return $this->sendError(__('messages.nfc.card_can_not_deleted'));
        }

        $nfc = Nfc::find($id);
        $nfc->delete();

        return $this->sendSuccess(__('messages.nfc.nfc_card_deleted_success'));
    }

    public function getNfcCardTax()
    {
        $tax = Setting::where('key', 'nfc_tax_value')->value('value');
        $status = Setting::where('key', 'nfc_tax_enabled')->value('value');

        return response()->json([
            'tax' => $tax,
            'status' => $status == 1 ? true : false,
        ]);
    }

    public function nfcCardTax(Request $request)
    {
        $input = $request->all();

        $request->validate([
            'nfc_tax_value' => 'required|numeric',
        ]);

        $taxSettings = [
            'nfc_tax_value' => $input['nfc_tax_value'],
            'nfc_tax_enabled' => isset($input['nfc_tax_enabled']) ? 1 : 0,
        ];

        foreach ($taxSettings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return response()->json([
            'success' => true,
            'message' => __('messages.nfc.nfc_card_tax_saved_successfully'),
        ]);

    }
}
