<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Models\WhatsappStore;
use App\Models\WhatsappStoreTrendingVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class WPTrendingVideoAPIController extends AppBaseController
{
    public function getTrendingVideos(WhatsappStore $whatsappStore)
    {
        if ($whatsappStore->tenant_id != getLogInTenantId()) {
            return $this->sendError('Whatsapp Store not found.');
        }

        $wpTrendingVideos = WhatsappStoreTrendingVideo::where('whatsapp_store_id', $whatsappStore->id)
            ->orderBy('id')
            ->get();

        $data = [];

        foreach( $wpTrendingVideos as $video) {
            $data[] = [
                'id' => $video->id,
                'youtube_link' => $video->youtube_link,
            ];
        }

        return $this->sendResponse($data, 'Trending Videos retrieved successfully.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'whatsapp_store_id' => 'required|integer|exists:whatsapp_stores,id',
            'youtube_link' => 'required|array',
            'youtube_link.*' => 'required|string'
        ]);

        $whatsappStore = WhatsappStore::find($request->whatsapp_store_id);
        if (!$whatsappStore || $whatsappStore->tenant_id != getLogInTenantId()) {
            return $this->sendError('Whatsapp Store not found.');
        }

        $links = $request->youtube_link;

        if (count($links) !== count(array_unique($links))) {
            return $this->sendError("Duplicate YouTube links in request are not allowed.");
        }

        $exists = WhatsappStoreTrendingVideo::where('whatsapp_store_id', $request->whatsapp_store_id)
            ->whereIn('youtube_link', $links)
            ->pluck('youtube_link')
            ->toArray();

        if (!empty($exists)) {
            return $this->sendError("These YouTube links already exist: " . implode(", ", $exists));
        }

        foreach ($links as $link) {
            WhatsappStoreTrendingVideo::create([
                'whatsapp_store_id' => $request->whatsapp_store_id,
                'youtube_link' => $link,
            ]);
        }

        return $this->sendSuccess('Trending Videos created successfully.');
    }

    public function updateMultiple(Request $request)
    {
        $request->validate([
            'whatsapp_store_id' => 'required|integer',
            'videos' => 'required|array',
            'videos.*.youtube_link' => 'required|string'
        ]);

        $storeId = $request->whatsapp_store_id;

        // Verify store
        $store = WhatsappStore::findOrFail($storeId);
        if ($store->tenant_id != getLogInTenantId()) {
            return $this->sendError('Unauthorized access.');
        }

        //CHECK FOR DUPLICATES IN PAYLOAD
        $links = collect($request->videos)->pluck('youtube_link');

        if ($links->count() !== $links->unique()->count()) {
            return $this->sendError("Duplicate YouTube links in request are not allowed.");
        }

        //CHECK DB DUPLICATES (Ignore same ID)
        foreach ($request->videos as $video) {
            $query = WhatsappStoreTrendingVideo::where('whatsapp_store_id', $storeId)
                        ->where('youtube_link', $video['youtube_link']);

            if (isset($video['id'])) {
                $query->where('id', '!=', $video['id']);
            }

            if ($query->exists()) {
                return $this->sendError("Duplicate YouTube link already exists in database.");
            }
        }

        //PERFORM UPDATE + CREATE
        foreach ($request->videos as $video) {
            // UPDATE
            if (!empty($video['id'])) {
                WhatsappStoreTrendingVideo::where('id', $video['id'])
                    ->where('whatsapp_store_id', $storeId)
                    ->update([
                        'youtube_link' => $video['youtube_link']
                    ]);
            }
            // CREATE
            else {
                WhatsappStoreTrendingVideo::create([
                    'whatsapp_store_id' => $storeId,
                    'youtube_link' => $video['youtube_link']
                ]);
            }
        }

        return $this->sendSuccess("Trending Videos updated successfully.");
    }

    public function delete(Request $request, $id)
    {
        $video = WhatsappStoreTrendingVideo::findOrFail($id);

        if ($video->whatsappStore->tenant_id != getLogInTenantId()) {
            return $this->sendError('Unauthorized access.');
        }

        $video->delete();

        return $this->sendSuccess('Trending Video deleted successfully.');
    }
}
