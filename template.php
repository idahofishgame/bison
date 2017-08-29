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

  $options = !empty($element['#localized_options']) ? $element['#localized_options'] : array();

  // Check plain title if "html" is not set, otherwise, filter for XSS attacks.
  $title = empty($options['html']) ? check_plain($element['#title']) : filter_xss_admin($element['#title']);

  // Ensure "html" is now enabled so l() doesn't double encode. This is now
  // safe to do since both check_plain() and filter_xss_admin() encode HTML
  // entities. See: https://www.drupal.org/node/2854978
  $options['html'] = TRUE;

  $href = $element['#href'];
  $attributes = !empty($element['#attributes']) ? $element['#attributes'] : array();

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
      $attributes['class'][] = 'dropdown';

      $options['html'] = TRUE;

      // Set dropdown trigger element to # to prevent inadvertant page loading
      // when a submenu link is clicked.
      $options['attributes']['data-target'] = '#';
      $options['attributes']['class'][] = 'dropdown-toggle';
      $options['attributes']['data-toggle'] = 'dropdown';
    }
    elseif ((!empty($element['#original_link']['depth'])) && $element['#original_link']['depth'] > 1) {
      // Add our own wrapper.
      $sub_menu = drupal_render($element['#below']);
    }
  }

  // Add wrapper menu for depth.
  if ($element['#original_link']['depth'] == 2) {
    $options['attributes']['class'][] = 'menu-category';
  }

  return '<li' . drupal_attributes($attributes) . '>' . l($title, $href, $options) . $sub_menu . "</li>\n";
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
    $output .= '<small class="text-muted">' . $element['#description_top'] . "</small>\n";
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

/**
 * Returns HTML for status and/or error messages, grouped by type.
 *
 * An invisible heading identifies the messages for assistive technology.
 * Sighted users see a colored box. See http://www.w3.org/TR/WCAG-TECHS/H69.html
 * for info.
 *
 * @param array $variables
 *   An associative array containing:
 *   - display: (optional) Set to 'status' or 'error' to display only messages
 *     of that type.
 *
 * @return string
 *   The constructed HTML.
 *
 * @see theme_status_messages()
 *
 * @ingroup theme_functions
 */
function bison_status_messages($variables) {
  $display = $variables['display'];
  $output = '';

  $status_heading = array(
    'status' => t('Status message'),
    'error' => t('Error message'),
    'warning' => t('Warning message'),
    'info' => t('Informative message'),
  );

  // Map Drupal message types to their corresponding Bootstrap classes.
  // @see http://twitter.github.com/bootstrap/components.html#alerts
  $status_class = array(
    'status' => 'success',
    'error' => 'danger',
    'warning' => 'warning',
    // Not supported, but in theory a module could send any type of message.
    // @see drupal_set_message()
    // @see theme_status_messages()
    'info' => 'info',
  );

  // Retrieve messages.
  $message_list = drupal_get_messages($display);

  // Allow the disabled_messages module to filter the messages, if enabled.
  if (module_exists('disable_messages') && variable_get('disable_messages_enable', '1')) {
    $message_list = disable_messages_apply_filters($message_list);
  }

  foreach ($message_list as $type => $messages) {
    $class = (isset($status_class[$type])) ? ' alert-' . $status_class[$type] : '';
    $output .= "<div class=\"alert alert-block$class messages $type\">\n";
    $output .= "  <a class=\"close\" data-dismiss=\"alert\" href=\"#\">&times;</a>\n";

    if (!empty($status_heading[$type])) {
      if (!module_exists('devel')) {
        $output .= '<h4 class="element-invisible">' . filter_xss_admin($status_heading[$type]) . "</h4>\n";
      }
      else {
        $output .= '<h4 class="element-invisible">' . $status_heading[$type] . "</h4>\n";
      }
    }

    if (count($messages) > 1) {
      $output .= " <ul>\n";
      foreach ($messages as $message) {
        if (!module_exists('devel')) {
          $output .= '  <li>' . filter_xss_admin($message) . "</li>\n";
        }
        else {
          $output .= ' <li>' . $message . "</li>\n";
        }
      }
      $output .= " </ul>\n";
    }
    else {
      if (!module_exists('devel')) {
        $output .= filter_xss_admin($messages[0]);
      } else {
        $output .= $messages[0];
      }
    }

    $output .= "</div>\n";
  }
  return $output;
}
