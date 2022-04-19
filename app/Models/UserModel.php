<?php

namespace App\Models;

use App\Models\AdminModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserModel extends AdminModel
{
    protected $table                = 'user';
    protected $uploadFolder         = 'user';
    protected $searchFieldAccepted  = ['id', 'username', 'email', 'fullname'];
    protected $NotCrudAccepted      = ['_token', 'avatar_current', 'password_confirmation', 'task'];

    public function listItems($params, $options)
    {
        $result = null;
        if ($options['task'] == 'admin-list-items') {
            $query = $this->select('id', 'username', 'email', 'status', 'level', 'fullname', 'avatar', 'created', 'created_by', 'modified', 'modified_by');
            //filter 
            if ($params['filter']['status'] !== 'all') {
                $query->where('status', '=', $params['filter']['status']);
            }
            //search
            if ($params['search']['value'] !== "") {
                if ($params['search']['field'] == "all") {
                    $query->where(function ($query) use ($params) {
                        foreach ($this->searchFieldAccepted as $column) {
                            $query->orWhere($column, 'LIKE', "%{$params['search']['value']}%");
                        }
                    });
                } else if (in_array($params['search']['field'], $this->searchFieldAccepted)) {
                    $query->where($params['search']['field'], 'LIKE', "%{$params['search']['value']}%");
                }
            }

            $result = $query //->orderBy('id', 'desc')
                ->paginate($params['pagination']['totalItemsPerPage']);
        }
        if ($options['task'] == 'new-list-items') {
            $query = $this->select('id', 'username', 'email', 'status', 'level', 'fullname', 'avatar')
                ->where('status', '=', 'active')->limit(5);
            $result = $query->get()->toArray();
        }
        return $result;
    }
    public function countItems($params = null, $options = null)
    {
        $query = $this->groupBy('status')
            ->select(DB::raw('count(id) as count, status'));

        //search
        if ($params['search']['value'] !== "") {
            if ($params['search']['field'] == "all") {
                $query->where(function ($query) use ($params) {
                    foreach ($this->searchFieldAccepted as $column) {
                        $query->orWhere($column, 'LIKE', "%{$params['search']['value']}%");
                    }
                });
            } else if (in_array($params['search']['field'], $this->searchFieldAccepted)) {
                $query->where($params['search']['field'], 'LIKE', "%{$params['search']['value']}%");
            }
        }
        return $query->get()->toArray();;
    }
    public function getItem($params = null, $options = null)
    {
        $result = null;
        if ($options['task'] == 'get-item') {
            $result = self::select('id', 'username', 'email', 'status', 'level', 'fullname', 'avatar')->where('id', $params['id'])->first();
        }
        if ($options['task'] == 'get-avatar') {
            $result = self::select('id', 'avatar')->where('id', $params['id'])->first();
        }
        if ($options['task'] == 'auth-login') {;
            $result = self::select('id', 'username', 'email', 'status', 'level', 'fullname', 'avatar')
                ->where('status', '=', 'active')
                ->where('email', '=',  $params['email'])
                ->where('password', '=',  md5($params['password']))
                ->first();
            if ($result) $result = $result->toArray();
        }
        return $result;
    }
    public function saveItems($params = null, $options = null)
    {
        if ($options['task'] == 'change-status') {
            $status = ($params['currentStatus'] == "active") ? "inactive" : "active";
            self::where('id', $params['id'])->update(['status' => $status]);
        }
        if ($options['task'] == 'add-item') {
            $params['created_by'] = "phuong";
            $params['created'] = date('Y-m-d');
            $params['avatar'] = $this->uploadThumb($params['avatar']);
            $params['password'] = md5($params['password']); //md5($params['password']); 
            self::insert($this->prepareItem($params));
        }
        if ($options['task'] == 'edit-item') {
            if (!empty($params['avatar'])) {
                $this->deleteThumb($params['avatar_current']);
                $params['avatar'] = $this->uploadThumb($params['avatar']);
            }
            $params['modified_by'] = "phuong";
            $params['modified'] = date('Y-m-d');
            self::where('id', $params['id'])->update($this->prepareItem($params));
        }
        if ($options['task'] == 'change-level') {
            $level = $params['currentLevel'];
            self::where('id', $params['id'])->update(['level' => $level]);
        }
        if ($options['task'] == 'change-level-post') {
            $level = $params['level'];
            self::where('id', $params['id'])->update(['level' => $level]);
        }
        if ($options['task'] == 'change-password') {
            $password = md5($params['password']);
            self::where('id', $params['id'])->update(['password' => $password]);
        }
        if ($options['task'] == 'register-account') {
            $params['password'] = md5($params['password']); //md5($params['password']); 
            self::insert($this->prepareItem($params));
        }
    }
    public function deleteItems($params = null, $options = null)
    {
        if ($options['task'] == 'delete-item') {
            $item = self::getItem($params, ['task' => 'get-avatar']);
            $this->deleteThumb($item['avatar']);
            self::where('id', $params['id'])->delete();
        }
    }
}
