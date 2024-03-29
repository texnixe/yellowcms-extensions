Adding media
============
All media is located in the **media folder**. You can store your images and other files there.

![Screenshot](media-screenshot.png?raw=true)

The standard installation of Yellow comes with two media folders. The `images` folder is the place to store your images. For a small website put all images inside one folder, otherwise use multiple folders. The `styles` folder is the place for your styles, there's a `default.css` that defines how your website looks like. It's a starting point for your own designs.

Create additional folders and organise media files as you like.

Image files
-----------
Here's how to use images, photos and graphics. Open the file `content/1-home/page.txt` in your favorite text editor. Add `![image](icon.png)` to the text of the page. The home page shows now the default website icon. 

`![image](icon.png)` shows the image `http://website/images/icon.png`  
`![image](picture.jpg)` shows the image `http://website/images/picture.jpg`  

To use more images, add more files to your images folder.

Image resize
------------
Yellow has no built-in image resize, but there's the [Image plugin](https://github.com/markseu/yellowcms-extensions/tree/master/plugins/image) for resizable images and thumbnails.

`[image icon.png]` shows the image `http://website/images/icon.png`  
`[image picture.jpg]` shows the image `http://website/images/picture.jpg`  

Different styles:

    [image picture.jpg Picture left]
    [image picture.jpg Picture right]

Different sizes:

    [image picture.jpg Picture - 320 200]
    [image picture.jpg Picture - 50%]

You can use images in any size.

Videos
------
There's no built-in video player, but you can use the [Youtube](https://github.com/markseu/yellowcms-extensions/tree/master/plugins/youtube) and [Vimeo plugin](https://github.com/markseu/yellowcms-extensions/tree/master/plugins/vimeo).

`[youtube fhs55HEl-Gc]` shows the video `http://www.youtube.com/watch?v=fhs55HEl-Gc`  
`[vimeo 13387502]` shows the video `http://vimeo.com/13387502`  

Embed Youtube video:

    [youtube fhs55HEl-Gc]
    [youtube fhs55HEl-Gc right 200 112]

Embed Vimeo video:

    [vimeo 13387502]
    [vimeo 13387502 right 200 112]

There are more [plugins](https://github.com/markseu/yellowcms-extensions/tree/master/plugins) you can download.

Styles
------
You can customize your website with [CSS](http://en.wikipedia.org/wiki/CSS). There's a default style for the entire website. A different style can be defined in the settings of a page, for example `Style: blog` uses the file `media/styles/blog.css`. Otherwise, the default style or the name of the folder is used. There are [styles](https://github.com/markseu/yellowcms-extensions/tree/master/styles) you can download.

[Next: System configuration →](system.md)