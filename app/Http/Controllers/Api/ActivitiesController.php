<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activities\AddActivityRequest;
use App\Http\Requests\Activities\UpdateActivityRequest;
use App\Models\Activity;
use App\Models\User;
use App\Services\Activities\ActivityService;
use Exception;
use Illuminate\Database\Connection;
use Illuminate\Http\Request;

class ActivitiesController extends Controller
{
    /**
     * @var Connection
     */
    private $db;

    /**
     * @var User
     */
    private $model;

    /**
     * @var ActivityService
     */
    private $activityService;

    /**
     * UsersController constructor.
     *
     * @param Connection $db
     * @param Activity $activity
     * @param ActivityService $activityService
     */
    public function __construct(Connection $db, Activity $activity, ActivityService $activityService)
    {
        $this->db = $db;
        $this->model = $activity;
        $this->activityService = $activityService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
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
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(AddActivityRequest $request)
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
     * @param Request $request
     * @param Activity $activity
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Request $request, Activity $activity)
    {
        $this->authorize('view', $activity);

        return response()->json($activity);
    }

    /**
     * @param UpdateActivityRequest $request
     * @param Activity $activity
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function update(UpdateActivityRequest $request, Activity $activity)
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
     * @param Request $request
     * @param Activity $activity
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Request $request, Activity $activity)
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
