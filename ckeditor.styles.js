/*
 Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.html or http://ckeditor.com/license
 */

/*
 * This file is used/requested by the 'Styles' button.
 * The 'Styles' button is not enabled by default in DrupalFull and DrupalFiltered toolbars.
 */
if(typeof(CKEDITOR) !== 'undefined') {
  CKEDITOR.addStylesSet( 'drupal',
    [

      /* Bootstrap Styles */

      /* Typography */
      { name : 'Paragraph Lead'     , element : 'p', attributes: { 'class': 'lead' } },
      { name : 'Mark', element: 'mark'},

      {
        name : 'Unstyled List',
        element : 'ul',
        attributes :
        {
          'class' : 'list-unstyled'
        }
      },
      {
        name : 'List inline',
        element : 'ul',
        attributes :
        {
          'class' : 'list-inline'
        }
      },


      {
        name : 'Table',
        element : 'table',
        attributes :
        {
          'class' : 'table'
        }
      },

      {
        name : 'Table Striped rows',
        element : 'table',
        attributes :
        {
          'class' : 'table table-striped'
        }
      },
      {
        name : 'Table Bordered',
        element : 'table',
        attributes :
        {
          'class' : 'table table-bordered'
        }
      },
      {
        name : 'Table Hover rows',
        element : 'table',
        attributes :
        {
          'class' : 'table table-hover'
        }
      },
      {
        name : 'Table Condensed',
        element : 'table',
        attributes :
        {
          'class' : 'table table-condensed'
        }
      },
      {
        name : 'Pull left',
        element : 'div',
        attributes :
        {
          'class' : 'pull-left'
        }
      },
      {
        name : 'Pull right',
        element : 'div',
        attributes :
        {
          'class' : 'pull-right'
        }
      },
      { name : 'Well'     , element : 'div', attributes: { 'class': 'well' } },
      { name : 'Muted Text'     , element : 'div', attributes: { 'class': 'text-muted' } },
      { name : 'Primary'     , element : 'div', attributes: { 'class': 'text-primary bg-primary' } },
      { name : 'Success'     , element : 'div', attributes: { 'class': 'text-success bg-success' } },
      { name : 'Info'     , element : 'div', attributes: { 'class': 'text-info bg-info' } },
      { name : 'Warning'     , element : 'div', attributes: { 'class': 'text-warning bg-warning' } },
      { name : 'Danger'     , element : 'div', attributes: { 'class': 'text-danger bg-danger' } },
      { name : 'Center Block'     , element : 'div', attributes: { 'class': 'center-block' } },
      { name : 'Clearfix'     , element : 'div', attributes: { 'class': 'clearfix' } },
      { name : 'Hidden'     , element : 'div', attributes: { 'class': 'hidden' } },
      { name : 'Address'     , element : 'address' },
      { name : 'Footer'     , element : 'footer' },
      { name : 'Keyboard'     , element : 'kbd' },
      { name : 'Variable'     , element : 'var' },
      { name : 'Description'     , element : 'div', attributes: { 'class': 'description' } },
      { name : 'Button Default'     , element : 'button', attributes: { 'type': 'button', 'class': 'btn btn-default' } },
      { name : 'Button Primary'     , element : 'button', attributes: { 'type': 'button', 'class': 'btn btn-primary' } },
      { name : 'Button Success'     , element : 'button', attributes: { 'type': 'button', 'class': 'btn btn-success' } },
      { name : 'Button Info'     , element : 'button', attributes: { 'type': 'button', 'class': 'btn btn-info' } },
      { name : 'Button Warning'     , element : 'button', attributes: { 'type': 'button', 'class': 'btn btn-warning' } },
      { name : 'Button Danger'     , element : 'button', attributes: { 'type': 'button', 'class': 'btn btn-danger' } },
      { name : 'Button Link'     , element : 'button', attributes: { 'type': 'button', 'class': 'btn btn-link' } },
    ]);
}
