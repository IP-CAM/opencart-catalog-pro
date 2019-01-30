<?php
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;

class ControllerExtensionModuleCatalogProProduct extends Controller {
	private $error = array();

	private function loadLanguage() {
        $this->load->language('extension/module/catalog_pro_default');
        $this->load->language('extension/module/catalog_pro_product');
    }

	public function index() {
        $this->loadLanguage();
        $this->load->model('tool/image');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->getList();
	}

	private function getColumnValues($field) {
        switch ($field) {
            case 'status': return array (
                                        "0" => $this->language->get('filter_status_no'),
                                        "1" => $this->language->get('filter_status_yes')
                                    );
                break;
        }
    }

    private function getColumnContent($field) {
        switch ($field) {
            case 'category':
                return $this->load->view('extension/module/catalog_pro/filter_categories', array(
                    "more_two_categories" => $this->language->get('text_more_two_categories'),
                    "categories" => $this->model_extension_catalog_pro_category->getCategories())
                );
                break;
        }
    }


    protected function getList() {
        $this->load->model('extension/catalog_pro/category');

	    unset($data);

        if (!file_exists(DIR_APPLICATION.'controller/extension/module/catalog_pro.json'))
            $data['error_warning'] = $this->language->get('text_config_not_found');
        else
            $config = json_decode(file_get_contents(DIR_APPLICATION.'controller/extension/module/catalog_pro.json'), true);

        $url = "";

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('menu_parent'),
            'href' => $this->url->link('extension/module/catalog_pro_configuration', 'user_token=' . $this->session->data['user_token'] . $url, true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('submenu_product'),
            'href' => $this->url->link('extension/module/catalog_pro_product', 'user_token=' . $this->session->data['user_token'] . $url, true)
        );

        $data['user_token'] = $this->session->data['user_token'];

        if (isset($config)) {
			$data['columns'] = array();
            foreach($config['columns'] as $field => $value) {
                if ($value['visible'] == 1) {
                    $data['columns'][] = [
                        'title' => $this->language->get('column_'.$field),
                        'data' => $field,
                        'width' => $value['width'],
                        'className' => ($field != 'status' && $field != 'product_id' && $field != 'actions'? 'cell ': ''). $value['className'],
                        'orderable' => $value['sort'] == 1? true: false,
                        'type' => isset($value['type'])? $value['type']: null,
                        'values' => isset($value['type'])? ($value['type'] == "select"? $this->getColumnValues($field): null): null,
                        'content' => isset($value['type'])? ($value['type'] == "select-choice"? $this->getColumnContent($field): null): null,
                    ];
                }
            }
			
			$data['columns'] = json_encode($data['columns']);
			$data['limit'] = $config['limit'];
        }



        $data['data'] = str_replace("&amp;", "&", $this->url->link('extension/module/catalog_pro_product/data', 'user_token=' . $this->session->data['user_token'], true));
        $data['edit'] = str_replace("&amp;", "&", $this->url->link('extension/module/catalog_pro_product/edit', 'user_token=' . $this->session->data['user_token'], true));
        $data['save'] = str_replace("&amp;", "&", $this->url->link('extension/module/catalog_pro_product/save', 'user_token=' . $this->session->data['user_token'], true));
        $data['edit_data'] = str_replace("&amp;", "&", $this->url->link('extension/module/catalog_pro_product/editdata', 'user_token=' . $this->session->data['user_token'], true));
        $data['save_data'] = str_replace("&amp;", "&", $this->url->link('extension/module/catalog_pro_product/savedata', 'user_token=' . $this->session->data['user_token'], true));
        $data['active'] = str_replace("&amp;", "&", $this->url->link('extension/module/catalog_pro_product/active', 'user_token=' . $this->session->data['user_token'], true));

        $data['noimage'] = $this->model_tool_image->resize('no_image.png', 60, 60);

        $data['table_name'] = $this->language->get('table_name');
        $data['table_visible'] = $this->language->get('table_visible');

        $data['visible_yes'] = $this->language->get('visible_yes');
        $data['visible_no'] = $this->language->get('visible_no');

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $data['datatable']['empty_table'] = $this->language->get('datatable_empty_table');
        $data['datatable']['info'] = $this->language->get('datatable_info');
        $data['datatable']['info_empty'] = $this->language->get('datatable_info_empty');
        $data['datatable']['info_filtered'] = $this->language->get('datatable_info_filtered');
        $data['datatable']['info_post_fix'] = $this->language->get('datatable_info_post_fix');
        $data['datatable']['thousands'] = $this->language->get('datatable_thousands');
        $data['datatable']['length_menu'] = $this->language->get('datatable_length_menu');
        $data['datatable']['loading'] = $this->language->get('datatable_loading');
        $data['datatable']['processing'] = $this->language->get('datatable_processing');
        $data['datatable']['search'] = $this->language->get('datatable_search');
        $data['datatable']['zero_records'] = $this->language->get('datatable_zero_records');
        $data['datatable']['sort_asc'] = $this->language->get('datatable_sort_asc');
        $data['datatable']['sort_desc'] = $this->language->get('datatable_sort_desc');
        $data['eLang'] = $this->language->get('edit');

        $this->response->setOutput($this->load->view('extension/module/catalog_pro/product', $data));
	}

