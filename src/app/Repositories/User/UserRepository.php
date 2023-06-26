<?php
namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function getModel()
    {
        return User::class;
    }

    public function getUser($paginate = null)
    {
        if(isset($paginate)) {
            return DB::table('users')->simplePaginate($paginate);
        }
        return $this->model->get();
    }
}
