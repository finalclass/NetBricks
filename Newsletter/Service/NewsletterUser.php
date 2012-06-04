<?php
/**
 * Created by JetBrains PhpStorm.
 * User: sel
 * Date: 04.06.12
 * Time: 09:56
 * To change this template use File | Settings | File Templates.
 */

namespace NetBricks\Newsletter\Service;

use \NetBricks\Facade as _;

class NewsletterUser
{

    /**
     * @return \NetBricks\Newsletter\Document\Repository
     */
    public function getRepo()
    {
        return new \NetBricks\Newsletter\Document\Repository();
    }

    public function get($params = array())
    {
        if(!isset($params['id'])) {
            return $this->getRepo()->all();
        }
        return $this->getRepo()->find($params['id']);
    }

    public function delete($params = array())
    {
        $repo = $this->getRepo();

        $doc = $repo->find(@$params['id']);

        if(!$doc) {
            return array('error' => 'document not found');
        }

        return $repo->remove($doc);
    }

}
