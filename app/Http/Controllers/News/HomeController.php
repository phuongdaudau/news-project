<?php

namespace App\Http\Controllers\News;

use App\Models\SliderModel as SliderModel;
use App\Models\CategoryModel as CategoryModel;
use App\Models\ArticleModel as ArticleModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $pathViewController = 'news.pages.home.';
    private $prefix = "home";
    private $model;
    private $params = [];

    public function __construct()
    {
        view()->share('prefix', $this->prefix);
    }

    public function index(Request $request)
    {
        $sliderModel = new SliderModel();
        $categoryModel = new CategoryModel();
        $articleModel = new ArticleModel();

        $itemSlider = $sliderModel->listItems(null, ['task' => 'new-list-items']);
        $itemCategory = $categoryModel->listItems(null, ['task' => 'new-list-items-is-home']);
        $itemTag = $categoryModel->listItems(null, ['task' => 'new-list-items']);
        $itemArticle = $articleModel->listItems(null, ['task' => 'new-list-items-featured']);
        $itemLatestArticle = $articleModel->listItems(null, ['task' => 'new-list-items-latest']);

        foreach ($itemCategory as $key => $category)
            // $param['category_id'] = $category['id']; viết rõ hoặc viết gọn như dưới
            $itemCategory[$key]['article'] = $articleModel->listItems(['category_id' => $category['id']], ['task' => 'new-list-items-in-category']);

        return view($this->pathViewController . 'index', [
            'params' =>  $this->params,
            'itemSlider' =>   $itemSlider,
            'itemCategory' =>   $itemCategory,
            'itemTag' =>   $itemTag,
            'itemArticle' => $itemArticle,
            'itemLatestArticle' => $itemLatestArticle
        ]);
    }
}

/* echo '<pre style="color:red">';
        print_r($itemCategory);
        echo '</pre>'; */