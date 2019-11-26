<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Resources\PermissionResource;



class PermissionsController extends Controller
{

    //当前登录用户权限
    public function index(Request $request){
        $permissionns = $request->user()->getAllPermissions();
        PermissionResource::wrap('data');
        return PermissionResource::collection($permissionns);
    }

    //
}