	public function data() {
        $this->loadLanguage();

        $config = json_decode(file_get_contents(DIR_APPLICATION.'controller/extension/module/catalog_pro.json'), true);

        $this->load->model('extension/catalog_pro/product');
        $this->load->model('extension/catalog_pro/category');
        $this->load->model('tool/image');

        $deTree = $this->model_extension_catalog_pro_category->getDeTree();

        $filter_data = array(
            'start'           => $this->request->get['start'],
            'limit'           => $this->request->get['length'],
        );

        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
            $request = $this->request->get['columns'];
            $field = $request[$order[0]['column']]['data'];

            $filter_data['order'] = $order[0]['dir'];

            switch ($field) {
                case 'name': $filter_data['sort'] = "pd.name"; break;
                case 'model': $filter_data['sort'] = "p.model"; break;
                case 'sku': $filter_data['sort'] = "p.sku"; break;
                case 'price': $filter_data['sort'] = "p.price"; break;
                case 'quantity': $filter_data['sort'] = "p.quantity"; break;
                case 'status': $filter_data['sort'] = "p.status"; break;
                default: $filter_data['sort'] = "p.product_id"; $filter_data['order'] = "desc"; break;
            }
        }

        $search = array();
        foreach ($this->request->get['columns'] as $column) {
            if ($column['search']['value'] != "")
                $filter_data['filter_'.$column['data']] = $column['search']['value'];
        }


        $recordsTotal = $this->model_extension_catalog_pro_product->getTotalProducts($filter_data);
        $recordsFiltered = $recordsTotal;

