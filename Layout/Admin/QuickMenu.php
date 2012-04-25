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
namespace NetBricks\Layout\Admin;
use \NetBricks\Common\Component\UnorderedList;
use \NetBricks\Common\Component\Link;
use \NetBricks\Facade as _;
use \NetBricks\User\Component\Login\LogoutButton;
/**
 * @author: Sel <s@finalclass.net>
 * @date: 24.04.12
 * @time: 21:41
 *
 * @property \NetBricks\User\Component\Login\LogoutButton $logout
 * @property \NetBricks\Common\Component\Link $visitWebsite
 */
class QuickMenu extends UnorderedList
{

    public function construct()
    {
        _::cfg()->getHeader()->getStyleSheets()
            ->addNetBricks();

        $this->addClass('nb-hbox nb-box-margin-small');

        $this->visitWebsite = Link::factory()
                ->setHref('/')
                ->setLabel('Visit website')
                ->addClass('visit_website nb-button ui-state-default ui-corner-all')
                ->setContent(function(Link $visitWebsite) { ?>
                    <span class="ui-icon ui-icon-home"></span>
                    <?php echo $visitWebsite->getLabel(); ?>
                <?php });

        $this->logout = LogoutButton::factory()
                ->setLabel('logout')
                ->addClass('logout nb-button ui-state-default ui-corner-all')
                ->setContent(function(LogoutButton $logout) { ?>
                    <span class="ui-icon ui-icon-power"></span>
                    <?php echo $logout->getLabel(); ?>
                <?php });

    }

}
