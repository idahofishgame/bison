<?php

/**
 * @file
 * template.php
 */
 
/**
 * Implements theme_menu_link()
 * Overrides addition caret to dropdown added in bootstrap_menu_link.
 */
function bison_menu_link(array $variables) {
  $element = $variables['element'];
  $sub_menu = '';

  if ($element['#below']) {
    // Prevent dropdown functions from being added to management menu so it
    // does not affect the navbar module.
    if (($element['#original_link']['menu_name'] == 'management') && (module_exists('navbar'))) {
      $sub_menu = drupal_render($element['#below']);
    }
    elseif ((!empty($element['#original_link']['depth'])) && ($element['#original_link']['depth'] == 1)) {
      // Add our own wrapper.
      unset($element['#below']['#theme_wrappers']);
      $sub_menu = '<ul class="dropdown-menu">' . drupal_render($element['#below']) . '</ul>';
      // Generate as standard dropdown.
      // $element['#title'] .= ' <span class="caret"></span>';  // Hide dropdown.
      $element['#attributes']['class'][] = 'dropdown';
      $element['#localized_options']['html'] = TRUE;

      // Set dropdown trigger element to # to prevent inadvertant page loading
      // when a submenu link is clicked.
      $element['#localized_options']['attributes']['data-target'] = '#';
      $element['#localized_options']['attributes']['class'][] = 'dropdown-toggle';
      $element['#localized_options']['attributes']['data-toggle'] = 'dropdown';
    }
  }
  // On primary navigation menu, class 'active' is not set on active menu item.
  // @see https://drupal.org/node/1896674
  if (($element['#href'] == $_GET['q'] || ($element['#href'] == '<front>' && drupal_is_front_page())) && (empty($element['#localized_options']['language']))) {
    $element['#attributes']['class'][] = 'active';
  }
  $output = l($element['#title'], $element['#href'], $element['#localized_options']);
  return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
}

/**
 * Implements theme_form_element()
 * Moves description above form element.

function bison_form_element($variables) {
  $element = $variables['element'];
  if (isset($element['#field_name'])) {
    switch ($element['#field_name']) {
      default:
        $variables['element']['#description_top'] = $variables['element']['#description'];
        unset($variables['element']['#description']);
        break;
    }
  }
  return theme_form_element($variables);
} */

/**
 * Implements theme_form_element_label()
 * Builds description_top element.

function bison_form_element_label($variables) {
  $output = theme_form_element_label($variables);
  $element = $variables['element'];
  if (isset($element['#description_top'])) {
    $output .= '<div class="description">' . $element['#description_top'] . "</div>\n";
  }
  return $output;
} */
