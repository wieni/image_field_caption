|=====================|
| Image Field Caption |
|=====================|

Provides a caption text area (similar to alt/title) for image fields.

|==============|
| Installation |
|==============|

1. Download the module
2. Upload it to your sites/all/modules folder
3. Enable the module

|=======|
| Usage |
|=======|

1. Add a content type with an image field
2. Go to Add (or edit) a node with an image field
3. Scroll down to the image field element on the node form
4. Add text into the caption text area
5. Save the node

|=======================================|
| How to Display an Image Field Caption |
|=======================================|

These examples use the Content Type called Page (machine name: page), with an
image field (machine name: field_my_images).

Node Template File
------------------

1. Create the file node--page.tpl.php in sites/all/themes/MY_THEME by copying
   the node.tpl.php file that comes with your theme.
2. Add this code to node--page.tpl.php:

    <?php
      if (isset($field_my_images[0]['caption'])) {
        print $field_my_images[0]['caption'];
      }
    ?>

Views Template File
-------------------

1. Create the file views-view-field--my-images.tpl.php in your theme's
   sites/all/themes/MY_THEME directory.
2. Replace <?php print $output ?> in views-view-field--my-images.tpl.php with
   this code:

    <?php
      print $output;
      $delta = $row->field_data_field_my_images_delta;
      if (isset($row->_field_data['nid']['entity']->field_my_images['und'][$delta]['caption'])) {
        print $row->_field_data['nid']['entity']->field_my_images['und'][$delta]['caption'];
      }
    ?>

