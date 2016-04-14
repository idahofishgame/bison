<?php

/**
 * @file
 * template.php
 */
 
/**
 * Implements theme_menu_link__main_menu()
 * Overrides addition caret to dropdown added in bootstrap_menu_link
 * and treats level 2 as menu-category style displaying n-levels.
 */
function bison_menu_link__main_menu(array $variables) {
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
      $sub_menu = '<ul class="dropdown-menu columns">' . drupal_render($element['#below']) . '</ul>';
      // Generate as standard dropdown.
      // $element['#title'] .= ' <span class="caret"></span>';  // Hide dropdown.
      $element['#attributes']['class'][] = 'dropdown';
      $element['#localized_options']['html'] = TRUE;

      // Set dropdown trigger element to # to prevent inadvertant page loading
      // when a submenu link is clicked.
      $element['#localized_options']['attributes']['data-target'] = '#';
      $element['#localized_options']['attributes']['class'][] = 'dropdown-toggle';
      $element['#localized_options']['attributes']['data-toggle'] = 'dropdown';
    } elseif ((!empty($element['#original_link']['depth'])) && $element['#original_link']['depth'] > 1) {
      // Add our own wrapper.
      unset($element['#below']['#theme_wrappers']);
      $sub_menu = drupal_render($element['#below']);
      if ($element['#original_link']['depth'] == 2) {
        $element['#localized_options']['attributes']['class'][] = 'menu-category';
      }
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
 */
function bison_form_element($variables) {
  $element = $variables['element'];
  if (isset($element['#field_name']) && isset($element['#description'])) {
    $variables['element']['#description_top'] = $element['#description'];
    unset($variables['element']['#description']);
  }
  return theme_form_element($variables);
}

/**
 * Implements theme_form_element_label()
 * Builds description_top element.
 */
function bison_form_element_label($variables) {
  $output = theme_form_element_label($variables);
  $element = $variables['element'];
  if (isset($element['#description_top'])) {
    $output .= '<div class="text-muted"><small>' . $element['#description_top'] . "</small></div>\n";
  }
  return $output;
}

/*
 * Implements theme_preprocess_node()
 * Simplifies submitted contents.
 */
function bison_preprocess_node(&$vars, $hook) {
  $vars['submitted'] = 'By '.$vars['name'].' on '.date("l, M jS, Y g:ia T", $vars['created']);
}

/**
 * Implements template_preprocess_field().
 */
function bison_preprocess_field(&$vars, $hook) {
  // Add line breaks to plain text textareas.
  if (
    // Make sure this is a text_long field type.
    $vars['element']['#field_type'] == 'text_long'
    // Check that the field's format is set to null, which equates to plain_text.
    && $vars['element']['#items'][0]['format'] == null
  ) {
    $vars['items'][0]['#markup'] = nl2br($vars['items'][0]['#markup']);
  }
}
