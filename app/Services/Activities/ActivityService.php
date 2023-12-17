<?php

namespace App\Services\Activities;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ActivityService
{
    /**
     * @param Activity $activity
     * @param UploadedFile $uploadedFile
     * @return Activity
     */
    public function uploadImage(Activity $activity, UploadedFile $uploadedFile): Activity
    {
        Storage::deleteDirectory('public/activities/' . $activity->id);

        $imageName = time() . '_' . $uploadedFile->getClientOriginalName();
        $imagePath = 'activities/' . $activity->id;

        $uploadedFile->storeAs($imagePath, $imageName, 'public');

        $activity->image_path = 'storage/' . $imagePath . '/' . $imageName;
        $activity->save();

        return $activity;
    }

    /**
     * @param Activity $activity
     * @param array|null $userIds
     * @return Activity
     */
    public function syncUsers(Activity $activity, array $userIds = null): Activity
    {
        if (!$userIds) {
            $userIds = User::all()->pluck('id');
        }

        $activity->users()->sync($userIds);

        return $activity;
    }
}
