Image plugin 0.1.7
==================
Resizable images and thumbnails.

How do I install this?
----------------------
1. Download and install [Yellow](https://github.com/markseu/yellowcms/).  
2. Download [image.php](image.php?raw=true), copy into your system/plugins folder.
3. Create a new folder 'thumbnails' in your media folder. Make sure it's writable.

To uninstall delete plugin and thumbnails folder.

How to add an image?
--------------------
Create a shortcut in the format `[image NAME]`, you can add optional text, style, width, height, mode.  
NAME is the file name in your images folder. The available resize modes are fit and cut, default is fit.

The plugin requires [GD graphics library](http://www.libgd.org/) by Thomas Boutell, for resizing JPEG and PNG images.

Example
-------
Adding an image, default and optional text:

    [image icon.png]
    [image icon.png Image]
    [image icon.png "This is an example image"]

Adding an image, different styles:

    [image picture.jpg Picture left]
    [image picture.jpg Picture centre]
    [image picture.jpg Picture right]

Adding an image, different sizes:

    [image picture.jpg Picture - 64 64]
    [image picture.jpg Picture - 320 200]
    [image picture.jpg Picture - 50%]