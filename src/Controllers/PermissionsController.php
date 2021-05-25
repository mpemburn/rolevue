<?php

namespace Mpemburn\RoleVue\Controllers;

use Illuminate\Support\Facades\Config;
use Mpemburn\RoleVue\Models\PermissionUi;
use Mpemburn\RoleVue\Services\PermissionsCrudService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controller;

class PermissionsController extends Controller
{
    protected PermissionsCrudService $crudService;

    public function __construct(PermissionsCrudService $permissionsService)
    {
        $this->crudService = $permissionsService;
    }

    public function index(Request $request): JsonResponse
    {
        $permissions = Permission::all();

        return response()->json(['success' => true, 'permissions' => $permissions]);
    }

    public function show(Request $request, int $permissionId): JsonResponse
    {
        $permission = Permission::findById($permissionId, Config::get('rolevue.default_guard_name'));

        return response()->json(['success' => true, 'permission' => $permission]);
    }

    public function store(Request $request): JsonResponse
    {
        return $this->crudService->create($request, new PermissionUi());
    }

    public function update(Request $request): JsonResponse
    {
        return $this->crudService->update($request, new PermissionUi());
    }

    public function destroy(Request $request): JsonResponse
    {
        return $this->crudService->delete($request, new PermissionUi());
    }
}
