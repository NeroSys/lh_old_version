<?php

class ControllerInformationShops extends Controller {

    public function index() {
 
        $category_id = 3;  //магазины
        $this->load->model('newsblog/category');
        $this->load->model('newsblog/article');

        $category_info = $this->model_newsblog_category->getCategory($category_id);
        $data['category_info'] = $category_info;
       
        $this->document->setTitle($category_info['meta_title']);
        $this->document->setDescription($category_info['meta_description']);
  
        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home')
        );

        $data['breadcrumbs'][] = array(
            'text' => $category_info['name'],
            'href' => $this->url->link('information/shop')
        );

        $data['heading_title'] = $category_info['name'];




        $data['column_left'] = $this->load->controller('common/column_left');
        $data['column_right'] = $this->load->controller('common/column_right');
        $data['content_top'] = $this->load->controller('common/content_top');
        $data['content_bottom'] = $this->load->controller('common/content_bottom');
        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');

        $data['shops'] = [];

        $filter_data = array(
            'filter_category_id' => $category_id,
        );

        $results = $this->model_newsblog_article->getArticles($filter_data);

        foreach ($results as $shop) {
            $data['shops'][$shop['name']] = [
                'title' => $shop['name'],
                'image' => $this->model_tool_image->imageLocation($shop['image']),
                'thumb' => $this->model_tool_image->resize($shop['image'], 263, 197),
                'preview' => html_entity_decode($shop['preview'], ENT_QUOTES, 'UTF-8'),
            ];
        }

        $this->response->setOutput($this->load->view('information/shop', $data));
    }

}
