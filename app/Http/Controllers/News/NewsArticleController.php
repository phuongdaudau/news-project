<?php

namespace App\Http\Controllers\News;

use App\Models\CategoryModel as CategoryModel;
use App\Models\ArticleModel as ArticleModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NewsArticleController extends Controller
{
    private $pathViewController = 'news.pages.article.';
    private $prefix = "article";
    private $model;
    private $params = [];

    public function __construct()
    {
        view()->share('prefix', $this->prefix);
    }

    public function index(Request $request)
    {
        $params['article_id'] = $request->article_id;
        $articleModel = new ArticleModel();
        $categoryModel = new CategoryModel();

        $itemArticle = $articleModel->getItem($params, ['task' => 'news-get-item']);
        if (empty($itemArticle)) return redirect()->route('home');

        $itemLatestArticle = $articleModel->listItems(null, ['task' => 'new-list-items-latest']);

        $params['category_id'] = $itemArticle['category_id'];
        $itemArticle['relatedArticle'] = $articleModel->listItems($params, ['task' => 'new-list-items-related-in-category']);

        $itemTag = $categoryModel->listItems(null, ['task' => 'new-list-items']);

        return view($this->pathViewController . 'index', [
            'params' =>  $this->params,
            'itemArticle' =>   $itemArticle,
            'itemTag' =>   $itemTag,
            'itemLatestArticle' => $itemLatestArticle
        ]);
    }
}

/* echo '<pre style="color:red">';
        print_r($itemCategory);
        echo '</pre>'; */