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

/**
 *
 * Example usage:
 * $('.form_messages').blink(1000).hideAfterDelay(5000);
 *
 */

$.fn.blink = function (delay) {
  delay = delay || 500;
  return $(this).each(function () {
    var element = $(this);
    var interval = setInterval(function () {
      element.fadeOut((delay / 3), function() {
        element.fadeIn(delay / 3);
      })
    }, delay);
    element.data('blinkInterval', interval);
  });
};
$.fn.stopBlinking = function() {
  return $(this).each(function() {
    var element = $(this);
    element.stop(true, true);
    clearInterval(element.data('blinkInterval'));
  });
};

$.fn.hideAfterDelay = function(delay) {
  delay = delay || 10000;
  return $(this).each(function() {
    var element = $(this);
    setTimeout(function() {
      element.stopBlinking().slideUp('slow');
    }, delay);
  });
};