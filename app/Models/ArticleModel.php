<?php

namespace App\Models;

use App\Models\AdminModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ArticleModel extends AdminModel
{
    protected $table                = 'article as a';
    protected $uploadFolder         = 'article';
    protected $searchFieldAccepted  = ['name', 'content'];
    protected $NotCrudAccepted      = ['_token', 'thumb_current'];

    public function listItems($params, $options)
    {
        $result = null;
        if ($options['task'] == 'admin-list-items') {
            $query = $this->select(
                'a.id',
                'a.name',
                'a.content',
                'a.status',
                'a.thumb',
                'a.type',
                'a.category_id',
                'a.created',
                'a.created_by',
                'a.modified',
                'a.modified_by',
                'c.name as category_name'
            )->leftJoin('category as c', 'a.category_id', '=', 'c.id');
            //filter 
            if ($params['filter']['status'] !== 'all') {
                $query->where('a.status', '=', $params['filter']['status']);
            }
            //search
            if ($params['search']['value'] !== "") {
                if ($params['search']['field'] == "all") {
                    $query->where(function ($query) use ($params) {
                        foreach ($this->searchFieldAccepted as $column) {
                            $query->orWhere('a.' . $column, 'LIKE', "%{$params['search']['value']}%");
                        }
                    });
                } else if (in_array($params['search']['field'], $this->searchFieldAccepted)) {
                    $query->where('a.' . $params['search']['field'], 'LIKE', "%{$params['search']['value']}%");
                }
            }
            $result = $query->orderBy('a.id', 'desc')
                ->paginate($params['pagination']['totalItemsPerPage']);
        }

        if ($options['task'] == 'new-list-items') {
            $query = $this->select('id', 'name', 'content', 'status',  'thumb',)
                ->where('status', '=', 'active')->limit(5);
            $result = $query->get()->toArray();
        }

        if ($options['task'] == 'new-list-items-featured') {
            $query = $this->select('a.id', 'a.name', 'a.content', 'a.created',  'a.thumb', 'a.type', 'a.category_id', 'c.name as category_name')
                ->leftJoin('category as c', 'a.category_id', '=', 'c.id')
                ->where('a.status', '=', 'active')
                ->where('a.type', '=', 'feature')
                ->orderBy('a.id', 'desc')
                ->take(3);
            $result = $query->get()->toArray();
        }

        if ($options['task'] == 'new-list-items-latest') {
            $query = $this->select('a.id', 'a.name', 'a.content', 'a.created',  'a.thumb', 'a.type', 'a.category_id', 'c.name as category_name')
                ->leftJoin('category as c', 'a.category_id', '=', 'c.id')
                ->where('a.status', '=', 'active')
                ->orderBy('a.id', 'asc')
                ->take(4);
            $result = $query->get()->toArray();
        }

        if ($options['task'] == 'new-list-items-in-category') {
            $query = $this->select('id', 'name', 'content', 'created',  'thumb')
                ->where('status', '=', 'active')
                ->where('category_id', '=',  $params['category_id'])
                ->take(2);
            $result = $query->get()->toArray();
        }

        if ($options['task'] == 'new-list-items-in-category-news') {
            $query = $this->select('id', 'name', 'content', 'created',  'thumb')
                ->where('status', '=', 'active')
                ->where('category_id', '=',  $params['category_id'])
                ->take(10);
            $result = $query->get()->toArray();
        }

        if ($options['task'] == 'new-list-items-related-in-category') {
            $query = $this->select('id', 'name', 'content',  'thumb', 'created')
                ->where('status', '=', 'active')
                ->where('id', '!=',  $params['article_id'])
                ->where('category_id', '=',  $params['category_id'])
                ->take(4);
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
            $result = self::select('id', 'name', 'content', 'status',  'thumb', 'category_id')->where('id', $params['id'])->first();
        }
        if ($options['task'] == 'get-thumb') {
            $result = self::select('id', 'thumb')->where('id', $params['id'])->first();
        }
        if ($options['task'] == 'news-get-item') {
            $result = $this->select('a.id', 'a.name', 'a.content', 'a.created',  'a.thumb', 'a.type', 'a.category_id', 'c.name as category_name')
                ->leftJoin('category as c', 'a.category_id', '=', 'c.id')
                ->where('a.status', '=', 'active')
                ->where('a.id', '=',  $params['article_id'])
                ->first();
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
        if ($options['task'] == 'change-type') {
            self::where('id', $params['id'])->update(['type' => $params['currentType']]);
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
