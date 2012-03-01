<?php

namespace NetBricks\Article\Component;

use \NetBricks\Common\ComponentAbstract;
use \NetBricks\Common\Form\FormElementAbstract;
use \NetBricks\Common\Container;
use \NetBricks\Common\Form\TextInput;
use \NetBricks\Common\Form\Form;
use \NetBricks\Common\Form\Submit;
use \NetBricks\Article\Model\ArticleModel;
use \NetCore\FileSystem\Model;
use \NetBricks\Facade as _;

/**
 * ArticleList
 *
 * Author: MMP
 */
class ArticleList extends Container
{

    protected $array;

    public function __construct()
    {

        $this->array = ArticleModel::findAll();
        parent::__construct();
    }

    public function render()
    {
        ?>

    <table style="width:100%">
        <thead>
        <tr>
            <th>article's name</th>
            <th>operations</th>
        </tr>
        </thead>
        <tbody>
            <?php foreach ($this->array as $article) : ?>
        <tr>
            <td><?php echo $article->getTitle() ?></td>
            <td>
                <ul class="options">
                    <li>
                        <?php echo _::factory()->netBricks->common->link()
                            ->addParam('action', 'form')
                            ->setClass('ui-icon ui-icon-wrench')
                            ->addParam('article_id', $article->getId())
                            ->setLabel('Edit'); ?>
                    </li>
                    <li>
                        <?php echo  _::factory()->netBricks->common->link()
                            ->addParam('action', 'erase')
                            ->setClass('ui-icon ui-icon-trash')
                            ->addParam('article_id', $article->getId())
                            ->setLabel('Erase'); ?>
                    </li>
                </ul>
            </td>
        </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php
    }
}