<?php

namespace NetBricks\Article\Model;

use \NetBricks\Common\Component\Tag;
use \NetCore\FileSystem\Model;

/**
 * ArticleModel
 *
 * 
 * @property string $id
 * @property string $title
 * 
 * Author: Misiorus Maximus
 */
class ArticleModel extends Model {

    public function __construct() {
        parent::__construct();
    }
    
    static public function findByCategory($category, $sortBy = 'list_order', $direction = 'asc') {
        
        $articlesArray = static::findAll($sortBy, $direction);
        $articles = array();
        $length=count($articlesArray);
////////wonderful C-style 'for' loop, far better than any PHP's foreach...
////////DO NOT TOUCH IT!
        for ($i=0; $i<$length; $i++) {
            if ($articlesArray[$i]->getCategory() == $category)
                $articles[] = $articlesArray[$i];
        }
        return $articles;
    }
    
    public function getFieldToGenerateId() {

        return 'title';
    }
    
    public function setListOrder($listOrder) {
        $this->data['list_order'] = (string)$listOrder;
        return $this;
    }

    public function getListOrder() {
        return empty($this->data['list_order']) ? 0 : intval($this->data['list_order']);
    }
    
    public function setMetaDescription($metaDescription) {

        $this->data['meta_description'] = (string)$metaDescription;
        return $this;
    }

    public function getMetaDescription() {

        return $this->data['meta_description'];
    }

    public function setContent($content) {

        $this->data['content'] = (string)$content;
        return $this;
    }

    public function getContent() {

        return $this->data['content'];
    }

    public function setMetaKeywords($metaKeywords) {

        $this->data['meta_keywords'] = (string)$metaKeywords;
        return $this;
    }

    public function getMetaKeywords() {

        return $this->data['meta_keywords'];
    }

    public function setTitle($title) {

        $this->data['title'] = (string)$title;
        return $this;
    }

    public function getTitle() {

        return $this->data['title'];
    }
    
    public function setCategory($category) {
        $this->data['category'] = (string)$category;
        return $this;
    }

    public function getCategory() {
        return empty($this->data['category']) ? '' : $this->data['category'];
    }
}