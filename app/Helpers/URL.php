<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class URL
{
    public static function linkCategory($id, $name)
    {
        $link = route('chuyen-muc/index', [
            'category_id'   => $id,
            'category_name' => Str::slug($name)
        ]);
        return $link;
    }
    public static function linkArticle($id, $name)
    {
        $link = route('bai-viet/index', [
            'article_id'   => $id,
            'article_name' => Str::slug($name)
        ]);
        return $link;
    }
}
