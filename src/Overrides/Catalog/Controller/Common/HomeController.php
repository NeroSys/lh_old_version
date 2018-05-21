<?php

namespace App\Overrides\Catalog\Controller\Common;

class HomeController extends \Controller
{
    public function index()
    {
        $this->load->model('design/banner');
        $this->load->model('tool/image');

        $this->document->setTitle($this->config->get('config_meta_title'));
        $this->document->setDescription($this->config->get('config_meta_description'));
        $this->document->setKeywords($this->config->get('config_meta_keyword'));

        if (isset($this->request->get['route'])) {
            $this->document->addLink(HTTP_SERVER, 'canonical');
        }

        $data['banners'] = array();
        $data['banners_in_top'] = $this->model_design_banner->getBanner(9);

        foreach ($data['banners_in_top'] as $key => $result) {
            $data['banners_in_top'][$key]['image'] = $this->model_tool_image->resize($result['image'], 360, 264);
        }

        $data['premium_slider_in_top'] = $this->model_design_banner->getBanner(10);
        foreach ($data['premium_slider_in_top'] as $key => $result) {
            $data['premium_slider_in_top'][$key]['image'] = $this->model_tool_image->resize($result['image'], 770, 572);
        }
        $this->document->addScript('/catalog/view/theme/tt_auriga/javascript/opentheme/ocslideshow/jquery.nivo.slider.js');
        $this->document->addStyle('/catalog/view/theme/tt_auriga/stylesheet/opentheme/ocslideshow/ocslideshow.css');

        $data['information'] = $this->getLastNews();

        $data['column_left'] = $this->load->controller('common/column_left');
        $data['column_right'] = $this->load->controller('common/column_right');
        $data['content_top'] = $this->load->controller('common/content_top');
        $data['content_bottom'] = $this->load->controller('common/content_bottom');
        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');

        $this->response->setOutput($this->load->view('common/home', $data));

    }

    private function getLastNews()
    {
        $this->load->model('newsblog/article');
        $info_list = $this->model_newsblog_article->getArticles($data = array('order' => 'DESC', 'filter_category_id' => 4, 'start' => 0, 'limit' => 3, 'sort' => 'date_added'));

        foreach ($info_list as $key => $info) {
            if ($info['image']) {
                $image = $this->model_tool_image->resize($info['image'], 400, 187);
            } else {
                $image = $this->model_tool_image->resize('placeholder.png', 400, 187);
            }
            $articles[] = array(
                'article_id' => $info['article_id'],
                'date' => date($this->language->get('date_format_short'), strtotime($info['date_available'])),
                'thumb' => $image,
                'name' => $info['name'],
                'preview' => html_entity_decode($info['preview'], ENT_QUOTES, 'UTF-8'),
                'attributes' => $info['attributes'],
                'href' => $this->url->link('newsblog/article', 'newsblog_path=' . $data['filter_category_id'] . '&newsblog_article_id=' . $info['article_id'], true)
            );
        }
        return $articles;
    }
}
