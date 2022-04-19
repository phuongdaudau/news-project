<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SliderModel as MainModel;
use App\Http\Requests\SliderRequest as MainRequest;

class SliderController extends Controller
{
    private $pathViewController = 'admin.slider.';
    private $prefix = "slider";
    private $model;
    private $params = [];

    public function __construct()
    {
        $this->model = new MainModel();
        $this->params["pagination"]["totalItemsPerPage"] = 3;
        view()->share('prefix', $this->prefix);
    }

    public function index(Request $request)
    {
        $this->params['filter']['status'] = $request->input('filter_status', 'all');
        $this->params['search']['field'] = $request->input('search_field', '');
        $this->params['search']['value'] = $request->input('search_value', '');

        $items = $this->model->listItems($this->params, ['task' => 'admin-list-items']);
        $itemsStatusCount = $this->model->countItems($this->params, ['task' => 'admin-count-items-group-by-status']); //[ ['status', 'count'] ]

        return view($this->pathViewController . 'index', [
            'params' =>  $this->params,
            'items' => $items,
            'itemsStatusCount' => $itemsStatusCount
        ]);
    }

    public function form(Request $request)
    {
        $item = NULL;
        if ($request->id !== NULL) {
            $params["id"]  = $request->id;
            $item = $this->model->getItem($params, ['task' => 'get-item']);
        }
        return view($this->pathViewController . 'form', [
            'item' => $item
        ]);
    }
    public function save(MainRequest $request)
    {
        if ($request->method() ==  'POST') {
            $params = $request->all();

            $task = "add-item";
            $notify = "Thêm phần tử thành công!";

            if ($params['id'] !== NULL) {
                $task = "edit-item";
                $notify = "Chỉnh sửa phần tử thành công!";
            }
            $this->model->saveItems($params, ['task' => $task]);
            return redirect()->route($this->prefix)->with('Notify',  $notify);
        }
    }
    public function delete(Request $request)
    {
        $params['id']           = $request->id;
        $this->model->deleteItems($params, ['task' => 'delete-item']);
        return redirect()->route($this->prefix)->with('Notify', 'Xóa phần tử thành công!');
    }
    public function status(Request $request)
    {
        $params["currentStatus"] = $request->status;
        $params["id"]           = $request->id;
        $this->model->saveItems($params, ['task' => 'change-status']);
        $status = $request->status == 'active' ? 'inactive' : 'active';
        $link = route($this->prefix . '/status', ['status' => $status, 'id' => $request->id]);
        return response()->json([
            'statusObj' => config('phon.template.status')[$status],
            'link' => $link,
        ]);
    }
}
