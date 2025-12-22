<?php

namespace App\Http\Controllers;

use App\Models\FrontSlider;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Laracasts\Flash\Flash;

class FrontSliderController extends AppBaseController
{
    public function index(): \Illuminate\View\View
    {
        $frontSlider = FrontSlider::with('media')->get();
        return view('sadmin.frontSlider.index', compact('frontSlider'));
    }
    /**
     * @return Application|RedirectResponse|Redirector
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $inputs = $request->all();
            if (isset($inputs['image'])) {
                foreach ($inputs['image'] as $id => $image) {
                    $frontSlider = FrontSlider::whereId($id)->first();
                    if ($frontSlider) {
                        $frontSlider->clearMediaCollection(FrontSlider::PATH);
                        $frontSlider->addMedia($inputs['image'][$id])->toMediaCollection(
                            FrontSlider::PATH,
                            config('app.media_disc')
                        );
                    }
                }
            }
            DB::commit();
            Flash::success(__('messages.flash.front_slider_create'));
            return redirect(route('front-slider.index'));
        } catch (\Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