        $data = array();
        foreach($this->model_extension_catalog_pro_product->getProducts($filter_data) as $row) {
            $temp = array();

            foreach ($config['columns'] as $field => $value)
                if ($value['visible'] == 1)
                    if ($field == "image") {
                        if (is_file(DIR_IMAGE . $row[$field]))
                            $temp[$field] = $this->model_tool_image->resize($row[$field], 40, 40);
                        else
                            $temp[$field] = $this->model_tool_image->resize('no_image.png', 40, 40);

                        $temp[$field] = "<img src=\"{$temp[$field]}\" />";
                    }
                    else if ($field == "status")
                        $temp[$field] = '<button class="btn btn-xs btn-'.($row[$field] == 1? "success": "danger").' product-active" title="'.($row[$field] == 1? $this->language->get('status_no'): $this->language->get('status_yes')).'"><i class="fa fa-power-off" aria-hidden="true"></i></button>';
                    else if ($field == "price") {
                        if (isset($row['specials']))
                            $temp[$field] = "<del class=\"text-danger\">{$row[$field]}</del><br/>".$row['specials'][0]['price'];
                        else
                            $temp[$field] = $row[$field];
                    }
                    else if ($field == "category") {
                        $cTemp = array();

                        if (isset($row['categories']))
                            foreach ($row['categories'] as $c) {
                                $cTemp[] = '<span class="label label-info">'.$deTree[$c]['join_name'].'</span>';
                            }

                        $temp[$field] = implode(" ", $cTemp);
                    }
                    else if ($field == "quantity") {
                        if ($row[$field] == 0)
                            $temp[$field] = "<span class=\"label label-danger\">{$row[$field]}</span>";
                        elseif ($row[$field] < 5)
                            $temp[$field] = "<span class=\"label label-warning\">{$row[$field]}</span>";
                        elseif ($row[$field] < 20)
                            $temp[$field] = "<span class=\"label label-info\">{$row[$field]}</span>";
                        else
                            $temp[$field] = "<span class=\"label label-success\">{$row[$field]}</span>";
                    }
                    else if ($field == "actions") {
                        $temp[$field] = '<button class="btn btn-primary btn-xs show-actions data-placement="auto-bottom" data-content="'.htmlspecialchars($this->load->view('extension/module/catalog_pro/action_buttons', array(
                                "product_id" => $row['product_id'],
                                "lang" => $this->language->get('action_buttons'),
                            ))).'" type="button"><i class="fa fa-cog" aria-hidden="true"></i></button>';
                    }
                    else
                        $temp[$field] = isset($row[$field])? $row[$field]: "";

            $temp['DT_RowId'] = $row['product_id'];
            $data[] = $temp;
            unset($temp);
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode([
            "data" => $data,
            "draw" => time(),
            "recordsFiltered" => $recordsFiltered,
            "recordsTotal" => $recordsTotal,
        ]));
    }

    private function returnError($title, $message) {
        $this->response->addHeader('HTTP/1.0 422 Unprocessable Entity');
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode([
            "title" => $title,
            "message" => is_array($message)? "<ul>".implode("", array_map(function ($line) { return "<li>{$line}</li>"; }, $message))."</ul>": $message,
        ]));
    }

    public function save() {
        $this->loadLanguage();
        $this->load->model('extension/catalog_pro/product');
        $this->load->model('localisation/language');

        $eLang = $this->language->get('edit');
        $eValidation = $this->language->get('validate');

        $post = $this->request->post['data'];
        $languages = $this->model_localisation_language->getLanguages(array());

        if (!isset($post['action']) || !in_array($post['action'], array('name', 'model', 'sku', 'quantity', 'price', 'image', 'category'))) {
            $this->returnError($eValidation['title'], $eValidation['action']);
            return;
        }


        $item = $this->model_extension_catalog_pro_product->getProduct($post['id']);
        if ($item === array()) {
            $this->returnError($eValidation['title'], $eValidation['id']);
            return;
        }

        switch ($post['action']) {
            case 'name':
                $languages = $this->model_localisation_language->getLanguages(array());

                $errors = array();

                foreach ($languages as $language) {
                    if (!isset($post[$post['action'].".".$language['language_id']])) {
                        $this->returnError($eValidation['title'], $eValidation['action']);
                        return;
                    }

                    $validator = Validation::createValidator();
                    $violations = $validator->validate($post[$post['action'].".".$language['language_id']], array(
                        new Length([
                            'min' => 2,
                            'max' => 255,
                            'minMessage' => $eValidation['name.min'],
                            'maxMessage' => $eValidation['name.max'],
                        ]),
                        new NotBlank([
                            'message' => $eValidation['name.required']
                        ]),
                    ));

                    if (0 !== count($violations)) {
                        // there are errors, now you can show them
                        foreach ($violations as $violation) {
                            $errors[] = $violation->getMessage();
                        }
                    }
                }

                if ($errors !== array()) {
                    $this->returnError($eValidation['title'], $errors);
                    return;
                }

                foreach ($languages as $language) {
                    $this->model_extension_catalog_pro_product->saveProductDescriptions($post['id'], $language['language_id'], array('name' => $post[$post['action'].".".$language['language_id']]));
                }

                break;
            case 'model':
                $errors = array();


                $validator = Validation::createValidator();
                $violations = $validator->validate($post['model'], array(
                    new Length([
                        'min' => 1,
                        'max' => 255,
                        'minMessage' => $eValidation['model.min'],
                        'maxMessage' => $eValidation['model.max'],
                    ]),
                    new NotBlank([
                        'message' => $eValidation['model.required']
                    ]),
                ));

                if (0 !== count($violations)) {
                    // there are errors, now you can show them
                    foreach ($violations as $violation) {
                        $errors[] = $violation->getMessage();
                    }
                }

                if ($errors !== array()) {
                    $this->returnError($eValidation['title'], $errors);
                    return;
                }

                $this->model_extension_catalog_pro_product->saveProduct($post['id'], array("model" => $post['model']));

                break;
            case 'sku':
                $errors = array();


                $validator = Validation::createValidator();
                $violations = $validator->validate($post['sku'], array(
                    new Length([
                        'max' => 64,
                        'maxMessage' => $eValidation['sku.max'],
                    ])
                ));

                if (0 !== count($violations)) {
                    foreach ($violations as $violation) {
                        $errors[] = $violation->getMessage();
                    }
                }

                if ($errors !== array()) {
                    $this->returnError($eValidation['title'], $errors);
                    return;
                }

                $this->model_extension_catalog_pro_product->saveProduct($post['id'],  array("sku" => $post['sku']));

                break;
            case 'quantity':
                $errors = array();

                $validator = Validation::createValidator();
                $violations = $validator->validate($post['quantity'], array(
                    new Range([
                        'min' => 0,
                        'minMessage' => $eValidation['quantity.min'],
                        'invalidMessage' => $eValidation['quantity.invalid'],
                    ]),
                    new NotBlank([
                        'message' => $eValidation['quantity.required']
                    ]),
                ));

                if (0 !== count($violations)) {
                    foreach ($violations as $violation) {
                        $errors[] = $violation->getMessage();
                    }
                }

                if ($errors !== array()) {
                    $this->returnError($eValidation['title'], $errors);
                    return;
                }

                $this->model_extension_catalog_pro_product->saveProduct($post['id'],  array("quantity" => $post['quantity']));

                break;

            case 'price':
                $errors = array();

                $validator = Validation::createValidator();
                $violations = $validator->validate($post['price'], array(
                    new Range([
                        'min' => 0,
                        'minMessage' => $eValidation['price.min'],
                        'invalidMessage' => $eValidation['price.invalid'],
                    ]),
                    new NotBlank([
                        'message' => $eValidation['price.required']
                    ]),
                ));

                if (0 !== count($violations)) {
                    foreach ($violations as $violation) {
                        $errors[] = $violation->getMessage();
                    }
                }

                $specials = array();
                $regular = '/(\w+)\.(\d+)\.(\w+)/m';
                foreach ($post as $field => $value) {
                    if (strpos($field, "special.") !== false) {
                        preg_match_all($regular, $field, $matches, PREG_SET_ORDER, 0);
                        $specials[$matches[0][2]][$matches[0][3]] = $value;
                    }
                }

                if ($specials !== array() && count($specials) == 1) {
                    $tempKey = array_keys($specials);
                    $tempKey = $tempKey[0];

                    $temp = $specials[$tempKey];
                    unset($temp['customer_group_id']);
                    try {
                        foreach ($temp as $t)
                            if ($t != "")
                                throw new Exception('');

                        unset($specials[$tempKey]);
                    }
                    catch (Exception $exception) {

                    }
                }

                foreach ($specials as $special) {
                    // price
                    $violations = $validator->validate($special['price'], array(
                        new Range([
                            'min' => 0.01,
                            'minMessage' => $eValidation['price.min'],
                            'invalidMessage' => $eValidation['price.invalid'],
                        ]),
                        new NotBlank([
                            'message' => $eValidation['price.required']
                        ]),
                    ));

                    if (0 !== count($violations)) {
                        foreach ($violations as $violation) {
                            $errors[] = $violation->getMessage();
                        }
                    }

                    // date_start
                    if ($special['date_start'] != "") {
                        $violations = $validator->validate($special['date_start'], array(
                            new Date([
                                'message' => $eValidation['date_start.invalid'],
                            ])
                        ));

                        if (0 !== count($violations)) {
                            foreach ($violations as $violation) {
                                $errors[] = $violation->getMessage();
                            }
                        }

                        if ($special['date_end'] != "") {
                            $violations = $validator->validate(new DateTime($special['date_start']), array(
                                new Assert\Range([
                                    'max' => new DateTime($special['date_end']),
                                    'maxMessage' => $eValidation['date_start.max'],
                                    'invalidMessage' => $eValidation['date_start.invalid'],
                                ])
                            ));

                            if (0 !== count($violations)) {
                                foreach ($violations as $violation) {
                                    $errors[] = $violation->getMessage();
                                }
                            }
                        }
                    }

                    if ($special['date_end'] != "") {
                        $violations = $validator->validate($special['date_end'], array(
                            new Date([
                                'message' => $eValidation['date_start.invalid'],
                            ])
                        ));

                        if (0 !== count($violations)) {
                            foreach ($violations as $violation) {
                                $errors[] = $violation->getMessage();
                            }
                        }

                        if ($special['date_start'] != "") {
                            $violations = $validator->validate(new DateTime($special['date_end']), array(
                                new Assert\Range([
                                    'min' => new DateTime($special['date_start']),
                                    'minMessage' => $eValidation['date_end.min'],
                                    'invalidMessage' => $eValidation['date_end.invalid'],
                                ])
                            ));

                            if (0 !== count($violations)) {
                                foreach ($violations as $violation) {
                                    $errors[] = $violation->getMessage();
                                }
                            }
                        }

                    }
                }

                if ($errors !== array()) {
                    $this->returnError($eValidation['title'], $errors);
                    return;
                }


                $this->model_extension_catalog_pro_product->saveProductSpecial($post['id'],  $specials);

                break;


            case 'image':
                $errors = array();

                $images = array();
                $regular = '/(\w+)\.(\d+)\.(\w+)/m';
                foreach ($post as $field => $value) {
                    if (strpos($field, "image.") !== false) {
                        preg_match_all($regular, $field, $matches, PREG_SET_ORDER, 0);
                        $images[$matches[0][2]][$matches[0][3]] = $value;
                    }
                }

                if ($images !== array() && count($images) == 1) {
                    $tempKey = array_keys($images);
                    $tempKey = $tempKey[0];

                    $temp = $images[$tempKey];
                    try {
                        foreach ($temp as $t)
                            if ($t != "")
                                throw new Exception('');

                        unset($images[$tempKey]);
                    }
                    catch (Exception $exception) {

                    }
                }

                $mainImage = $images[0]['image'];
                unset($images[0]);

                $this->model_extension_catalog_pro_product->saveProductImage($post['id'], $mainImage, $images);

                break;

            case 'category':
                $this->model_extension_catalog_pro_product->saveProductCategory($post['id'], $post['category']);

                break;
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode([
            "title" => $this->language->get('text_success_save_title'),
            "message" => $this->language->get('text_success_save')
        ]));
    }

    public function active() {
        $this->loadLanguage();
        $this->load->model('extension/catalog_pro/product');

        $id = $this->request->post['id'];
        $eValidation = $this->language->get('validate');

        $item = $this->model_extension_catalog_pro_product->getProduct($id);
        if ($item === array()) {
            $this->returnError($eValidation['title'], $eValidation['id']);
            return;
        }

        $this->model_extension_catalog_pro_product->saveProductInvertStatus($id);

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode([
            "title" => $this->language->get('text_success_save_title'),
            "message" => $this->language->get('text_success_save')
        ]));
    }

    public function edit() {
        $this->loadLanguage();
        $this->load->model('extension/catalog_pro/product');
        $this->load->model('localisation/language');

        $eLang = $this->language->get('edit');

        $item = $this->model_extension_catalog_pro_product->getProduct($this->request->post['id']);

	    $title = "";
	    $content = "";
	    $width = 250;

	    switch ($this->request->post['action']) {
            case 'name':
                $title = $eLang['title']['name'];
                $content = $this->editName($eLang, $item);
                $width = 400;
                break;
            case 'model':
                $title = $eLang['title']['model'];
                $content = $this->editModel($eLang, $item);
                $width = 400;
                break;
            case 'sku':
                $title = $eLang['title']['sku'];
                $content = $this->editSku($eLang, $item);
                $width = 400;
                break;
            case 'price':
                $title = $eLang['title']['price'];
                $content = $this->editPrice($eLang, $item);
                $width = 700;
                break;
            case 'quantity':
                $title = $eLang['title']['quantity'];
                $content = $this->editQuantity($eLang, $item);
                $width = 400;
                break;
            case 'image':
                $title = $eLang['title']['image'];
                $content = $this->editImage($eLang, $item);
                $width = 500;
                break;
            case 'category':
                $title = $eLang['title']['category'];
                $content = $this->editCategory($eLang, $item);
                $width = 400;
                break;
        }


        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode([
            "title" => $title,
            "content" => $content,
            "width" => $width,
        ]));
    }

    private function editButtons($eLang) {
        $content = "<div class=\"pull-right\">";
        $content .= "<button class=\"btn btn-danger btn-xs popover-hide\" type=\"button\">".$eLang['buttons']['cancel']."</button>&nbsp;";
        $content .= "<button class=\"btn btn-success btn-xs edit-save\" type=\"button\">".$eLang['buttons']['save']."</button>";
        $content .= "</div>";

        return $content;
    }

    private function editName($eLang, $item) {
        $content = "<form>";

        $languages = $this->model_localisation_language->getLanguages(array());

        $names = $this->model_extension_catalog_pro_product->getProductDescriptions($item['product_id']);

        foreach ($languages as $language) {
            $content .= '<div class="input-group">
                          <span class="input-group-addon"><img src="language/'.$language['code'].'/'.$language['code'].'.png" title="'.$language['name'].'"/></span>
                          <input type="text" class="form-control" name="name.'.$language['language_id'].'" value="'.$names[$language['language_id']]['name'].'">
                        </div>';
        }

        $content .= $this->editButtons($eLang);
        $content .= '<input type="hidden" name="action" value="name" />';
        $content .= '<input type="hidden" name="id" value="'.$item['product_id'].'" />';
        $content .= "</form>";


        return $content;
    }

    private function editModel($eLang, $item) {
        $content = "<form>";

        $content .= '<div class="form-group"><input type="text" class="form-control" name="model" value="'.$item['model'].'"></div>';

        $content .= $this->editButtons($eLang);
        $content .= '<input type="hidden" name="action" value="model" />';
        $content .= '<input type="hidden" name="id" value="'.$item['product_id'].'" />';
        $content .= "</form>";

        return $content;
    }

    private function editSku($eLang, $item) {
        $content = "<form>";

        $content .= '<div class="form-group"><input type="text" class="form-control" name="sku" value="'.$item['sku'].'"></div>';

        $content .= $this->editButtons($eLang);
        $content .= '<input type="hidden" name="action" value="sku" />';
        $content .= '<input type="hidden" name="id" value="'.$item['product_id'].'" />';
        $content .= "</form>";

        return $content;
    }

    private function editPriceAddSpecial($customers, $special) {
        $content = '<li class="special">
                <div class="row">
                    <div class="col-xs-4"><i class="fa fa-arrows sortable pull-left" aria-hidden="true"></i><select name="special.'.$special['product_special_id'].'.customer_group_id" class="form-control input-sm">';
        foreach ($customers as $customer)
            $content .= '<option value="'.$customer['customer_group_id'].'" '.($customer['customer_group_id'] == $special['customer_group_id']? "SELECTED": "").'>'.$customer['name'].'</option>';
        $content .= '</select></div>
                     <div class="col-xs-2"><input type="text" class="form-control input-sm" name="special.'.$special['product_special_id'].'.price" value="'.$special['price'].'" /></div>
                     <div class="col-xs-3">
                         <div class="input-group date">
                            <input type="text" name="special.'.$special['product_special_id'].'.date_start" data-date-format="YYYY-MM-DD" class="form-control input-sm" value="'.($special['date_start'] != "0000-00-00"? $special['date_start']: "").'" />
                            <span class="input-group-btn">
                            <button class="btn btn-default btn-sm" type="button"><i class="fa fa-calendar"></i></button>
                            </span>
                        </div>
                     </div>
                     <div class="col-xs-3">
                        <div class="input-group date">
                            <input type="text" name="special.'.$special['product_special_id'].'.date_end" data-date-format="YYYY-MM-DD" class="form-control input-sm" value="'.($special['date_end'] != "0000-00-00"? $special['date_end']: "").'" />
                            <span class="input-group-btn">
                            <button class="btn btn-default btn-sm" type="button"><i class="fa fa-calendar"></i></button>
                            </span>
                        </div>
                     </div>
                </div>
            </div>';

        return $content;
    }

    private function editPrice($eLang, $item) {
        $this->load->model('customer/customer_group');

        $customers = $this->model_customer_customer_group->getCustomerGroups();

        $content = "<form>";

        $content .= '<div class="form-group" style="padding: 0"><label>'.$eLang['price']['current'].'</label><input type="text" class="form-control" name="price" value="'.$item['price'].'"></div>';
        $content .= '<hr/>';

        $content .= '<div class="pull-right"><button type="button" class="btn btn-xs btn-success special-add">'.$eLang['price']['special_add'].'</button></div>';
        $content .= '<label>'.$eLang['price']['specials'].'</label>';

        $content .= '<ul id="specials">';
        if ($item['specials'] !== array()) {
            foreach ($item['specials'] as $special) {
                $content .= $this->editPriceAddSpecial($customers, $special);
            }
        }
        else
            $content .= $this->editPriceAddSpecial($customers, array(
                "product_special_id" => time().mt_rand(1000, 9999),
                "customer_group_id" => "",
                "priority" => "",
                "price" => "",
                "date_start" => "",
                "date_end" => "",
            ));
        $content .= '</ul>';

        $content .= $this->editButtons($eLang);
        $content .= '<input type="hidden" name="action" value="price" />';
        $content .= '<input type="hidden" name="id" value="'.$item['product_id'].'" />';
        $content .= "</form>";

        return $content;
    }

    private function editQuantity($eLang, $item) {
        $content = "<form>";

        $content .= '<div class="form-group"><input type="text" class="form-control" name="quantity" value="'.$item['quantity'].'"></div>';

        $content .= $this->editButtons($eLang);
        $content .= '<input type="hidden" name="action" value="quantity" />';
        $content .= '<input type="hidden" name="id" value="'.$item['product_id'].'" />';
        $content .= "</form>";

        return $content;
    }

    private function editImageAddImage($eLang, $image) {
        if (is_file(DIR_IMAGE . $image['image']))
            $imageHtml = $this->model_tool_image->resize($image['image'], 60, 60);
        else
            $imageHtml = $this->model_tool_image->resize('no_image.png', 60, 60);

        $imageHtml = "<div id=\"image{$image['product_image_id']}\">
                <img data=\"{$image['product_image_id']}\" src=\"{$imageHtml}\" class=\"update-image\" />
                <input type=\"hidden\" name=\"image.{$image['product_image_id']}.image\" value=\"{$image['image']}\" id=\"image-{$image['product_image_id']}-image\" />
            </div>";

        $content = '<div class="col-xs-3 image">
                <div class="panel panel-default">
                    <div class="panel-body">
                        '.$imageHtml.'
                    </div>
                    <div class="panel-footer">
                        <button type="button" class="btn btn-danger btn-xs image-remove btn-block"><i class="fa fa-trash-o" aria-hidden="true"></i> '.$eLang['buttons']['remove'].'</button>
                    </div>
                </div>
            </div>';

        return $content;
    }

    private function editImage($eLang, $item) {
        $this->load->model('tool/image');

        $content = "<form>";

        if (is_file(DIR_IMAGE . $item['image']))
            $image = $this->model_tool_image->resize($item['image'], 100, 100);
        else
            $image = $this->model_tool_image->resize('no_image.png', 100, 100);

        $image = "<div id=\"image0\">
                <img data=\"0\" src=\"{$image}\" class=\"update-image\" />
                <input type=\"hidden\" name=\"image.0.image\" value=\"{$item['image']}\" id=\"image-{$item['product_id']}-image\" />
            </div>";

        $content .= '<div class="form-group" style="padding: 0">'.$image.'</div>';
        $content .= '<hr/>';

        $content .= '<div class="pull-right"><button type="button" class="btn btn-xs btn-success image-add">'.$eLang['image']['image_add'].'</button></div>';
        $content .= '<label>'.$eLang['image']['additional'].'</label>';

        $content .= '<div id="images" class="row">';
        if ($item['images'] !== array()) {
            foreach ($item['images'] as $image) {
                $content .= $this->editImageAddImage($eLang, $image);
            }
        }

        $content .= '</div>';

        $content .= '<div class="alert alert-warning">'.$this->language->get('text_image_note').'</div>';

        $content .= $this->editButtons($eLang);
        $content .= '<input type="hidden" name="action" value="image" />';
        $content .= '<input type="hidden" name="id" value="'.$item['product_id'].'" />';
        $content .= "</form>";

        return $content;
    }

    private function editCategory($eLang, $item) {
        $this->load->model('extension/catalog_pro/category');

        $content = "<form>";

        $content .= '<ul id="listCategoryEdit" class="ztree"></ul>';

        $content .= '<script>
            var settingEdit = {check: {enable: true,chkboxType: { "Y" : "", "N" : "" }},view: {dblClickExpand: false},data: {simpleData: {enable: true}}};';

        $content .= 'var zCategoriesEditNodes =['."\n";
        foreach ($this->model_extension_catalog_pro_category->getCategories() as $category)
            $content .= '{id:'.$category['category_id'].', pId:'.$category['parent_id'].', name:"'.$category['name'].'", checked: '.(in_array($category['category_id'], $item['categories']) !== false? "true": "false").'},'."\n";
        $content .= "];\n";


        $content .= 'var categoryEditTree = $.fn.zTree.init($("#listCategoryEdit"), settingEdit, zCategoriesEditNodes);';

        $content .= '</script>';

        $content .= $this->editButtons($eLang);
        $content .= '<input type="hidden" name="action" value="category" />';
        $content .= '<input type="hidden" name="id" value="'.$item['product_id'].'" />';
        $content .= "</form>";

        return $content;
    }



    public function editData() {
        $this->loadLanguage();
        $this->load->model('extension/catalog_pro/product');
        $this->load->model('localisation/language');

        $eModal = $this->language->get('modal');

        $item = $this->model_extension_catalog_pro_product->getProduct($this->request->post['id']);

        $title = "";
        $content = "";

        switch ($this->request->post['action']) {
            case 'main':
                $title = $eModal['title']['main'];
                $content = $this->editDataMain($eModal, $item);
                break;
            case 'data':
                $title = $eModal['title']['data'];
                $content = $this->editDataData($eModal, $item);
                break;
            default:
                $eValidation = $this->language->get('validate');
                return $this->returnError($eValidation['title'], $eValidation['action']);
                return;
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode([
            "title" => $title,
            "content" => $content
        ]));
    }

    private function editDataMain($eModal, $item) {
        $languages = $this->model_localisation_language->getLanguages(array());

        $names = $this->model_extension_catalog_pro_product->getProductDescriptions($item['product_id']);

        return $this->load->view(
            'extension/module/catalog_pro/edit_product/block_general',
            array(
                "languages" => $languages,
                "names" => $names,
                "modal" => $eModal,
            )
        );
    }

    private function editDataData($eModal, $item) {
        $this->load->model('localisation/tax_class');
        $this->load->model('localisation/stock_status');
        $this->load->model('localisation/length_class');
        $this->load->model('localisation/weight_class');

        return $this->load->view(
            'extension/module/catalog_pro/edit_product/block_data',
            array(
                "modal" => $eModal,
                "item" => $item,
                'dict' => array (
                    'tax' => $this->model_localisation_tax_class->getTaxClasses(),
                    'subtract' => array (
                        array("value" => 0, "title" => $eModal['text']['no']),
                        array("value" => 1, "title" => $eModal['text']['yes']),
                    ),
                    'shipping' => array (
                        array("value" => 0, "title" => $eModal['text']['no']),
                        array("value" => 1, "title" => $eModal['text']['yes']),
                    ),
                    'stock_status' => $this->model_localisation_stock_status->getStockStatuses(),
                    'length_class' => $this->model_localisation_length_class->getLengthClasses(),
                    'weight_class' => $this->model_localisation_weight_class->getWeightClasses(),
                    'status' => array (
                        array("value" => 0, "title" => $eModal['text']['status_no']),
                        array("value" => 1, "title" => $eModal['text']['status_yes']),
                    ),
                ),
            )
        );
    }


    public function saveData() {
        $this->loadLanguage();
        $this->load->model('extension/catalog_pro/product');
        $this->load->model('localisation/language');

        $eLang = $this->language->get('edit');
        $eValidation = $this->language->get('validate');

        $post = $this->request->post['data'];
        $action = $this->request->post['action'];
        $id = $this->request->post['id'];
        $languages = $this->model_localisation_language->getLanguages(array());

        if (!in_array($action, array('main', 'data'))) {
            $this->returnError($eValidation['title'], $eValidation['action']);
            return;
        }

        $item = $this->model_extension_catalog_pro_product->getProduct($id);
        if ($item === array()) {
            $this->returnError($eValidation['title'], $eValidation['id']);
            return;
        }

        switch ($action) {
            case 'main':
                $languages = $this->model_localisation_language->getLanguages(array());

                $errors = array();

                $fields = array();
                $regular = '/(\w+)\.(\d+)/m';
                foreach ($post as $field => $value) {
                    preg_match_all($regular, $field, $matches, PREG_SET_ORDER, 0);
                    $fields[$matches[0][2]][$matches[0][1]] = $value;
                }

                $validator = Validation::createValidator();
                $groups = new Assert\GroupSequence(['Default']);

                foreach ($languages as $language) {
                    $prefix = "[{$language['name']}] ";

                    $constraint = new Assert\Collection([
                        "name" => array(
                            new Assert\Length([
                                'min' => 2,
                                'max' => 255,
                                'minMessage' => $prefix.$eValidation['name.min'],
                                'maxMessage' => $prefix.$eValidation['name.max'],
                            ]),
                            new Assert\NotBlank([
                                'message' => $prefix.$eValidation['name.required']
                            ]),
                        ),
                        "description" => array(
                            new Assert\Type(['type' => 'string'])
                        ),
                        "meta_title" => array(
                            new Assert\Length([
                                'min' => 2,
                                'max' => 255,
                                'minMessage' => $prefix.$eValidation['meta_title.min'],
                                'maxMessage' => $prefix.$eValidation['meta_title.max'],
                            ]),
                            new Assert\NotBlank([
                                'message' => $prefix.$eValidation['meta_title.required']
                            ]),
                        ),
                        "meta_description" => array(
                            new Assert\Length([
                                'max' => 255,
                                'maxMessage' => $prefix.$eValidation['meta_description.max'],
                            ]),
                        ),
                        "meta_keyword" => array(
                            new Assert\Length([
                                'max' => 255,
                                'maxMessage' => $prefix.$eValidation['meta_keyword.max'],
                            ]),
                        ),
                        "tag" => array(
                            new Assert\Type(['type' => 'string'])
                        ),
                    ]);


                    $violations = $validator->validate($fields[$language['language_id']], $constraint);

                    if (0 !== count($violations)) {
                        // there are errors, now you can show them
                        foreach ($violations as $violation) {
                            $errors[] = $violation->getMessage();
                        }
                    }
                }

                if ($errors !== array()) {
                    $this->returnError($eValidation['title'], $errors);
                    return;
                }

                foreach ($languages as $language) {
                    $this->model_extension_catalog_pro_product->saveProductDescriptions($id, $language['language_id'], $fields[$language['language_id']]);
                }

                break;

            case 'data':
                $this->load->model('localisation/tax_class');
                $this->load->model('localisation/stock_status');
                $this->load->model('localisation/length_class');
                $this->load->model('localisation/weight_class');

                $errors = array();
                $dict = array ();
                foreach ($this->model_localisation_tax_class->getTaxClasses() as $d)
                    $dict['tax'][] = $d['tax_class_id'];
                $dict['subtract'] = [0, 1];
                $dict['shipping'] = [0, 1];
                foreach ($this->model_localisation_stock_status->getStockStatuses() as $d)
                    $dict['stock_status'][] = $d['stock_status_id'];
                foreach ($this->model_localisation_length_class->getLengthClasses() as $d)
                    $dict['length_class'][] = $d['length_class_id'];
                foreach ($this->model_localisation_weight_class->getWeightClasses() as $d)
                    $dict['weight_class'][] = $d['weight_class_id'];
                $dict['status'] = [0, 1];


                $validator = Validation::createValidator();

                $constraint = new Assert\Collection([
                    "model" => array(
                        new Assert\Length([
                            'max' => 64,
                            'maxMessage' => $eValidation['model.max'],
                        ]),
                        new Assert\NotBlank([
                            'message' => $eValidation['model.required']
                        ]),
                    ),
                    "sku" => array(
                        new Length([
                            'max' => 64,
                            'maxMessage' => $eValidation['sku.max'],
                        ])
                    ),
                    "upc" => array(
                        new Length([
                            'max' => 12,
                            'maxMessage' => $eValidation['upc.max'],
                        ])
                    ),
                    "ean" => array(
                        new Length([
                            'max' => 14,
                            'maxMessage' => $eValidation['ean.max'],
                        ])
                    ),
                    "jan" => array(
                        new Length([
                            'max' => 13,
                            'maxMessage' => $eValidation['jan.max'],
                        ])
                    ),
                    "isbn" => array(
                        new Length([
                            'max' => 17,
                            'maxMessage' => $eValidation['isbn.max'],
                        ])
                    ),
                    "mpn" => array(
                        new Length([
                            'max' => 64,
                            'maxMessage' => $eValidation['mpn.max'],
                        ])
                    ),
                    "location" => array(
                        new Length([
                            'max' => 128,
                            'maxMessage' => $eValidation['location.max'],
                        ])
                    ),
                    "price" => array (
                        new Range([
                            'min' => 0,
                            'minMessage' => $eValidation['price.min'],
                            'invalidMessage' => $eValidation['price.invalid'],
                        ]),
                        new NotBlank([
                            'message' => $eValidation['price.required']
                        ]),
                    ),
                    "tax_class_id" => array (
                        new Assert\Choice([
                            'choices' => $dict['tax'],
                            'message' => $eValidation['tax_class_id.in']
                        ]),
                    ),
                    "quantity" => array(
                        new Range([
                            'min' => 0,
                            'minMessage' => $eValidation['quantity.min'],
                            'invalidMessage' => $eValidation['quantity.invalid'],
                        ]),
                        new NotBlank([
                            'message' => $eValidation['quantity.required']
                        ]),
                    ),
                    "subtract" => array (
                        new Assert\Choice([
                            'choices' => $dict['subtract'],
                            'message' => $eValidation['tax_class_id.in']
                        ]),
                    ),
                    "minimum" => array(
                        new Range([
                            'min' => 1,
                            'minMessage' => $eValidation['minimum.min'],
                            'invalidMessage' => $eValidation['minimum.invalid'],
                        ]),
                        new NotBlank([
                            'message' => $eValidation['minimum.required']
                        ]),
                    ),
                    "stock_status_id" => array (
                        new Assert\Choice([
                            'choices' => $dict['stock_status'],
                            'message' => $eValidation['stock_status_id.in']
                        ]),
                    ),
                    "shipping" => array (
                        new Assert\Choice([
                            'choices' => $dict['shipping'],
                            'message' => $eValidation['shipping.in']
                        ]),
                    ),
                    "date_available" => array(
                        new Date([
                            'message' => $eValidation['date_available.invalid'],
                        ])
                    ),
                    "length" => array(
                        new Range([
                            'min' => 0,
                            'minMessage' => $eValidation['length.min'],
                            'invalidMessage' => $eValidation['length.invalid'],
                        ])
                    ),
                    "width" => array(
                        new Range([
                            'min' => 0,
                            'minMessage' => $eValidation['width.min'],
                            'invalidMessage' => $eValidation['width.invalid'],
                        ])
                    ),
                    "height" => array(
                        new Range([
                            'min' => 0,
                            'minMessage' => $eValidation['height.min'],
                            'invalidMessage' => $eValidation['height.invalid'],
                        ])
                    ),
                    "length_class_id" => array (
                        new Assert\Choice([
                            'choices' => $dict['length_class'],
                            'message' => $eValidation['length_class_id.in']
                        ]),
                    ),
                    "weight" => array(
                        new Range([
                            'min' => 0,
                            'minMessage' => $eValidation['weight.min'],
                            'invalidMessage' => $eValidation['weight.invalid'],
                        ])
                    ),
                    "weight_class_id" => array (
                        new Assert\Choice([
                            'choices' => $dict['weight_class'],
                            'message' => $eValidation['weight_class_id.in']
                        ]),
                    ),
                    "status" => array (
                        new Assert\Choice([
                            'choices' => $dict['status'],
                            'message' => $eValidation['status.in']
                        ]),
                    ),
                    "sort_order" => array (
                        new Range([
                            'min' => 0,
                            'minMessage' => $eValidation['sort_order.min'],
                            'invalidMessage' => $eValidation['sort_order.invalid'],
                        ])
                    ),
                ]);


                $violations = $validator->validate($post, $constraint);

                if (0 !== count($violations)) {
                    // there are errors, now you can show them
                    foreach ($violations as $violation) {
                        $errors[] = $violation->getMessage();
                    }
                }


                if ($errors !== array()) {
                    $this->returnError($eValidation['title'], $errors);
                    return;
                }

                $this->model_extension_catalog_pro_product->saveProduct($id, $post);

                break;

        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode([
            "title" => $this->language->get('text_success_save_title'),
            "message" => $this->language->get('text_success_save')
        ]));
    }
}
