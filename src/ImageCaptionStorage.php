<?php

/**
 * @file
 * Contains \Drupal\image_field_caption\ImageCaptionStorage.
 */

namespace Drupal\image_field_caption;

use Drupal\Core\Database\Database;
use Drupal\Core\Entity\EntityInterface;

/**
 * Storage controller class for image captions.
 *
 * @todo Use array with key/value as argument instead several arguments.
 * @todo The methods isCaption() and deleteCaption() must manage the revisions by itself, instead to have two differents methods.
 */
class ImageCaptionStorage {

  /**
   * The name of the data table.
   * @var string
   */
  private static $_table_data = 'image_field_caption';

  /**
   * The name of the revision table.
   * @var string
   */
  private static $_table_revision = 'image_field_caption_revision';

  /**
   * Check if a caption is already defined for the specified arguments.
   *
   * @param string $entity_type
   *   The entity type, like 'node' or 'comment'.
   * @param string $bundle
   *   The bundle, like 'article' or 'news'.
   * @param string $field_name
   *   The field name of the image field, like 'field_image' or 'field_article_image'.
   * @param integer $entity_id
   *   The entity id.
   * @param integer $revision_id
   *   The revision id.
   * @param string $language
   *   The language key, like 'en' or 'fr'.
   * @param integer $delta
   *   The delta of the image field.
   * @param string $caption
   *   The caption text.
   * @param string $caption_format
   *   The text format of the caption.
   *
   * @return bool
   *  TRUE if a caption exists or FALSE if not.
   */
  static function isCaption($entity_type, $bundle, $field_name, $entity_id, $revision_id, $language, $delta) {
    return (!empty(self::getCaption($entity_type, $bundle, $field_name, $entity_id, $revision_id, $language, $delta))) ? TRUE : FALSE;
  }

  /**
   * Get a caption from the database for the specified arguments.
   *
   * @param string $entity_type
   *   The entity type, like 'node' or 'comment'.
   * @param string $bundle
   *   The bundle, like 'article' or 'news'.
   * @param string $field_name
   *   The field name of the image field, like 'field_image' or 'field_article_image'.
   * @param integer $entity_id
   *   The entity id.
   * @param integer $revision_id
   *   The revision id.
   * @param string $language
   *   The language key, like 'en' or 'fr'.
   * @param integer $delta
   *   The delta of the image field.
   *
   * @return array
   *   A caption array
   *   - caption: The caption text.
   *   - caption_format: The caption format.
   *   or an empty array, if no value found.
   */
  static function getCaption($entity_type, $bundle, $field_name, $entity_id, $revision_id, $language, $delta) {
    $connection = Database::getConnection();

    // Query.
    $query = $connection->select(self::$_table_data, 'ifc')
      ->fields('ifc', array('caption', 'caption_format'))
      ->condition('entity_type', $entity_type, '=')
      ->condition('bundle', $bundle, '=')
      ->condition('field_name', $field_name, '=')
      ->condition('entity_id', $entity_id, '=')
      ->condition('revision_id', $revision_id, '=')
      ->condition('language', $language, '=')
      ->condition('delta', $delta, '=')
      ->execute();
    // Result.
    $result = $query->fetchAssoc();

    // Caption array.
    $caption = array();
    if(!empty($result)) {
      $caption = $result;
    }

    return $caption;
  }

  /**
   * Insert a caption into the database for the specified arguments.
   *
   * @param string $entity_type
   *   The entity type, like 'node' or 'comment'.
   * @param string $bundle
   *   The bundle, like 'article' or 'news'.
   * @param string $field_name
   *   The field name of the image field, like 'field_image' or 'field_article_image'.
   * @param integer $entity_id
   *   The entity id.
   * @param integer $revision_id
   *   The revision id.
   * @param string $language
   *   The language key, like 'en' or 'fr'.
   * @param integer $delta
   *   The delta of the image field.
   * @param string $caption
   *   The caption text.
   * @param string $caption_format
   *   The text format of the caption.
   *
   * @return void
   */
  static function insertCaption($entity_type, $bundle, $field_name, $entity_id, $revision_id, $language, $delta, $caption, $caption_format) {
    $connection = Database::getConnection();

    // Query.
    $query = $connection->insert(self::$_table_data)
      ->fields(array(
        'entity_type' => $entity_type,
        'bundle' => $bundle,
        'field_name' => $field_name,
        'entity_id' => $entity_id,
        'revision_id' => $revision_id,
        'language' => $language,
        'delta' => $delta,
        'caption' => $caption,
        'caption_format' => $caption_format,
      ))
      ->execute();
  }

