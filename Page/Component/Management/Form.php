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

namespace NetBricks\Page\Component\Management;

use \NetBricks\Common\Component\Form\Form as CoreForm;
use \NetBricks\Facade as _;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 24.02.12
 * @time: 10:11
 *
 * @property \NetBricks\Common\Component\Form\MultiLang\TextInput $title
 * @property \NetBricks\Common\Component\Form\MultiLang\TextArea $brief
 * @property \NetBricks\Common\Component\Form\CheckBox $robotsIndex
 * @property \NetBricks\Common\Component\Form\CheckBox $robotsFollow
 * @property \NetBricks\Common\Component\Form\MultiLang\TextInput $metaTitle
 * @property \NetBricks\Common\Component\Form\MultiLang\TextInput $metaKeywords
 * @property \NetBricks\Common\Component\Form\MultiLang\TextArea $metaDescription
 * @property \NetBricks\Common\Component\Form\Submit $submit
 */
class Form extends CoreForm
{

    public function __construct($options = array())
    {
        $textInputNS = '\NetBricks\Common\Component\Form\MultiLang\TextInput';
        $textAreaNS = '\NetBricks\Common\Component\Form\MultiLang\TextArea';
        $submitNS = '\NetBricks\Common\Component\Form\Submit';
        $checkBoxNS = '\NetBricks\Common\Component\Form\CheckBox';

        $this->title = _::loader($textInputNS)->create()->setName('title_translations');
        $this->brief = _::loader($textAreaNS)->create()->setName('brief_translations');
        $this->robotsIndex = _::loader($checkBoxNS)->create()->setName('robots_index');
        $this->robotsFollow = _::loader($checkBoxNS)->create()->setName('robots_follow');
        $this->metaTitle = _::loader($textInputNS)->create()->setName('meta_title_translations');
        $this->metaKeywords = _::loader($textInputNS)->create()->setName('meta_keywords_translations');
        $this->metaDescription = _::loader($textAreaNS)->create()->setName('meta_description_translations');
        $this->submit = _::loader($submitNS)->create()->setName('form')->setValue('page_management');

        parent::__construct($options);
    }

    private function getService()
    {
        return new \NetBricks\Page\Service\Page();
    }

    public function init()
    {
        if(_::request()->isPost() && _::request()->post->form == 'page_management') {
            $data = $this->getService()->post();
            if($data->hasErrors()) {
                $this->setValues($data);
            } else {
                _::url()->addParam('action', 'list')->redirect();
            }
        } else if(_::request()->id->exists()){
            $this->setValues($this->getService()->get());
        }
    }


    public function render()
    {
?>
<form <?php echo $this->renderTagAttributes($this->defaultAttributes); ?>>
    
    <p>
        <label for="page_title">Title</label>
        <?php echo $this->title->setId('page_title'); ?>
    </p>

    <p>
        <label for="page_brief">Brief</label>
        <?php echo $this->brief->setId('page_brief'); ?>
    </p>

    <p>
        <label for="page_robots_index">Index by robots</label>
        <?php echo $this->robotsIndex->setId('page_robots_index'); ?>
    </p>

    <p>
        <label for="page_robots_follow">Robots follow links?</label>
        <?php echo $this->robotsFollow->setId('page_robots_follow'); ?>
    </p>

    <p>
        <label for="page_meta_title">Meta title</label>
        <?php echo $this->metaTitle->setId('page_meta_title'); ?>
    </p>

    <p>
        <label for="page_meta_keywords">Meta keywords</label>
        <?php echo $this->metaKeywords->setId('page_meta_keywords'); ?>
    </p>

    <p>
        <label for="page_meta_description">Meta description</label>
        <?php echo $this->metaDescription->setId('page_meta_description'); ?>
    </p>

    <?php echo $this->submit->setLabel('Save'); ?>

</form>
<?php
    }

}
