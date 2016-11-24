<?php
/*
Plugin Name: post-gallery-lite
Plugin URI: http://www.marcopeg.com
Description: Minimal photogallery that integrates in your posts and pages.
Version: 0.0.0
Author: MarcoPeg
Author URI: http://www.marcopeg.com
License: MIT

Copyright (c) 2016 MarcoPeg - http://www.marcopeg.com

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"),
the rights to use the software as a wordpress plugin; It is prohibited and therefore
limited the rights to modify, merge, publish, distribute, sublicense, and/or sell copies of the Software,
subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
*/

define('POST_GALLERY_LITE_ROOT', __FILE__);
define('POST_GALLERY_LITE_VERSION', time());

require_once('inc/utils.php');

if (is_admin()) {
    require_once('admin/php/post_actions.php');
    require_once('admin/php/ajax_actions.php');
} else {
    require_once('client/php/client_actions.php');
    require_once('client/php/short_code.php');
}
