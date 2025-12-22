<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateWhatDriveUsRequest;
use Illuminate\Http\Request;
use App\Models\FrontSlider;
use App\Models\WhatDrivesUs;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Laracasts\Flash\Flash;

class WhatDrivesUsController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        $whatdrivesUs = WhatDrivesUs::with('media')->get();
        return view('sadmin.whatDrivesUs.index', compact('whatdrivesUs'));
    }
    /**
     * @return Application|RedirectResponse|Redirector
     */
    public function store(UpdateWhatDriveUsRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $inputs = $request->all();
            foreach ($inputs['title'] as $id => $input) {
                $whatDrivesUs = WhatDrivesUs::whereId($id)->first();
                $whatDrivesUs->update([
                    'title' => $input,
                    'description' => $inputs['description'][$id],
                ]);

                if (! empty($inputs['image']) && ! empty($inputs['image'][$id])) {
                    $whatDrivesUs->clearMediaCollection(WhatDrivesUs::PATH);
                    $whatDrivesUs->addMedia($inputs['image'][$id])->toMediaCollection(
                        WhatDrivesUs::PATH,
                        config('app.media_disc')
                    );
                }
            }
            DB::commit();
            Flash::success(__('messages.flash.what_drives_us_create'));
            return redirect(route('what-drives-us.index'));
        } catch (\Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
