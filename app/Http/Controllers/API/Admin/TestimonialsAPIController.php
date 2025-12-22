<?php

namespace App\Http\Controllers\API\Admin;

use App\Models\Vcard;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AppBaseController;
use App\Repositories\TestimonialRepository;
use App\Http\Requests\CreateTestimonialRequest;
use App\Http\Requests\UpdateTestimonialRequest;

class TestimonialsAPIController extends AppBaseController
{
    private $testimonialRepo;
    public function __construct(TestimonialRepository $testimonialRepo)
    {
        $this->testimonialRepo = $testimonialRepo;
    }

    public function getVcardTestimonials($vcardId)
    {
        $testimonial = Testimonial::where('vcard_id', $vcardId)
            ->whereHas('vcard', function ($query) {
                $query->where('tenant_id', getLogInTenantId());
            })
            ->get();


        if (empty($testimonial)) {
            return $this->sendError('Testimonial not found.');
        }

        $testimonial->makeHidden(['created_at', 'updated_at', 'media'])->toArray();

        return $this->sendResponse($testimonial, 'Testimonial retrieved successfully.');
    }

    public function show($testimonialId)
    {
        $testimonial = Testimonial::where('id', $testimonialId)
            ->whereHas('vcard', function ($query) {
                $query->where('tenant_id', getLogInTenantId());
            })
            ->first();

        if (empty($testimonial)) {
            return $this->sendError('Testimonial not found.');
        }

        $product = $testimonial->makeHidden(['created_at', 'updated_at', 'media'])->toArray();

        return $this->sendResponse($testimonial, 'Testimonial retrieved successfully.');
    }

    public function store(CreateTestimonialRequest $request)
    {
        $input = $request->all();

        $vcard = Vcard::findOrFail($request->vcard_id);

        if ($vcard->tenant_id != getLogInTenantId()) {
            return $this->sendError('vCard not found.');
        }

        $testimonial = $this->testimonialRepo->store($input);

        return $this->sendSuccess('Testimonial created successfully.');
    }

    public function update(UpdateTestimonialRequest $request, $testimonialId)
    {

        $testimonial = Testimonial::where('id', $testimonialId)->whereHas('vcard', function ($query) {
            $query->where('tenant_id', getLogInTenantId());
        })->first();

        if (empty($testimonial)) {
            return $this->sendError('Testimonial not found.');
        }

        $input = $request->all();

        $testimonial = $this->testimonialRepo->update($input, $testimonial->id);

        return $this->sendSuccess('Testimonial updated successfully.');
    }


    public function destroy($id)
    {
        $testimonial = Testimonial::where('id', $id)
            ->whereHas('vcard', function ($query) {
                $query->where('tenant_id', getLogInTenantId());
            })
            ->first();

        if (empty($testimonial)) {
            return $this->sendError('Testimonial not found.');
        }
        $testimonial->delete();

        return $this->sendSuccess('Testimonial deleted successfully.');
    }
}
