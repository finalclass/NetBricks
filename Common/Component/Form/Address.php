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
namespace NetBricks\Common\Component\Form;
use \NetBricks\Common\Component\Form\FormElementAbstract;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 24.04.12
 * @time: 09:32
 *
 *
 * @property \NetBricks\Common\Component\Form\TextInput $name
 * @property \NetBricks\Common\Component\Form\TextInput $country
 * @property \NetBricks\Common\Component\Form\TextInput $street
 * @property \NetBricks\Common\Component\Form\TextInput $city
 * @property \NetBricks\Common\Component\Form\TextInput $postcode
 */
class Address extends FormElementAbstract
{

    public function __construct($options = array())
    {
        parent::__construct($options);
        $this->name = new TextInput();
        $this->country = new TextInput();
        $this->street = new TextInput();
        $this->city = new TextInput();
        $this->postcode = new TextInput();
        $this->setName('address');
    }

    public function setName($name)
    {
        parent::setName($name);
        $this->name->setName($name . '[name]')->setId($name . '-name');
        $this->country->setName($name . '[country]')->setId($name . '-country');
        $this->street->setName($name . '[street]')->setId($name . '-street');
        $this->city->setName($name . '[city]')->setId($name . '-city');
        $this->postcode->setName($name . '[postcode]')->setId($name . 'postcode');
        return $this;
    }

    public function setValue($value = array())
    {
        parent::setValue($value);
        if(isset($value['name'])) {
            $this->name->setValue($value['name']);
        }
        if(isset($value['country'])) {
            $this->country->setValue($value['country']);
        }
        if(isset($value['street'])) {
            $this->street->setValue($value['street']);
        }
        if(isset($value['city'])) {
            $this->city->setValue($value['city']);
        }
        if(isset($value['postcode'])) {
            $this->postcode->setValue($value['postcode']);
        }
        return $this;
    }

    public function getValue()
    {
        return array(
            'name' => $this->name->getValue(),
            'country' => $this->country->getValue(),
            'street' => $this->street->getValue(),
            'city' => $this->city->getValue(),
            'postcode' => $this->postcode->getValue()
        );
    }

    public function render()
    {
        ?>
    <dl>
        
        <dt><label for="<?php echo $this->name->getId(); ?>">Name</label></dt>
        <dd><?php echo $this->name; ?></dd>

        <dt><label for="<?php echo $this->country->getId(); ?>">Country</label></dt>
        <dd><?php echo $this->country; ?></dd>

        <dt><label for="<?php echo $this->street->getId(); ?>">Street</label></dt>
        <dd><?php echo $this->street; ?></dd>

        <dt><label for="<?php echo $this->postcode->getId(); ?>">Postcode</label></dt>
        <dd><?php echo $this->postcode; ?></dd>

        <dt><label for="<?php echo $this->city->getId(); ?>">City</label></dt>
        <dd><?php echo $this->city; ?></dd>

    </dl>

        <?php
    }
}
