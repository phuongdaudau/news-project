<?php

namespace App\Models;

use App\Models\AdminModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class RssModel extends AdminModel
{
    protected $table                = 'rss';
    protected $uploadFolder         = 'rss';
    protected $searchFieldAccepted  = ['id', 'name', 'link'];
    protected $NotCrudAccepted      = ['_token'];

    public function listItems($params, $options)
    {
        $result = null;
        if ($options['task'] == 'admin-list-items') {
            $query = $this->select('id', 'name', 'status', 'link', 'odering', 'source', 'created', 'created_by', 'modified', 'modified_by');
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

            $result = $query->orderBy('odering', 'asc')
                ->paginate($params['pagination']['totalItemsPerPage']);
        }
        if ($options['task'] == 'new-list-items') {
            $query = $this->select('id', 'name', 'status', 'link', 'odering', 'source')
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
            $result = self::select('id', 'name', 'status', 'link', 'odering', 'source')->where('id', $params['id'])->first();
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
