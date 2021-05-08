<?php

namespace Mpemburn\RoleVue\Controllers;

use App\User;
use Mpemburn\RoleVueServices\PermissionsCrudService;
use Mpemburn\RoleVueServices\UserRolesService;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controller;

class RoleVueAdminController extends Controller
{
    protected UserRolesService $userRolesService;
    protected PermissionsCrudService $crudService;

    public function __construct(
        UserRolesService $userRolesService,
        PermissionsCrudService $crudService
    )
    {
        $this->userRolesService = $userRolesService;
        $this->crudService = $crudService;
    }

    public function roles()
    {
        return view('roles.index')
            ->with('action', '/api/roles/')
            ->with('roles', $this->crudService->getAllRoles())
            ->with('protectedRoles', $this->crudService->getProtectedRoles())
            ->with('permissions', $this->crudService->getAllPermissions())
            ->with('disabled', '');
    }

    public function permissions()
    {
        return view('permissions.index')
            ->with('action', '/api/permissions/')
            ->with('permissions', $this->crudService->getAllPermissions());
    }

    public function userRoles()
    {
        return view('user-roles.index')
            ->with('action', '/api/user_roles/')
            ->with('users', $this->crudService->getAllUsers())
            ->with('currentUserIsAdmin', $this->userRolesService->isCurrentUserAdmin())
            ->with('getAssignedEndpoint', UserRolesService::GET_ASSIGNED_PERMISSIONS_ENDPOINT)
            ->with('roles', $this->crudService->getAllRoles())
            ->with('permissions', $this->crudService->getAllPermissions());
    }
}
