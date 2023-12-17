<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\Connection;
use Illuminate\Http\Request;

class UsersController extends Controller
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
     * UsersController constructor.
     *
     * @param Connection $db
     * @param User $user
     */
    public function __construct(Connection $db, User $user)
    {
        $this->db = $db;
        $this->model = $user;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', User::class);

        return response()->json($this->model->all());
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function account(Request $request)
    {
        $user = auth()->user();

        $user->load('roles');

        return response()->json($user);
    }
}
