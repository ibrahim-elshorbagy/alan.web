<?php

namespace App\Repositories;

use App\Models\Banner;
use App\Models\VcardSections;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Yajra\DataTables\Exceptions\Exception;


class BannerRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'url',
        'title',
        'description',
    ];

    /**
     * Return searchable fields
     */
    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Banner::class;
    }

    /**
     * @return mixed
     */
    public function store($input)
    {
        try {
            DB::beginTransaction();

            $vcardId = $input['vcard_id'];

            $banner = Banner::updateOrCreate(
                ['vcard_id' => $vcardId],
                [
                    'banner_enable' => isset($input['banner_enable']) ? 1 : 0,
                    'url' => isset($input['url']) ? $input['url'] : null,
                    'title' => isset($input['title']) ? $input['title'] : null,
                    'banner_button' => isset($input['banner_button']) ? $input['banner_button'] : null,
                    'description' => isset($input['description']) ? $input['description'] : null,
                    'vcard_id' => $vcardId
                ]
            );

            $vcardSection = VcardSections::where('vcard_id', $vcardId)->first();
            if ($vcardSection) {
                $vcardSection->banner = isset($input['banner']) ? $input['banner'] : 0;
                $vcardSection->save();
            } else {
                VcardSections::updateOrcreate(
                    ['vcard_id' => $vcardId],
                    [
                        'vcard_id' => $vcardId,
                        'header' => 1,
                        'contact_list' => 1,
                        'services' => 1,
                        'products' => 1,
                        'galleries' => 1,
                        'blogs' => 1,
                        'map' => 1,
                        'testimonials' => 1,
                        'business_hours' => 1,
                        'appointments' => 1,
                        'insta_embed' => 1,
                        'banner' => isset($input['banner']) ? $input['banner'] : 0,
                        'iframe' => 1,
                        'news_latter_popup' => 1,
                        'one_signal_notification' => 1,
                    ]
                );
            }

            DB::commit();

            return $banner;
        } catch (Exception $e) {
            DB::rollBack();

            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
