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
namespace NetBricks\GoogleMap;
use \NetBricks\Common\Component\ComponentAbstract;
use \NetBricks\Facade as _;

/**
 * @author: Sel <s@finalclass.net>
 * @date: 30.04.12
 * @time: 13:44
 */
class SimpleIframe extends ComponentAbstract
{

    /**
     * @static
     * @param array $options
     * @return \NetBricks\GoogleMap\SimpleIframe
     */
    static public function factory($options = array())
    {
        $class = get_called_class();
        return new $class($options);
    }

    /**
     * @param string $value
     * @return \NetBricks\GoogleMap\SimpleIframe
     */
    public function setAddress($value)
    {
        $this->options['address'] = (string)$value;
        return $this;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return (string)@$this->options['address'];
    }

    /**
     * @param int $value
     * @return \NetBricks\GoogleMap\SimpleIframe
     */
    public function setWidth($value)
    {
        $this->options['width'] = (int)$value;
        return $this;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return isset($this->options['width']) ? $this->options['width'] : 400;
    }

    /**
     * @param int $value
     * @return \NetBricks\GoogleMap\SimpleIframe
     */
    public function setHeight($value)
    {
        $this->options['height'] = (int)$value;
        return $this;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return isset($this->options['height']) ? $this->options['height'] : 300;
    }

    /**
     * @param int $value
     * @return \NetBricks\GoogleMap\SimpleIframe
     */
    public function setZoom($value)
    {
        $this->options['zoom'] = (int)$value;
        return $this;
    }

    /**
     * @return int
     */
    public function getZoom()
    {
        return isset($this->options['zoom']) ? $this->options['zoom'] : 16;
    }

    public function render()
    {
        $q = str_replace(' ', '+', $this->getAddress());
        $hl = _::languages()->getCurrent();
        $z = $this->getZoom();
        ?>
    <iframe width="<?php echo $this->getWidth(); ?>"
            height="<?php echo $this->getHeight(); ?>"
            frameborder="0"
            scrolling="no"
            marginheight="0"
            marginwidth="0"
            src="http://maps.google.pl/maps?q=<?php echo $q; ?>&amp;ie=UTF8&amp;z=<?php echo $z; ?>&amp;output=embed&amp;hl=<?php echo $hl; ?>">

    </iframe>
    <br/>
    <small>
        <a href="http://maps.google.pl/maps?f=q&amp;source=embed&amp;hl=pl&amp;geocode=&amp;q=<?php echo $q; ?>&amp;aq=&amp;ie=UTF8&amp;hq=&amp;"
           style="color:#0000FF;text-align:left">
            <?php echo _::translate('nb_google_map_simple_iframe_show_big'); ?>
        </a>
    </small>

    <?php
    }

}
