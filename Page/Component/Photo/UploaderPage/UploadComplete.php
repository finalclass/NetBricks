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
namespace NetBricks\Page\Component\Photo\UploaderPage;
use \NetBricks\Common\Component\ComponentAbstract;
use \NetBricks\Facade as _;
/**
 * @author: Sel <s@finalclass.net>
 * @date: 24.04.12
 * @time: 13:57
 */
class UploadComplete extends ComponentAbstract
{

    public function __construct($options = array())
    {
        parent::__construct($options);
        _::cfg()->getHeader()->getScripts()->addJQuery();
    }

    public function render()
    {
        $id = _::request()->new_photo_id->getString();
        ?>
    <div class="nb_page_photo_upload_complete" >
        Upload complete. New photo id: <?php echo  $id?>


        <div id="nb_page_photo_id" style="display:none"><?php echo $id; ?></div>

    </div>

    <script type="text/javascript">
        console.log('abc');
        $('body')
                .trigger('select_photo', '<?php echo _::request()->new_photo_id; ?>');
    </script>
        <?php
    }

}
