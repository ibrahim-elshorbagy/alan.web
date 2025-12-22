<?php

namespace App\Http\Controllers\API\SuperAdmin;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Models\AddOn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use ZipArchive;

class AddOnAPIController extends AppBaseController
{
    public function addOnsData()
    {
        $addOnDatas = AddOn::all();

        if (!$addOnDatas) {
            return $this->sendError('No Slack Integration data found.');
        }

        foreach ($addOnDatas as $addOnData) {
            $data[] = [
                'id' => $addOnData->id,
                'name' => $addOnData->name,
                'status' => $addOnData->status,
            ];
        }

        return $this->sendResponse($data, 'Add Ons Data Retrieve Successfully.');
    }

    public function extractZip(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:zip'
        ]);

        $file = $request->file('file');
        $filePathInfo = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extractionPath = base_path('Modules/');
        $moduleFolder = $extractionPath . $filePathInfo;

        if (is_dir($moduleFolder)) {
            return $this->sendError(__('messages.addon.module_folder_already_exists'));
        }

        $isExistFiles = [
            $filePathInfo . '/' . 'composer.json',
            $filePathInfo . '/' . 'Providers/RouteServiceProvider.php'
        ];
        $zip = new ZipArchive;

        if ($zip->open($file) === TRUE) {
            $fileNames = [];
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $fileNames[] = $zip->getNameIndex($i);
            }

            $checkFiles = [];
            foreach ($isExistFiles as $isExistFile) {
                if (!in_array($isExistFile, $fileNames)) {
                    $checkFiles[] = $isExistFile;
                }
            }

            $zip->close();

            if (!empty($checkFiles)) {
                return $this->sendError(__('messages.addon.zip_required_file'));
            }

            if ($zip->open($file) === TRUE) {
                $zip->extractTo($extractionPath);
                $zip->close();

                $addOn = AddOn::updateOrCreate([
                    'name' => $filePathInfo,
                ]);

                $content = file_get_contents(base_path("modules_statuses.json"));
                $content = json_decode($content, true);
                $content[$filePathInfo] = true;
                file_put_contents(base_path("modules_statuses.json"), json_encode($content));

            } else {
                return $this->sendError(__('messages.addon.failed_to_extraction'));
            }

            sleep(2);

            return $this->sendSuccess(__('messages.addon.addon_uploaded_successfully'));
        } else {
            return $this->sendError(__('messages.addon.failed_to_open'));
        }
    }

    public function update(Request $request, $id)
    {
        $addOn = AddOn::find($id);

        if (is_null($addOn)) {
            return $this->sendError('Add On not found.');
        }

        $request->validate([
            'status' => 'required|boolean',
        ]);

        $addOn->status = $request->input('status');
        $addOn->save();

        return $this->sendResponse($addOn, 'Add On updated successfully.');
    }

    public function destroy($id)
    {
        $addOnModule = AddOn::find($id);
        // if ($addOnModule) {
        //     return $this->sendError(__('messages.placeholder.default_module_can_not_be_delete'));
        // }

        if (is_null($addOnModule)) {
            return $this->sendError('Add On not found.');
        }

        $modulePath = base_path('Modules/' . $addOnModule->name);

        if (File::exists($modulePath)) {
            File::deleteDirectory($modulePath);
        }

        $addOnModule->delete();

        return $this->sendSuccess('Add On deleted successfully.');
    }
}
