<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activities\AddActivityRequest;
use App\Http\Requests\Activities\UpdateActivityRequest;
use App\Models\Activity;
use App\Models\User;
use App\Services\Activities\ActivityService;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Connection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class ActivitiesController extends Controller
{
    /**
     * UsersController constructor.
     *
     * @param Connection $db
     * @param Activity $model
     * @param ActivityService $activityService
     */
    public function __construct(private Connection $db, private Activity $model, private ActivityService $activityService)
    {
        //
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', Activity::class);

        $userId = $request->get('user_id');
        $scheduledAt = $request->get('scheduled_at');

        $user = $userId ? User::findOrFail($userId) : auth()->user();

        $query = $this->model->user($user);

        if ($scheduledAt) {
            $query->scheduledAt($scheduledAt);
        }

        $query = $query->get();

        return response()->json($query);
    }

    /**
     * @param AddActivityRequest $request
     * @return JsonResponse|Exception
     * @throws Throwable
     */
    public function store(AddActivityRequest $request): JsonResponse|Exception
    {
        try {
            $this->db->beginTransaction();

            $activity = $this->model->create($request->validated());

            if ($request->file('upload_image')) {
                $this->activityService->uploadImage($activity, $request->file('upload_image'));
            }

            $this->activityService->syncUsers($activity, $request->get('users'));

            $this->db->commit();
        } catch (Exception $e) {
            $this->db->rollBack();
            return $e;
        }

        return response()->json(['message' => 'Activity successfully added.']);
    }

    /**
     * @param Activity $activity
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function show(Activity $activity): JsonResponse
    {
        $this->authorize('view', $activity);

        return response()->json($activity);
    }

    /**
     * @param UpdateActivityRequest $request
     * @param Activity $activity
     * @return JsonResponse|Exception
     * @throws Throwable
     */
    public function update(UpdateActivityRequest $request, Activity $activity): JsonResponse|Exception
    {
        try {
            $this->db->beginTransaction();

            $activity->update($request->validated());

            if ($request->file('upload_image')) {
                $this->activityService->uploadImage($activity, $request->file('upload_image'));
            }

            $this->db->commit();
        } catch (Exception $e) {
            $this->db->rollBack();
            return $e;
        }

        return response()->json(['message' => 'Activity successfully updated.']);
    }

    /**
     * @param Activity $activity
     * @return JsonResponse|Exception
     * @throws AuthorizationException
     */
    public function destroy(Activity $activity): JsonResponse|Exception
    {
        $this->authorize('delete', $activity);

        try {
            $activity->delete();
        } catch (Exception $e) {
            return $e;
        }

        return response()->json(['message' => 'Activity successfully deleted.']);
    }
}