  /**
   * Insert a caption revision into the database for the specified arguments.
   *
   * @param string $entity_type
   *   The entity type, like 'node' or 'comment'.
   * @param string $bundle
   *   The bundle, like 'article' or 'news'.
   * @param string $field_name
   *   The field name of the image field, like 'field_image' or 'field_article_image'.
   * @param integer $entity_id
   *   The entity id.
   * @param integer $revision_id
   *   The revision id.
   * @param string $language
   *   The language key, like 'en' or 'fr'.
   * @param integer $delta
   *   The delta of the image field.
   * @param string $caption
   *   The caption text.
   * @param string $caption_format
   *   The text format of the caption.
   *
   * @return void
   */
  static function insertCaptionRevision($entity_type, $bundle, $field_name, $entity_id, $revision_id, $language, $delta, $caption, $caption_format) {
    $connection = Database::getConnection();

    // Query.
    $query = $connection->insert(self::$_table_revision)
      ->fields(array(
        'entity_type' => $entity_type,
        'bundle' => $bundle,
        'field_name' => $field_name,
        'entity_id' => $entity_id,
        'revision_id' => $revision_id,
        'language' => $language,
        'delta' => $delta,
        'caption' => $caption,
        'caption_format' => $caption_format,
      ))
      ->execute();
  }

  /**
   * Delete a caption from the database for the specified arguments.
   *
   * @param string $entity_type
   *   The entity type, like 'node' or 'comment'.
   * @param string $bundle
   *   The bundle, like 'article' or 'news'.
   * @param string $field_name
   *   The field name of the image field, like 'field_image' or 'field_article_image'.
   * @param integer $entity_id
   *   The entity id.
   * @param string $language
   *   The language key, like 'en' or 'fr'.
   *
   * @return void
   */
  static function deleteCaption($entity_type, $bundle, $field_name, $entity_id, $language) {
    $connection = Database::getConnection();

    // Query.
    $query = $connection->delete(self::$_table_data)
      ->condition('entity_type', $entity_type, '=')
      ->condition('bundle', $bundle, '=')
      ->condition('field_name', $field_name, '=')
      ->condition('entity_id', $entity_id, '=')
      ->condition('language', $language, '=')
      ->execute();
    // @todo Try to return the count of the affected rows.
  }

  /**
   * Delete a caption revision from the database for the specified arguments.
   *
   * @param string $entity_type
   *   The entity type, like 'node' or 'comment'.
   * @param string $bundle
   *   The bundle, like 'article' or 'news'.
   * @param string $field_name
   *   The field name of the image field, like 'field_image' or 'field_article_image'.
   * @param integer $entity_id
   *   The entity id.
   * @param integer $revision_id
   *   The revision id.
   * @param string $language
   *   The language key, like 'en' or 'fr'.
   *
   * @return void
   */
  static function deleteCaptionRevision($entity_type, $bundle, $field_name, $entity_id, $revision_id, $language) {
    $connection = Database::getConnection();

    // Query.
    $query = $connection->delete(self::$_table_revision)
      ->condition('entity_type', $entity_type, '=')
      ->condition('bundle', $bundle, '=')
      ->condition('field_name', $field_name, '=')
      ->condition('entity_id', $entity_id, '=')
      ->condition('revision_id', $revision_id, '=')
      ->condition('language', $language, '=')
      ->execute();
    // @todo Try to return the count of the affected rows.
  }

  /**
   * Delete all captions revisions from the database for the specified arguments.
   *
   * @param string $entity_type
   *   The entity type, like 'node' or 'comment'.
   * @param string $bundle
   *   The bundle, like 'article' or 'news'.
   * @param string $field_name
   *   The field name of the image field, like 'field_image' or 'field_article_image'.
   * @param integer $entity_id
   *   The entity id.
   * @param string $language
   *   The language key, like 'en' or 'fr'.
   *
   * @return void
   */
  static function deleteCaptionRevisions($entity_type, $bundle, $field_name, $entity_id, $language) {
    $connection = Database::getConnection();

    // Query.
    $query = $connection->delete(self::$_table_revision)
      ->condition('entity_type', $entity_type, '=')
      ->condition('bundle', $bundle, '=')
      ->condition('field_name', $field_name, '=')
      ->condition('entity_id', $entity_id, '=')
      ->condition('language', $language, '=')
      ->execute();
    // @todo Try to return the count of the affected rows.
  }

  /**
   * Delete all captions revisions for a specific revision id.
   *
   * @param integer $revision_id
   *   The revision id.
   *
   * @return void
   */
  static function deleteCaptionRevisionsByRevisionId($revision_id) {
    $connection = Database::getConnection();

    // Query.
    $query = $connection->delete(self::$_table_revision)
      ->condition('revision_id', $revision_id, '=')
      ->execute();
  }

}
