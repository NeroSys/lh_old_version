<?php
class ControllerInformationContact extends Controller {
    private $error = array();

    public function index() {
        $this->load->language('information/contact');

        $this->document->setTitle('Адрес и контакты компании Little-House');

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('information/contact')
        );

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_location'] = $this->language->get('text_location');
        $data['text_store'] = $this->language->get('text_store');
        $data['text_contact'] = $this->language->get('text_contact');
        $data['text_address'] = $this->language->get('text_address');
        $data['text_telephone'] = $this->language->get('text_telephone');
        $data['text_fax'] = $this->language->get('text_fax');
        $data['text_open'] = $this->language->get('text_open');
        $data['text_comment'] = $this->language->get('text_comment');

        $data['entry_name'] = $this->language->get('entry_name');
        $data['entry_email'] = $this->language->get('entry_email');
        $data['entry_enquiry'] = $this->language->get('entry_enquiry');

        $data['button_map'] = $this->language->get('button_map');

        $data['button_submit'] = $this->language->get('button_submit');

        $data['action'] = $this->url->link('information/contact', '', 'SSL');

        $this->load->model('tool/image');

        if ($this->config->get('config_image')) {
            $data['image'] = $this->model_tool_image->resize($this->config->get('config_image'), $this->config->get('config_image_location_width'), $this->config->get('config_image_location_height'));
        } else {
            $data['image'] = false;
        }

        $data['store'] = $this->config->get('config_name');
        $data['address'] = nl2br($this->config->get('config_address'));
        $data['geocode'] = $this->config->get('config_geocode');
        $data['geocode_hl'] = $this->config->get('config_language');
        $data['telephone'] = $this->config->get('config_telephone');
        $data['fax'] = $this->config->get('config_fax');
        $data['open'] = nl2br($this->config->get('config_open'));
        $data['comment'] = $this->config->get('config_comment');

        $data['locations'] = array();
        $map = array();

        $this->load->model('localisation/location');

        foreach((array)$this->config->get('config_location') as $location_id) {
            $location_info = $this->model_localisation_location->getLocation($location_id);

            if ($location_info) {
                if ($location_info['image']) {
                    $image = $this->model_tool_image->resize($location_info['image'], $this->config->get('theme_auriga_image_location_width'), $this->config->get('theme_auriga_image_location_height'));
                } else {
                    $image = false;
                }

                $data['locations'][] = array(
                    'location_id' => $location_info['location_id'],
                    'name'        => $location_info['name'],
                    'address'     => nl2br($location_info['address']),
                    'geocode'     => $location_info['geocode'],
                    'telephone'   => $location_info['telephone'],
                    'fax'         => $location_info['fax'],
                    'image'       => $image,
                    'open'        => nl2br($location_info['open']),
                    'comment'     => $location_info['comment']
                );

                $map = $this->addStoreToMap($location_info, $map);
            }
        }

        $data['map'] = json_encode($map);


        $data['column_left'] = $this->load->controller('common/column_left');
        $data['column_right'] = $this->load->controller('common/column_right');
        $data['content_top'] = $this->load->controller('common/content_top');
        $data['content_bottom'] = $this->load->controller('common/content_bottom');
        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');


        $this->response->setOutput($this->load->view('information/contact', $data));

    }

    protected function addStoreToMap($location_info, $map){
        $geocode = explode(',', $location_info['geocode']);
        $store = [
            'name' => $location_info['name'],
            'address' => $location_info['address'],
            'src' => '/image/' . $location_info['image'],
            'description' => $location_info['comment'],
            'phones' => explode(',', $location_info['telephone'])
        ];
        $find = false;
        if(count($map) > 0) {
            foreach ($map as $k => $location) {
                if ($location['location']['lat'] == $geocode[0] && $location['location']['lng'] == $geocode[1]) {
                    $find = true;
                    $map[$k]['stores'][] = $store;
                    break;
                }
            }
        }
        if(!$find){
            $map[] = [
                'location' => [
                    'lat' => $geocode[0],
                    'lng' => $geocode[1]
                ],
                'stores' => [
                    $store
                ]
            ];
        }
        return $map;
    }

}