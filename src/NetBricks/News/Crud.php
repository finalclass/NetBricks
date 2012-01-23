<?php

namespace NetBricks\News;
use \NetBricks\News\Model\NewsModel;

/**
 * Author: Sel <s@finalclass.net>
 * Date: 01.12.11
 * Time: 18:52
 */
class Crud
{

    public function get()
    {
        return NewsModel::findAll();
    }

    public function post()
    {

    }

    public function put()
    {

    }

    public function delete()
    {

    }

}
