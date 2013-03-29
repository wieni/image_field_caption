|=====================|
| Image Field Caption |
|=====================|

  Provides a caption text area for image fields.

|==============|
| Installation |
|==============|

  1. Download the module
  2. Upload module to the sites/all/modules folder
  3. Enable the module
  4. Flush all of Drupal's caches

|=======|
| Usage |
|=======|

  1. Add a new image field to a content type, or use an existing image field
  2. Add or edit a node with an image field
  3. Go to the image field on the node form
  4. Enter text into the caption text area
  5. Save the node
  6. View the node to see your image field caption

|===============|
| Configuration |
|===============|

  Visit: Configuration -> Media -> Image Field Caption
  
  Or go to: admin/config/media/image-field-caption

|===============|
| Caption Theme |
|===============|

  By default, an image field's caption will be rendered below the image. To
  customize the image caption display, copy the image_field_caption.tpl.php file
  to your theme's directory and adjust the html for your needs. Flush Drupal's
  theme registry cache to have it recognize your theme's new file:

  sites/all/themes/MY_THEME/image_field_caption.tpl.php
  
|=============|
| Caption CSS |
|=============|

  To make changes to the caption css, use this CSS selector:

  blockquote.image_field_caption { /* add custom css here */ }

|=================================================|
| Programmatically Rendering Images with Captions |
|=================================================|

  // Original Image.
  $image = theme('image', array(
    'path' => 'public://my_image.jpg',
    'alt' => 'My Image Alt Text',
    'title' => 'My Image Title Text',
    'caption' => 'My Image Caption Text',
  ));

  // Thumbnail Mmage.
  $image = theme('image_style', array(
    'path' => 'public://my_image.jpg',
    'style_name' => 'thumbnail',
    'alt' => 'My Image Alt Text',
    'title' => 'My Image Title Text',
    'caption' => 'My Image Caption Text',
  ));

|==================|
| Colorbox Support |
|==================|

  To enable the use of Image Field Caption with the Colorbox module:
  
    1. Go to the 'Manage display' page for your content type, for example:
         Structure -> Content types -> Article -> Manage display
    2. Change the 'Format' to 'Colorbox' for your image field
    3. Click the gear icon to adjust the 'Format settings' for Colorbox
    4. Under 'Caption', select 'Custom (with tokens)'
    5. In the 'Custom caption' field, enter this token: [file:caption]
    6. Click the 'Update' button, then the 'Save' button

|==================|
| More Information |
|==================|

  http://www.drupal.org/project/image_field_caption
  http://www.tylerfrankenstein.com/image_field_caption

