<?php
// Heading
$_['heading_title']         = 'Товары';

// Text
$_['text_config_not_found'] = 'Файл конфигурации не найден. Войдите в настройки модуля и нажмите кнопку "Сохранить".';
$_['text_success_save_title'] = 'Сохранение';
$_['text_success_save']     = 'Изменения сохранены';
$_['text_image_note']       = '<span class="label label-warning">Важно!</span> Сортировка изображений осуществляется перетаскиванием';
$_['text_more_two_categories'] = 'Выбрано более 2х категорий';


// Columns
$_['column_product_id']     = 'ID';
$_['column_name']           = 'Наименование';
$_['column_image']          = 'Изображение';
$_['column_model']          = 'Модель';
$_['column_price']          = 'Цена';
$_['column_quantity']       = 'Количество';
$_['column_status']         = 'Статус';
$_['column_sku']            = 'Артикул';
$_['column_category']       = 'Категории';
$_['column_actions']        = '';

// action buttons
$_['action_buttons']        = array (
    'main' => 'Основные данные',
    'data' => 'Общие данные',
    'link' => 'Связи',
    'attrs' => 'Атрибуты',
    'options' => 'Опции',
    'discount' => 'Скидки',
    'bonus' => 'Бонусы',
    'seo' => 'SEO',
    'design' => 'Дизайн',
);

// action buttons
$_['modal']        = array (
    'title' => array(
        'main' => 'Основные данные',
        'data' => 'Общие данные',
        'link' => 'Связи',
        'attrs' => 'Атрибуты',
        'options' => 'Опции',
        'discount' => 'Скидки',
        'bonus' => 'Бонусы',
        'seo' => 'SEO',
        'design' => 'Дизайн',
    ),
    'fields' => array(
        'name' => 'Наименование',
        'description' => 'Описание',
        'meta_title' => 'Мета-тег Title',
        'meta_description' => 'Мета-тег Description',
        'meta_keywords' => 'Мета-тег Keyword',
        'tags' => 'Теги товара',
    ),
    'notes' => array (
        'tags' => 'Чтобы добавить тег, введите его данные и нажмите Enter'
    ),
);

// DataTable
$_['datatable_empty_table'] = 'Данные отсутствуют';
$_['datatable_info']        = 'Отображаются записи с _START_ по _END_ (из _TOTAL_ записей)';
$_['datatable_info_empty']  = 'Отображаются записи с 0 по 0 (из 0 записей)';
$_['datatable_info_filtered'] = '(отфильтровано из _MAX_ записей)';
$_['datatable_info_post_fix'] = '';
$_['datatable_thousands']   = '.';
$_['datatable_length_menu'] = 'Вывести _MENU_ записей';
$_['datatable_loading']     = 'Загрузка...';
$_['datatable_processing']  = 'Обработка...';
$_['datatable_search']      = 'Поиск:';
$_['datatable_zero_records'] = 'Совпадений не найдено';
$_['datatable_sort_asc']    = ' активируйте для сортировки столбца по возрастанию';
$_['datatable_sort_desc']   = ' активируйте для сортировки столбца по убыванию';

// Status values
$_['status_yes']            = 'Включить';
$_['status_no']             = 'Отключить';
$_['filter_status_yes']     = 'Включено';
$_['filter_status_no']      = 'Отключено';

// Edit text
$_['edit']                  = array (
    'title' => array (
        'name' => 'Наименование',
        'model' => 'Модель',
        'sku' => 'Артикул',
        'price' => 'Цена на сайте',
        'quantity' => 'Количество товара',
        'image' => 'Изображение товара',
        'category' => 'Категория',
    ),
    'buttons' => array (
        'cancel' => 'Отмена',
        'save' => 'Сохранить',
        'remove' => 'Удалить',
    ),
    'price' => array (
        'current' => 'Цена товара:',
        'specials' => 'Акции:',
        'special_add' => 'Добавить акцию',
        'table' => array(
            'group' => 'Группа клиентов',
            'priority' => 'Приоритет',
            'price' => 'Цена',
            'date_from' => 'Дата начала',
            'date_to' => 'Дата окончания',
        ),
    ),
    'image' => array (
        'current' => 'Главное фото:',
        'additional' => 'Дополнительные изображения:',
        'image_add' => 'Добавить изображение',
        'table' => array(
            'image' => 'Изображение',
            'sort' => 'Порядок сортировки',
        ),
    ),
);


// Validation
$_['validate']              = array (
    'title' => 'Ошибка данных',
    'action' => 'Не передан обязательный параметр "action"',
    'id' => 'Товар с таким ID не найден в базе данных магазина',

    'name.min' => 'Наименование должно быть длиннее {{ limit }} символов',
    'name.max' => 'Наименование не должно быть длиннее {{ limit }} символов',
    'name.required' => 'Наименование обязательно к заполнению',

    'model.min' => 'Значение поля "Модель" должна быть длиннее {{ limit }} символов',
    'model.max' => 'Значение поля "Модель" не должно быть длиннее {{ limit }} символов',
    'model.required' => 'Поле "Модель" обязательно к заполнению',

    'sku.min' => 'Значение поля "Артикул" должна быть длиннее {{ limit }} символов',
    'sku.max' => 'Значение поля "Артикул" не должно быть длиннее {{ limit }} символов',

    'quantity.min' => 'Значение поля "Количество" должно быть больше {{ limit }}',
    'quantity.required' => 'Поле "Количество" обязательно к заполнению',
    'quantity.invalid' => 'Поле "Количество" должно быть числом',

    'price.min' => 'Значение поля "Цена товара" должна быть больше {{ limit }}',
    'price.required' => 'Поле "Цена товара" обязательно к заполнению',
    'price.invalid' => 'Поле "Цена товара" должна быть числом',

    'price_special.min' => 'Значение поля "Цена по акции" должна быть больше {{ limit }}',
    'price_special.required' => 'Поле "Цена по акции" обязательно к заполнению',
    'price_special.invalid' => 'Поле "Цена по акции" должна быть числом',

    'priority.min' => 'Значение поля "Приоритет акции" должно не меньше {{ limit }}',
    'priority.invalid' => 'Поле "Приоритет акции" должно быть числом',

    'date_start.max' => 'Поле "Дата начала акции" должно быть не больше заполненного поля "Дата окончания акции" и "2100-01-01"',
    'date_start.invalid' => 'Поле "Дата начала акции" должно быть датой в формате YYYY-MM-DD',
    'date_end.min' => 'Поле "Дата окончания акции" должно быть не меньше заполненного поля "Дата начала акции" и "1900-01-01"',
    'date_end.invalid' => 'Поле "Дата окончания акции" должно быть датой в формате YYYY-MM-DD',

    'sort_order.min' => 'Значение поля "Порядок сортировки" должна быть больше {{ limit }}',
    'sort_order.required' => 'Поле "Порядок сортировки" обязательно к заполнению',
    'sort_order.invalid' => 'Поле "Порядок сортировки" должна быть числом',

    'meta_title.min' => 'Мета-тег "Title" должен быть длиннее {{ limit }} символов',
    'meta_title.max' => 'Мета-тег "Title" не должен быть длиннее {{ limit }} символов',
    'meta_title.required' => 'Мета-тег "Title" обязателен к заполнению',

    'meta_description.max' => 'Мета-тег "Description" не должен быть длиннее {{ limit }} символов',
    'meta_keyword.max' => 'Мета-тег "Keyword" не должен быть длиннее {{ limit }} символов',
);
