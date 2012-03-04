<?php

namespace NetBricks\Article\Component;

use \NetBricks\Facade as _;
use \NetBricks\Article\Model\ArticleModel;
use \NetBricks\Common\Component\ComponentAbstract;
use \NetBricks\Common\Component\Form\TextInput;
use \NetBricks\Common\Component\Form\Submit;
use \NetBricks\Common\Component\Form\TextArea;
use \NetBricks\Common\Component\Container;
use \NetBricks\Common\Component\Form\Form;

/**
 * ArticleForm
 *
 * Author: MMP
 */
class ArticleForm extends Form {

    public $name, $metaDescription, $metaKeywords, $category, $listOrder, $body, $submit;

    /**
     *
     * @var \NetBricks\Common\Component\UnorderedList
     */
    public $errors = '';
    public $id;

    public function __construct() {

        parent::__construct();

        $this->id = \NetBricks\Common\Component\Form\Hidden::factory()->setName('id');
        $this->name = new TextInput;
        $this->metaDescription = new TextInput;
        $this->metaKeywords = new TextInput;
        $this->category = new TextInput;
        $this->listOrder = new TextInput;
        $this->body = new TextArea;
        $this->body->setClass('wysiwyg');
        $this->submit = new Submit;

        $this->name->setName('title');
        $this->metaDescription->setName('meta_description');
        $this->metaKeywords->setName('meta_keywords');
        $this->category->setName('category');
        $this->listOrder->setName('list_order');
        $this->body->setName('content');

        $this->addChild($this->id)
                ->addChild($this->name)
                ->addChild($this->metaDescription)
                ->addChild($this->metaKeywords)
                ->addChild($this->category)
                ->addChild($this->listOrder)
                ->addChild($this->body)
                ->addChild($this->submit);

        if (_::request()->isPost()) {
            //if save
            if ($this->isValid()) {
                $obj = $this->assigningValuesFromPOST();
                $obj->save();
                header('Location: /admin/articles/list');
            }
        } else if (_::request()->article_id->exists()) {
            //if edit
            $articleId = (string) _::request()->article_id;
            $article = ArticleModel::find($articleId);
            if ($article !== null) {
                $this->setValues($article->toArray());
            }
        }
        //if add
    }

    public function isValid() {
        $this->setValues(_::request()->post->getValue());
        $post = _::request()->post;
        if (strlen($post->title->getString()) > 0) {
            return true;
        }

        $this->errors = new \NetBricks\Common\Component\UnorderedList();
        $this->errors->addChild(
                \NetBricks\Common\Component\Tag::factory('span')->setContent('Fill in TITLE field')
        );

        $this->addChild($this->errors);
        return false;
    }

    public function render() {
        ?>
        <?php echo $this->errors; ?>
        <form method="post" action="">
            
            <dl>
                <dt><label for="article_name">Nazwa</label></dt>
                <dd><?php echo $this->name->setId('article_name'); ?></dd>
            </dl>
            <dl>
                <dt><label for="article_meta_description">Meta description</label></dt>
                <dd><?php echo $this->metaDescription->setId('article_meta_description'); ?></dd>
            </dl>
            <dl>
                <dt><label for="article_meta_keywords">Meta keywords</label></dt>
                <dd><?php echo $this->metaKeywords->setId('article_meta_keywords'); ?></dd>
            </dl>
            <dl>
                <dt><label for="article_category">Kategoria</label></dt>
                <dd><?php echo $this->category->setId('article_category'); ?></dd>
            </dl>
            <dl>
                <dt><label for="article_list_order">Kolejność</label></dt>
                <dd><?php echo $this->listOrder->setId('article_list_order'); ?></dd>
            </dl>
            <dl>
                <dt><label for="article_body">Treść</label></dt>
                <dd><?php echo $this->body->setId('article_body'); ?></dd>
            </dl>
            <?php echo $this->id; ?>
            <?php echo $this->submit->setLabel('Zapisz'); ?>
        </form>
        <?php
    }

    private function assigningValuesFromPOST() {

        $this->setValues(_::request()->post->getValue());
        $id = _::request()->post->id;

        if ($id->exists()) {
            $article = ArticleModel::find($id->getString());
        } else {
            $article = new ArticleModel;
        }
        $post = _::request()->post;
        $article->setMetaDescription($post->meta_description->getString());
        $article->setMetaKeywords($post->meta_keywords->getString());
        $article->setCategory($post->category->getString());
        $article->setListOrder($post->list_order->getInt());
        $article->setTitle($post->title->getString());
        $article->setContent($post->content->getString());
        return $article;
    }

}