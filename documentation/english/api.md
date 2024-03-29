API for developers
==================
###[Yellow 0.3.19](https://github.com/markseu/yellowcms)

$yellow
-------
**[$yellow->page](api.md#yellow-page)** is the current page  
**[$yellow->pages](api.md#yellow-pages)** gives access to pages from file system  
**[$yellow->config](api.md#yellow-config)** gives access to configuration  
**[$yellow->text](api.md#yellow-text)** gives access to text strings  
**[$yellow->toolbox](api.md#yellow-toolbox)** gives access to toolbox with helpers  
**[$yellow->plugins](api.md#yellow-plugins)** gives access to plugins

$yellow->page
-------------
**$yellow->page->get($key)**  
Return page [meta data](api.md#page-meta-data)  

**$yellow->page->getHtml($key)**  
Return page [meta data](api.md#page-meta-data), HTML encoded  

**$yellow->page->getContent($rawFormat = false)**  
Return page content, HTML encoded or raw format

**$yellow->page->getHeaderExtra()**  
Return page extra header, HTML encoded

**$yellow->page->getParent()**  
Return parent page relative to current page

**$yellow->page->getParentTop($homeFailback = false)**  
Return top-level parent page of current page

**$yellow->page->getSiblings($showInvisible = false)**  
Return pages on the same level as current page

**$yellow->page->getChildren($showInvisible = false)**  
Return child pages relative to current page

**$yellow->page->getLocation()**  
Return absolute page location

**$yellow->page->getUrl()**  
Return page URL, with server scheme and server name

**$yellow->page->getModified($httpFormat = false)**  
Return page modification time, Unix time

**$yellow->page->getStatusCode($httpFormat = false)**  
Return page status code

**$yellow->page->error($statusCode, $pageError = "")**  
Respond with error page

**$yellow->page->clean($statusCode, $responseHeader = "")**  
Respond with status code, no page content

**$yellow->page->header($responseHeader)**  
Add page response header, HTTP format

**$yellow->page->isExisting($key)**  
Check if page [meta data](api.md#page-meta-data) exists  

**$yellow->page->isError()**  
Check if page with error

**$yellow->page->isActive()**  
Check if page is within current HTTP request

**$yellow->page->isVisible()**  
Check if page is visible in navigation

**$yellow->page->isCacheable()**  
Check if page is cacheable

Example: [content.php](https://github.com/markseu/yellowcms/blob/master/system/snippets/content.php), [header.php](https://github.com/markseu/yellowcms/blob/master/system/snippets/header.php)

$yellow->pages
--------------
**$yellow->pages->find($location, $absoluteLocation = false)**  
Return one page from file system

**$yellow->pages->index($showInvisible = false, $levelMax = 0)**  
Return page collection with all pages from file system

**$yellow->pages->top($showInvisible = false)**  
Return page collection with top-level navigation

**$yellow->pages->path($location, $absoluteLocation = false)**  
Return page collection with path ancestry

**$yellow->pages->create()**  
Return empty page collection

The following works for any page collection, e.g functions that return more than one page:

**$pages->filter($key, $value, $exactMatch = true)**  
Filter page collection by [meta data](api.md#page-meta-data)  

**$pages->sort($key, $ascendingOrder = true)**  
Sort page collection by [meta data](api.md#page-meta-data)  

**$pages->merge($input)**  
Merge page collection

**$pages->append($page)**  
Append to end of page collection

**$pages->prepend($page)**  
Prepend to start of page collection

**$pages->limit($pagesMax)**  
Limit the number of pages in page collection

**$pages->reverse()**  
Reverse page collection

**$pages->pagination($limit, $reverse = true)**  
Paginate page collection

**$pages->getPaginationPage()**  
Return current page number in pagination

**$pages->getPaginationCount()**  
Return highest page number in pagination

**$pages->getLocationPage($pageNumber)**  
Return absolute location for a page in pagination

**$pages->getLocationPrevious()**  
Return absolute location for previous page in pagination

**$pages->getLocationNext()**  
Return absolute location for next page in pagination

**$pages->getFilter()**  
Return current page filter

**$pages->getModified($httpFormat = false)**  
Return last modification time for page collection, Unix time

**$pages->first()**  
Return first page in page collection

**$pages->last()**  
Return last page in page collection

**$pages->isPagination()**  
Check if there is an active pagination

Example: [navigation.php](https://github.com/markseu/yellowcms/blob/master/system/snippets/navigation.php),
[sitemap.php](https://github.com/markseu/yellowcms-extensions/blob/master/templates/sitemap/sitemap.php)

$yellow->config
---------------
**$yellow->config->get($key)**  
Return configuration

**$yellow->config->getHtml($key)**  
Return configuration, HTML encoded

**$yellow->config->getData($filterStart = "", $filterEnd = "")**
Return configuration strings

**$yellow->config->getModified($httpFormat = false)**  
Return configuration modification time, Unix time

**$yellow->config->isExisting($key)**  
Check if configuration exists

$yellow->text
-------------
**$yellow->text->get($key)**  
Return text string

**$yellow->text->getHtml($key)**  
Return text string, HTML encoded

**$yellow->text->getData($filterStart = "", $language = "")**  
Return text strings

**$yellow->text->getModified($httpFormat = false)**  
Return text modification time, Unix time

**$yellow->text->isExisting($key)**  
Check if text string exists

$yellow->toolbox
---------------
**$yellow->toolbox->normaliseLocation($location, $pageBase, $pageLocation, $filterStrict = true)**  
Normalise location, make absolute location

**$yellow->toolbox->normaliseArgs($text, $appendSlash = true, $filterStrict = true)**  
Normalise location arguments

**$yellow->toolbox->normaliseName($text, $removePrefix = true, $removeExtension = false, $filterStrict = false)**  
Normalise file/directory/attribute name

**$yellow->toolbox->getHttpStatusFormatted($statusCode)**  
Return human readable HTTP server status

**$yellow->toolbox->getHttpTimeFormatted($timestamp)**  
Return human readable HTTP time

**$yellow->toolbox->getTextArgs($text, $optional = "-")**  
Return arguments from text string

**$yellow->toolbox->createTextDescription($text, $lengthMax, $removeHtml = true, $endMarker = "", $endMarkerText = "")**  
Create description from text string

**$yellow->toolbox->createTextKeywords($text, $keywordsMax)**  
Create keywords from text string

**$yellow->toolbox->createHash($text, $algorithm, $cost = 0)**  
Create hash with random salt, bcrypt or sha256

**$yellow->toolbox->verifyHash($text, $algorithm, $hash)**  
Verify that text matches hash

**$yellow->toolbox->detectImageInfo($fileName)**  
Detect image dimensions and type, png or jpg

**$yellow->toolbox->isLocationArgs()**  
Check if location contains location arguments  

**$yellow->toolbox->isFileLocation($location)**  
Check if location is specifying file or directory

**$yellow->toolbox->isValidLocation($location)**  
Check if location is valid

$yellow->plugins
----------------
**$yellow->plugins->register($name, $class, $version)**  
Register plugin

**$yellow->plugins->isExisting($name)**  
Check if plugin exists

The following are overrides that plugins can handle:

**function onLoad($yellow)**  
Handle plugin initialisation

**function onRequest($serverScheme, $serverName, $base, $location, $fileName)**  
Handle request

**function onParseMeta($page, $text)**  
Handle page meta data parsing

**function onParseContentText($page, $text)**  
Handle page content parsing of raw format

**function onParseContent($page, $text)**  
Handle page content parsing

**function onParseType($page, $name, $text, $typeShortcut)**  
Handle page custom type parsing

**function onHeaderExtra($page)**  
Handle page extra header

**function onUserPermission($location, $fileName, $users)**  
Handle permission to modify page

**function onMergeText($location, $textSource, $textLocal, $textRemote)**  
Handle text merging

**function onCommandHelp()**  
Handle command help

**function onCommand($args)**  
Handle command

Example: [youtube.php](https://github.com/markseu/yellowcms-extensions/blob/master/plugins/youtube/youtube.php),
[draft.php](https://github.com/markseu/yellowcms-extensions/blob/master/plugins/draft/draft.php)

Command line interface
----------------------
**php yellow.php**  
Show available commands

**php yellow.php build DIRECTORY [LOCATION]**  
Build static pages

**php yellow.php clean DIRECTORY [LOCATION]**  
Clean static pages

**php yellow.php user EMAIL PASSWORD [NAME LANGUAGE HOME]**  
Create or update user account

**php yellow.php version**  
Show software version

Example:  
`php yellow.php build latest`  
`php yellow.php clean latest`  
`php yellow.php user email@example.com horsebatterystaple`  
`php yellow.php version`  

Page meta data
--------------
`title` = page title  
`titleContent` = page title shown in content  
`titleNavigation` = page title shown in navigation  
`titleHeader` = page title used in header  
`description` = page description used in header  
`keywords` = page keyword(s) used in header, comma separated  
`author` = page author(s), comma separated  
`language` = page language  
`style` = page style  
`template` = page template  
`parser` = page parser  
`modified` = page modification time, YYYY-MM-DD format  
`published` = page publication date, YYYY-MM-DD format  
`tag` = tag(s) for categorisation, comma separated  
`redirect` = new location or URL  
`status` = status for workflow   
`sitename` = sitename used in header and footer  
`pageRead` = URL for reading page  
`pageEdit` = URL for editing page  
`pageError` = description of page error  

[Next: Tutorials →](README.md#tutorials)