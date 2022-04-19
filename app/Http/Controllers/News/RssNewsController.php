<?php

namespace App\Http\Controllers\News;

use App\Models\RssModel as RssModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Feed;

class RssNewsController extends Controller
{
    private $pathViewController = 'news.pages.rss.';
    private $prefix = "rss";
    private $model;
    private $params = [];

    public function __construct()
    {
        view()->share('prefix', $this->prefix);
    }

    public function index(Request $request)
    {
        view()->share('title', 'Tin tức tổng hợp');
        $rssModel = new RssModel();

        $itemsRss = $rssModel->listItems(null, ['task' => 'new-list-items']);
        $data = Feed::read($itemsRss);

        return view($this->pathViewController . 'index', [
            'items' =>  $data,
        ]);
    }
    public function getGold()
    {
        $itemsGold = Feed::getGold();
        return view($this->pathViewController . 'child-index.gold_box', [
            'itemsGold' =>  $itemsGold,
        ]);
    }
    public function getCoin()
    {
        $itemsCoin = Feed::getCoin();
        return view($this->pathViewController . 'child-index.coin_box', [
            'itemsCoin' =>  $itemsCoin,
        ]);
    }
}
 
/* echo '<pre style="color:red">';
    print_r($itemCategory);
    echo '</pre>';
    die(); */