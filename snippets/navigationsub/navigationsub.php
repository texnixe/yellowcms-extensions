<?php list($name, $showDefault) = $yellow->getSnippetArgs() ?>
<?php $pages = $yellow->pages->create() ?>
<?php $page = $yellow->page->getParentTop() ?>
<?php if($page) $pages = $page->getChildren() ?>
<?php if($page && $showDefault) $pages->prepend($page) ?>
<?php if(count($pages)): ?>
<div class="navigation">
<ul>
<?php foreach($pages as $page): ?>
<li><a<?php echo $page->isActive() ? " class=\"active\"" : "" ?> href="<?php echo $page->getLocation() ?>"><?php echo $page->getHtml("titleNavigation") ?></a></li>
<?php endforeach ?>
</ul>
</div>
<?php endif ?>
