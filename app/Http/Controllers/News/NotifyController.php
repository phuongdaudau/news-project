<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ArticleModel;

class NotifyController extends Controller
{
    private $pathViewController = 'news.pages.notify.';
    private $prefix = "notify";
    private $model;
    private $params = [];

    public function __construct()
    {
        view()->share('prefix', $this->prefix);
    }

    public function login(Request $request)
    {
        return view($this->pathViewController . 'login', []);
    }

    public function noPermission(Request $request)
    {
        $articleModel = new ArticleModel();
        $itemLatestArticle = $articleModel->listItems(null, ['task' => 'new-list-items-latest']);
        return view($this->pathViewController . 'no-permission', [
            'itemLatestArticle' => $itemLatestArticle
        ]);
    }
}

/* echo '<pre style="color:red">';
        print_r($itemCategory);
        echo '</pre>'; */