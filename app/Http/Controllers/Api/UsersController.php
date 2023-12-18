<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

class UsersController extends Controller
{
    /**
     * @param User $model
     */
    public function __construct(private User $model)
    {
        //
    }

    /**
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function index(): JsonResponse
    {
        $this->authorize('viewAny', User::class);

        return response()->json($this->model->all());
    }

    /**
     * @return JsonResponse
     */
    public function account(): JsonResponse
    {
        $user = auth()->user();

        $user->load('roles');

        return response()->json($user);
    }
}
