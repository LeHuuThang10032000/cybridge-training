<?php
namespace App\Repositories\Permission;

use App\Repositories\BaseRepository;
use Spatie\Permission\Models\Permission;

class PermissionRepository extends BaseRepository implements PermissionRepositoryInterface
{
    public function getModel()
    {
        return Permission::class;
    }

    public function getPermissionByName($attr = null)
    {
        if(is_array($attr)) {
            return $this->model->whereIn('name', $attr)->get();
        }
        return $this->model->where('name', $attr)->first();
    }
}