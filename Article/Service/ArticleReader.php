<?php

namespace NetBricks\Article\Service;
use \NetBricks\Article\Model\ArticleModel;
use \NetBricks\Facade as _;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 09.12.11
 * @time: 11:24
 */
class ArticleReader
{
    public function all()
    {
        return ArticleModel::findAll('list_order', 'asc');
    }

    public function get()
    {
        return ArticleModel::find(_::request()->id->getString());
    }
}
