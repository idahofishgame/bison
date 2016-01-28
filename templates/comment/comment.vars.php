<?php
/**
 * @file
 * comment.vars.php
 *
 * @see comment.tpl.php
 */

/**
 * Implements template_preprocess_comment().
 */
function bison_preprocess_comment(&$variables) {
  $comment = $variables['elements']['#comment'];
  $node = $variables['elements']['#node'];
  $variables['classes_array'][] = 'media';
  $variables['title_attributes_array']['class'][] = 'media-heading';
  $variables['time_ago'] = format_interval((time() - $comment->changed) , 2) . t(' ago');
}