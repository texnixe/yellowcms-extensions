Disqus snippet
==============
Add [Disqus](http://disqus.com) comments to website or blog.

How do I install this?
----------------------
1. Download and install [Yellow](https://github.com/markseu/yellowcms/).  
2. Download [disqus.php](disqus.php?raw=true), copy into your system/snippets folder.  
3. Use the snippet on your website, edit templates in your system/templates folder.

To uninstall delete the snippet and remove it from templates.

How to enable comments?
------------------------
Create a Disqus account, add Disqus snippet to template: `$yellow->snippet("disqus", SHORTNAME)`.  
SHORTNAME is the name of your website, you can find it in the Disqus dashboard.

Example
-------
Website template with comments:

    <?php $yellow->snippet("header") ?>
    <?php $yellow->snippet("sitename") ?>
    <?php $yellow->snippet("navigation") ?>
    <div class="content">
    <h1><?php echo $yellow->page->getHtml("title") ?></h1>
    <?php echo $yellow->page->getContent() ?>
    <?php $yellow->snippet("disqus", "annasdesign") ?>
    </div>
    <?php $yellow->snippet("footer") ?>

Blog article template with comments:

    <?php $yellow->snippet("header") ?>
    <?php $yellow->snippet("sitename") ?>
    <?php $yellow->snippet("navigation") ?>
    <div class="content blogarticle">
    <div class="article">Blog content</div>
    <?php $yellow->snippet("disqus", "annasblog") ?>
    </div>
    <?php $yellow->snippet("footer") ?>