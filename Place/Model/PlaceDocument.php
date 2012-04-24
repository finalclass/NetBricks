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
namespace NetBricks\Place\Model;

use \NetCore\CouchDB\Document;
use \NetCore\Utils\ArrayUtils\Address;
use \NetCore\Utils\ArrayUtils\ArrayCollection;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 23.04.12
 * @time: 14:28
 */
class PlaceDocument extends Document
{

    protected $data = array(
        'name' => '',
        'address' => array(),
        'telephone' => '',
        'information' => '',
        'description' => '',
        'photos' => array(),
    );

    /** @var \NetCore\Utils\ArrayUtils\Address */
    private $address;

    /** @var \NetCore\Utils\ArrayUtils\ArrayCollection */
    private $photos;

    /**
     * @param string $value
     * @return \NetBricks\Place\Model\PlaceDocument
     */
    public function setName($value)
    {
        $this->data['name'] = (string)$value;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return (string)@$this->data['name'];
    }

    /**
     * @param array $value
     * @return \NetBricks\Place\Model\PlaceDocument
     */
    public function setAddress($value)
    {
        $this->data['address'] = (array)$value;
        return $this;
    }

    /**
     * @return array
     */
    public function getAddress()
    {
        if(!$this->address) {
            $this->address = new Address($this->data['address']);
        }
        return $this->address;
    }

    /**
     * @param string $value
     * @return \NetBricks\Place\Model\PlaceDocument
     */
    public function setTelephone($value)
    {
        $this->data['telephone'] = (string)$value;
        return $this;
    }

    /**
     * @return string
     */
    public function getTelephone()
    {
        return (string)@$this->data['telephone'];
    }

    /**
     * @param string $value
     * @return \NetBricks\Place\Model\PlaceDocument
     */
    public function setInformation($value)
    {
        $this->data['information'] = (string)$value;
        return $this;
    }

    /**
     * @return string
     */
    public function getInformation()
    {
        return (string)@$this->data['information'];
    }

    /**
     * @param string $value
     * @return \NetBricks\Place\Model\PlaceDocument
     */
    public function setDescription($value)
    {
        $this->data['description'] = (string)$value;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return (string)@$this->data['description'];
    }

    /**
     * @param array $value
     * @return \NetBricks\Place\Model\PlaceDocument
     */
    public function setPhotos($value)
    {
        $this->data['photos'] = (array)$value;
        return $this;
    }

    /**
     * @return \NetCore\Utils\ArrayUtils\ArrayCollection
     */
    public function getPhotos()
    {
        if(!$this->photos) {
            $this->photos = new ArrayCollection($this->data['photos']);
        }
        return (array)@$this->data['photos'];
    }

}
