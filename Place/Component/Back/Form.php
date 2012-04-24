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
namespace NetBricks\Place\Component\Back;
use \NetBricks\Common\Component\Form\Form as BaseForm;
use \NetBricks\Common\Component\Form\TextInput;
use \NetBricks\Common\Component\Form\Hidden;
use \NetBricks\Common\Component\Form\TextArea;
use \NetBricks\Common\Component\Form\Submit;
use \NetBricks\Common\Component\Form\NicEditor;
use \NetBricks\Common\Component\Form\Address;
use \NetBricks\Facade as _;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 23.04.12
 * @time: 16:54
 *
 * @property \NetBricks\Common\Component\Form\Hidden $id;
 * @property \NetBricks\Common\Component\Form\Hidden $rev;
 * @property \NetBricks\Common\Component\Form\TextInput $name
 * @property \NetBricks\Common\Component\Form\Address $address
 * @property \NetBricks\Common\Component\Form\NicEditor $information
 * @property \NetBricks\Common\Component\Form\NicEditor $description
 * @property \NetBricks\Common\Component\Form\Submit $submit
 */
class Form extends BaseForm
{

    public function __construct($options = array())
    {
        $this->id = Hidden::factory()->setName('_id');
        $this->rev = Hidden::factory()->setName('_rev');
        $this->name = TextInput::factory()->setName('name');
        $this->address = Address::factory()->setName('address');
        $this->information = NicEditor::factory()->setName('information');
        $this->description = NicEditor::factory()->setName('description');
        $this->submit = Submit::factory()->setName('form')->setValue('place');
        parent::__construct($options);
    }

    public function init()
    {
        if (_::request()->isPost()) {

            if (_::request()->_id->exists() && _::request()->_rev->exists()) {
                $out = $this->getService()->put(_::request()->post->getArray())->toArray();

            } else {
                $out = $this->getService()->post(_::request()->post->getArray())->toArray();
            }
            if (empty($out['errors'])) {
                _::url()->addCurrentParams()->addParam('nb_back_place', 'list')->redirect();
            }
            $this->setValues($out->toArray());
        } else if (_::request()->get->id->exists()) {
            $this->setValues($this->getService()->get(_::request()->get->getArray())->toArray());
        }
    }

    public function getService()
    {
        return new \NetBricks\Place\Service\PlaceService();
    }

    public function render()
    {
        ?>
    <form action="" method="post">
        <?php echo $this->id; ?>
        <?php echo $this->rev; ?>

        <dl>
            <dt><label for="place_name">Name</label></dt>
            <dd>
                <?php echo $this->name->setId('place_name'); ?>
            </dd>

            <dt><label for="">Address</label></dt>
            <dd>
                <?php echo $this->address; ?>
            </dd>

            <dt><label for="place_information">Information</label></dt>
            <dd>
                <?php echo $this->information; ?>
            </dd>

            <dt><label for="place_description">Description</label></dt>
            <dd>
                <?php echo $this->description; ?>
            </dd>

            <?php echo $this->submit->setLabel('Save'); ?>

        </dl>

    </form>
    <?php
    }

}
