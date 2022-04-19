<?php

namespace App\Models;

use App\Models\AdminModel;
use Illuminate\Support\Facades\DB;

class SliderModel extends AdminModel
{
    protected $table                = 'slider';
    protected $uploadFolder         = 'slider';
    protected $searchFieldAccepted  = ['id', 'name', 'description', 'link'];
    protected $NotCrudAccepted      = ['_token', 'thumb_current'];

    public function listItems($params, $options)
    {
        $result = null;
        if ($options['task'] == 'admin-list-items') {
            $query = $this->select('id', 'name', 'description', 'status', 'link', 'thumb', 'created', 'created_by', 'modified', 'modified_by');
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
            $query = $this->select('id', 'name', 'description', 'status', 'link', 'thumb')
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
            $result = self::select('id', 'name', 'description', 'status', 'link', 'thumb')->where('id', $params['id'])->first();
        }
        if ($options['task'] == 'get-thumb') {
            $result = self::select('id', 'thumb')->where('id', $params['id'])->first();
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
            $params['thumb'] = $this->uploadThumb($params['thumb']);
            self::insert($this->prepareItem($params));
        }
        if ($options['task'] == 'edit-item') {
            if (!empty($params['thumb'])) {
                $this->deleteThumb($params['thumb_current']);
                $params['thumb'] = $this->uploadThumb($params['thumb']);
            }
            $params['modified_by'] = "phuong";
            $params['modified'] = date('Y-m-d');
            self::where('id', $params['id'])->update($this->prepareItem($params));
        }
    }
    public function deleteItems($params = null, $options = null)
    {
        if ($options['task'] == 'delete-item') {
            $item = self::getItem($params, ['task' => 'get-thumb']);
            $this->deleteThumb($item['thumb']);
            self::where('id', $params['id'])->delete();
        }
    }
}
