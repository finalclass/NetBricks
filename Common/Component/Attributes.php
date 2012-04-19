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
<<<<<<< Updated upstream
=======
 */
namespace NetBricks\Common\Component;
/**
>>>>>>> Stashed changes
 * @author: Sel <s@finalclass.net>
 * @date: 27.03.12
 * @time: 22:25
 */
class Attributes
{
<<<<<<< Updated upstream
=======
	protected $options = array(
		'style' => array(),
		'class' => array()
	);

	private function renderCss()
	{
		$out = array();
		foreach ($this->options['style'] as $key => $val) {
			$out[] = $key . ':' . $val . ';';
		}
		return join(PHP_EOL, $out);
	}

	/**
	 * @param null $propertyName
	 * @param null $value
	 * @return Attributes|string
	 */
	public function css($propertyName = null, $value = null)
	{
		if (!$propertyName && !$value) {
			return $this->renderCss();
		}
		if ($value) {
			$this->options['style'][$propertyName] = $value;
			return $this;
		}
		return (string)@$this->options['style'][$propertyName];
	}

	public function id($value = null)
	{
		if ($value) {
			return (string)@$this->options['id'];
		}
		$this->options['id'] = $value;
		return $this;
	}

	public function classes($classes = array())
	{
		if(empty($classes)) {
			return $this->options['class'];
		}

		if(is_string($classes)) {
			$classes = array_filter(explode(' ', $classes));
		}

		foreach($classes as $class) {
			$this->options['class'][$class] = $class;
		}

		return $this;
	}

	private function renderProperties($properties)
	{
		$out = array();
		foreach($properties as $name) {
			$value = (string)@$this->options[$name];
			if($value) {
				$out[] = $name . '="' . $value . '"';
			}
		}
		return join(' ', $out);
	}

	public function __toString()
	{
		$out = array();

		if(!empty($this->options['class'])) {
			$out[] = 'class="' . join(' ', array_keys($this->options['class'])) . '"';
		}

		if(!empty($this->options['style'])) {
			$out[] = 'style="' . $this->css() . '"';
		}

		$out[] = $this->renderProperties(array('id'));

		return join(' ', $out);
	}
>>>>>>> Stashed changes

}
