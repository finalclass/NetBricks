<?php
/**

Copyright (C) Szymon Wygnanski (s@finalclass.net)

Permission is hereby granted, free of charge, to any person obtaining a copy of
this software and associated documentation files (the "Software"), to deal in
the Software without restriction, including without limitation the rights to
use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies
of the Software, and to permit persons to whom the Software is furnished to do
so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
 */

namespace NetBricks\Common\Document;

use \NetBricks\Facade as _;
use \NetCore\CouchDB\Exception\InvalidDocumentType;
use \NetCore\CouchDB\Exception\ViewNotFound;
use \NetCore\CouchDB\Document;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 02.03.12
 * @time: 00:30
 */
class Repository
{

    public $designDocumentId = '_design/common';
    public $viewName = 'all';
    public $documentClassName = '\NetCore\CouhcDB\Document';

    /**
     * @param $id
     * @return \NetCore\CouchDB\Document
     */
    public function find($id)
    {
        $response = _::couchdb()->get($id);
        if (@$response['error'] == 'not_found') {
            return null;
        }
        return $this->createDocument($response);
    }

    public function findByKeys($keys)
    {
        if(empty($keys)) {
            return array();
        }
        $response = _::couchdb()->findByKeys($keys);

        if (@$response['error'] == 'not_found') {
            return null;
        }

        $documents = array();
        foreach($response['rows'] as $row) {
            $documents[] = $this->createDocument(@(array)$row['doc']);
        }
        return $documents;
    }

    /**
     * @param string $viewName
     * @param string $startKey
     * @param string $endKey
     * @param null $limit
     * @param bool $descending
     * @throws \NetCore\CouchDB\Exception\ViewNotFound
     * @internal param array $params
     * @return \NetCore\CouchDB\Document[]
     */
    public function all($viewName = null, $startKey = null, $endKey = null, $limit = null, $descending = false)
    {
        $params = array();
        if ($startKey) {
            $params[] = 'startkey=' . $startKey . '';
        }
        if ($endKey) {
            $params[] = 'endkey=' . $endKey . '';
        }
        if ($limit) {
            $params[] = 'limit=' . $limit;
        }
        if ($descending) {
            $params[] = 'descending=true';
        }
        $urlParams = '';
        if (!empty($params)) {
            $urlParams = '?' . join('&', $params);
        }
        $viewName = $viewName ? $viewName : $this->viewName;
        $response = _::couchdb()->get($this->designDocumentId . '/_view/' . $viewName . $urlParams);
        if (@$response['error'] == 'not_found') {
            $exception = new ViewNotFound('view ' . $this->viewName . ' not found');
            $exception->view = $this->viewName;
            throw $exception;
        }

        $documents = array();
        foreach ($response['rows'] as $record) {
            $documents[] = $this->createDocument((array)@$record['value']);
        }

        return $documents;
    }

    /**
     * @param \NetCore\CouchDB\Document|array $document
     * @throws \NetCore\CouchDB\Exception\InvalidDocumentType
     * @return \NetCore\CouchDB\Document
     */
    public function save($document)
    {
        if (is_array($document)) {
            //to make sure the document has all necessery fields set
            //set all unset fields by creating the document
            $document = $this->createDocument($document);
        }
        if (!is_a($document, $this->documentClassName)) {
            throw new InvalidDocumentType('document ' . get_class($document) . ' shoulb be of type : '
                    . $this->documentClassName);
        }
        $array = _::couchdb()->save($document->toArray());
        $document->fromArray($array);
        return $document;
    }

    public function remove($document)
    {
        $id = \NetCore\Renderer::renderObjectProperty($document, 'id');
        $rev = \NetCore\Renderer::renderObjectProperty($document, 'rev');

        return _::couchdb()->delete($id, $rev);
    }

    public function createDocument(array $array)
    {
        $documentClass = $this->documentClassName;
        $doc = new $documentClass();
        if (!$doc instanceof Document) {
            throw new InvalidDocumentType(
                'document ' . $this->documentClassName
                        . ' is not instance of \NetCore\CouchDB\Document');
        }
        $doc->fromArray($array);
        return $doc;
    }

}
