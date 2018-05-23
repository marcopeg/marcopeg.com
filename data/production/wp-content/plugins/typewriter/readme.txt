=== Typewriter ===
Contributors: dev7studios
Tags: typewriter, markdown, editor, posts, pages, tinymce
Requires at least: 3.5
Tested up to: 3.6.1
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Typewriter replaces the Visual Editor with a simple Markdown editor for your posts and pages.

== Description ==

Typewriter completely removes the "Visual Editor" feature in WordPress and replaces it
with a simple Markdown editor so that you can join sites like StackOverflow and Github in writing in the 
simple and growingly popular <a href="http://daringfireball.net/projects/markdown" target="_blank">Markdown format</a>.

For the more technical among you, Typewriter removes the TinyMCE editor and defaults to a Markdown specific "Text" editor
and parses the output using MarkdownExtra.

== Installation ==

Simple Install

1. Login to WordPress and go to Plugins > Add New > Upload
2. Upload typewriter.zip and activate
3. Write using Markdown!

Manual Install

1. Upload the typewriter folder to your /wp-content/plugins/ directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Write using Markdown!

== Frequently Asked Questions ==

= What is Markdown? =

<a href="http://whatismarkdown.com" target="_blank">whatismarkdown.com</a>

= Do I have to convert my HTML content? =

No. You can still use normal HTML in your posts and pages. Markdown will simply ignore the HTML and only parse
any Markdown specific code that it finds.

= What happens to my content if I deactivate the plugin? =

Unfortunaetly your content will not be parsed by MarkdownExtra anymore and will appear like it does in the text
editor. In this case you would need to convert your Markdown content to normal HTML.

== Screenshots ==

1. Markdown editor with some example content
2. Markdown output with some example content

== Changelog ==

**1.0 (2013.09.25)**

 * Initial release
