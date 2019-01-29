<?php
// Heading
$_['heading_title']         = 'Products';

// Text
$_['text_config_not_found'] = 'Configuration file not found. Enter the module settings and click "Save."';
$_['text_success_save_title'] = 'Save';
$_['text_success_save']     = 'Changes saved';
$_['text_image_note']       = '<span class="label label-warning">Important!</span> Images are sorted by drag and drop.';
$_['text_more_two_categories'] = 'More than 2 categories selected';

// Columns
$_['column_product_id']     = 'ID';
$_['column_name']           = 'Name';
$_['column_image']          = 'Image';
$_['column_model']          = 'Model';
$_['column_price']          = 'Price';
$_['column_quantity']       = 'Quantity';
$_['column_status']         = 'Status';
$_['column_sku']            = 'SKU';
$_['column_category']       = 'Category';
$_['column_actions']        = '';

// DataTable
$_['datatable_empty_table'] = 'No data available';
$_['datatable_info']        = 'Displays entries from _START_ to _END_ (from _TOTAL_ entries)';
$_['datatable_info_empty']  = 'Showing records from 0 to 0 (of 0 records)';
$_['datatable_info_filtered'] = '(filtered from _MAX_ records)';
$_['datatable_info_post_fix'] = '';
$_['datatable_thousands']   = '.';
$_['datatable_length_menu'] = 'Display _MENU_ records';
$_['datatable_loading']     = 'Loading...';
$_['datatable_processing']  = 'Processing...';
$_['datatable_search']      = 'Search:';
$_['datatable_zero_records'] = 'No matches found';
$_['datatable_sort_asc']    = ' activate to sort the column in ascending order';
$_['datatable_sort_desc']   = ' activate to sort the column descending';

// Status values
$_['status_yes']            = 'Enable';
$_['status_no']             = 'Disable';
$_['filter_status_yes']     = 'Enabled';
$_['filter_status_no']      = 'Disabled';

// Edit text
$_['edit']                  = array (
    'title' => array (
        'name' => 'Name',
        'model' => 'Model',
        'sku' => 'Sku',
        'price' => 'Price',
        'quantity' => 'Quantity of products',
        'image' => 'Product Image',
        'category' => 'Category',
    ),
    'buttons' => array (
        'cancel' => 'Cancel',
        'save' => 'Save',
        'remove' => 'Remove',
    ),
    'price' => array (
        'current' => 'Price:',
        'specials' => 'Promotions:',
        'special_add' => 'Add promotion',
        'table' => array(
            'group' => 'Customer group',
            'priority' => 'A priority',
            'price' => 'Price',
            'date_from' => 'Start date',
            'date_to' => 'End date',
        ),
    ),
    'image' => array (
        'current' => 'Main image:',
        'additional' => 'Additional Images:',
        'image_add' => 'Add image',
        'table' => array(
            'image' => 'Image',
            'sort' => 'The sort order',
        ),
    ),
);


// Validation
$_['validate']              = array (
    'title' => 'Data error',
    'action' => 'Required parameter not passed "action"',
    'id' => 'Product with this ID was not found in the store database',

    'name.min' => 'Name must be longer than {{limit}} characters',
    'name.max' => 'Name should not be longer {{limit}} characters',
    'name.required' => 'Name is required',

    'model.min' => 'The value of the field "Model" must be longer than {{limit}} characters',
    'model.max' => 'The value of the field "Model" must not be longer than {{limit}} characters',
    'model.required' => 'The field "Model" is required',

    'sku.min' => 'The value of the field "SKU" must be longer than {{limit}} characters',
    'sku.max' => 'The value of the field "SKU" should not be longer {{{limit}} characters',

    'quantity.min' => 'The value of the field "Quantity" must be greater than {{limit}}',
    'quantity.required' => 'The field "Quantity" is required',
    'quantity.invalid' => 'The field "Quantity" must be a number',

    'price.min' => 'The value of the field "Price" must be greater {{limit}}',
    'price.required' => 'The field "Price" is required',
    'price.invalid' => 'The field "Price" must be a number',

    'price_special.min' => 'The value of the field "Promotion price" must be greater than {{limit}}',
    'price_special.required' => 'The field "Promotion price" is required',
    'price_special.invalid' => 'The field "Promotion price" must be a number',

    'priority.min' => 'The value of the field "Priority of the promotion" must not be less than {{limit}}',
    'priority.invalid' => 'The field "Priority of the promotion" must be a number',

    'date_start.max' => 'The field "Start date of the promotion" must not exceed the filled field "End date of the action" and "2100-01-01"',
    'date_start.invalid' => 'The field "Start date of the promotion" must be a date in the format YYYY-MM-DD',
    'date_end.min' => 'The field "End date of the promotion" must be at least the filled field "Date of the start of the action" and "1900-01-01"',
    'date_end.invalid' => 'The field "End Date of promotion" must be a date in the format YYYY-MM-DD',

    'sort_order.min' => 'The value of the "Sort Order" field must be greater than {{limit}}',
    'sort_order.required' => 'The "Sort Order" field is required',
    'sort_order.invalid' => 'The "Sort Order" field must be a number',
);
