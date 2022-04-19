<?php

namespace App\Models;

use App\Models\AdminModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CategoryModel extends AdminModel
{
    protected $table                = 'category';
    protected $uploadFolder         = 'category';
    protected $searchFieldAccepted  = ['id', 'name'];
    protected $NotCrudAccepted      = ['_token'];

    public function listItems($params, $options)
    {
        $result = null;
        if ($options['task'] == 'admin-list-items') {
            $query = $this->select('id', 'name', 'status', 'is_home', 'display', 'created', 'created_by', 'modified', 'modified_by');
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
            $query = $this->select('id', 'name')->where('status', '=', 'active')->limit(8);
            $result = $query->get()->toArray();
        }
        if ($options['task'] == 'new-list-items-is-home') {
            $query = $this->select('id', 'name', 'display')->where('status', '=', 'active')->where('is_home', '=', '1');
            $result = $query->get()->toArray();
        }
        if ($options['task'] == 'admin-list-items-in-select-box') {
            $query = $this->select('id', 'name')->orderBy('name', 'asc')->where('status', '=', 'active');
            $result = $query->pluck('name', 'id')->toArray();
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
            $result = self::select('id', 'name', 'status')->where('id', $params['id'])->first();
        }
        if ($options['task'] == 'news-get-item') {
            $result = self::select('id', 'name', 'display')->where('id', $params['category_id'])->first();
            if ($result)  $result =  $result->toArray();
        }
        return $result;
    }
    public function saveItems($params = null, $options = null)
    {
        if ($options['task'] == 'change-status') {
            $status = ($params['currentStatus'] == "active") ? "inactive" : "active";
            self::where('id', $params['id'])->update(['status' => $status]);
        }
        if ($options['task'] == 'change-is-home') {
            $isHome = ($params['currentIsHome'] == "1") ? "0" : "1";
            self::where('id', $params['id'])->update(['is_home' => $isHome]);
        }
        if ($options['task'] == 'change-display') {
            $display = $params['currentDisplay'];
            self::where('id', $params['id'])->update(['display' => $display]);
        }
        if ($options['task'] == 'add-item') {
            $params['created_by'] = "phuong";
            $params['created'] = date('Y-m-d');
            self::insert($this->prepareItem($params));
        }
        if ($options['task'] == 'edit-item') {
            $params['modified_by'] = "phuong";
            $params['modified'] = date('Y-m-d');
            self::where('id', $params['id'])->update($this->prepareItem($params));
        }
    }
    public function deleteItems($params = null, $options = null)
    {
        if ($options['task'] == 'delete-item') {
            self::where('id', $params['id'])->delete();
        }
    }
}
