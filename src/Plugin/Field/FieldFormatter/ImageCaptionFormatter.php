<?php

/**
 * @file
 * Contains \Drupal\image_field_caption\Plugin\Field\FieldFormatter\ImageCaptionFormatter.
 */

namespace Drupal\image_field_caption\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\image\Plugin\Field\FieldFormatter\ImageFormatter;
use Drupal\image_field_caption\ImageCaptionItem;

/**
 * Plugin implementation of the 'image_caption' formatter.
 *
 * @FieldFormatter(
 *   id = "image_caption",
 *   label = @Translation("Image with caption"),
 *   field_types = {
 *     "image"
 *   }
 * )
 */
class ImageCaptionFormatter extends ImageFormatter {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = parent::viewElements($items, $langcode);

    $imageCaption = \Drupal::service('image_field_caption.storage');

    foreach ($elements as $delta => $element) {
      /** @var ImageCaptionItem $image */
      $image = $element['#item'];

      $field = $image->getFieldDefinition();
      $parentEntity = $image->getEntity();

      if ($field && $parentEntity) {

        // Get the caption out of DB.
        $caption = $imageCaption->getCaption(
              $parentEntity->getEntityTypeId(),
              $parentEntity->bundle(),
              $field->getName(),
              $parentEntity->id(),
              empty($parentEntity->getRevisionId()) ? $parentEntity->id() : $parentEntity->getRevisionId(),
              $parentEntity->language()->getId(),
              $delta
          );

        $elements[$delta]['#caption'] = [
          '#markup' => $caption ? $caption['caption'] : '',
        ];
      }

      // Set a new theme callback function for the image caption formatter.
      $elements[$delta]['#theme'] = 'image_caption_formatter';
    }

    return $elements;
  }

}
