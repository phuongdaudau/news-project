<?php

namespace App\Http\Controllers\News;

use App\Models\CategoryModel as CategoryModel;
use App\Models\ArticleModel as ArticleModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NewsCategoryController extends Controller
{
    private $pathViewController = 'news.pages.category.';
    private $prefix = "category";
    private $model;
    private $params = [];

    public function __construct()
    {
        view()->share('prefix', $this->prefix);
    }

    public function index(Request $request)
    {
        $params['category_id'] = $request->category_id;
        $articleModel = new ArticleModel();
        $categoryModel = new CategoryModel();

        $itemCategory = $categoryModel->getItem($params, ['task' => 'news-get-item']);
        $itemTag = $categoryModel->listItems(null, ['task' => 'new-list-items']);

        //$categoryId = isset($itemCategory['id']) ? $itemCategory['id'] : 0;
        if (empty($itemCategory)) return redirect()->route('home');

        $itemLatestArticle = $articleModel->listItems(null, ['task' => 'new-list-items-latest']);

        $itemCategory['article'] = $articleModel->listItems(['category_id' => $itemCategory['id']], ['task' => 'new-list-items-in-category-news']);

        return view($this->pathViewController . 'index', [
            'params' =>  $this->params,
            'itemTag' =>   $itemTag,
            'itemCategory' =>   $itemCategory,
            'itemLatestArticle' => $itemLatestArticle
        ]);
    }
}

/* echo '<pre style="color:red">';
        print_r($itemCategory);
        echo '</pre>'; */