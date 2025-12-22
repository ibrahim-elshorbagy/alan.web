<?php

namespace App\Repositories;

use Exception;
use App\Models\LinkedinEmbed;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class LinkedinEmbedRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'type',
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
        return LinkedinEmbed::class;
    }

    /**
     * @return mixed
     *
     */
    public function store($input)
    {
        try {
            DB::beginTransaction();

            $input['embedtag'] = str_replace(['data-linkedin-captioned'], '', $input['embedtag']);
            $url = explode('/', $input['embedtag']);
            $urnPart = $url[6] ?? '';

            if (isset($url[3]) && ($url[3] == 'embed')) {
                if ($input['type'] == 0 && !str_contains($urnPart, 'ugcPost')) {
                    throw new UnprocessableEntityHttpException(__('messages.flash.post_type_content'));
                }
            } else {
                throw new UnprocessableEntityHttpException(__('messages.flash.embedtag_content'));
            }

            $embed = LinkedinEmbed::create($input);

            DB::commit();

            return $embed;
        } catch (Exception $e) {
            DB::rollBack();

            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    /**
     * @return Builder|Builder[]|Collection|Model
     */
    public function update($input, $id)
    {
        try {
            DB::beginTransaction();

            $input['embedtag'] = str_replace(['data-linkedin-captioned'], '', $input['embedtag']);
            $url = explode('/', $input['embedtag']);
            $urnPart = $url[6] ?? '';

            if (isset($url[3]) && ($url[3] == 'embed')) {
                if ($input['type'] == 0 && !str_contains($urnPart, 'ugcPost')) {
                    throw new UnprocessableEntityHttpException(__('messages.flash.post_type_content'));
                }
            } else {
                throw new UnprocessableEntityHttpException(__('messages.flash.embedtag_content'));
            }

            $embed = LinkedinEmbed::findOrFail($id);

            $embed->update($input);

            DB::commit();

            return $embed;
        } catch (Exception $e) {
            DB::rollBack();

            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
