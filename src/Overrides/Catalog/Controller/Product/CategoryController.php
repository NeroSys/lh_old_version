<?php

namespace App\Overrides\Catalog\Controller\Product;


class CategoryController extends \Controller
{
    protected function generateBreadcrumbs(int $categoryId): array
    {
        $url = '';

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        if (isset($this->request->get['limit'])) {
            $url .= '&limit=' . $this->request->get['limit'];
        }


        $breadcrumbs = array();

        $breadcrumbs[] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', '', true)
        );
        $filter_data = [];
        foreach ($this->model_catalog_category->getCategoryTree($categoryId) as $category) {
            $breadcrumbs[] = array(
                'text' => $category['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
                'href' => $this->url->link('product/category', 'path=' . $category['category_id'] . $url, true)
            );
        }
        return $breadcrumbs;
    }

    public function index()
    {
        $this->load->language('product/category');

        $this->load->model('catalog/category');

        $this->load->model('catalog/product');

        $this->load->model('tool/image');

        if (isset($this->request->get['filter'])) {
            $filter = $this->request->get['filter'];
        } else {
            $filter = '';
        }

        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'p.sort_order';
        }

        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'ASC';
        }

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }
        $data['page'] = $page;

        $limits = array_unique(array($this->config->get($this->config->get('config_theme') . '_product_limit'), 36));

        sort($limits);

        if (isset($this->request->get['limit'])) {
            if ((int)$this->request->get['limit'] > end($limits)) {
                $this->request->get['limit'] = end($limits);
            }
            $limit = (int)$this->request->get['limit'];
        } else {
            $limit = $this->config->get($this->config->get('config_theme') . '_product_limit');
        }


        $parts = explode('_', (string)$this->request->get['path']);

        $category_id = (int)array_pop($parts);

        $category_info = $this->model_catalog_category->getCategory($category_id);

        if (empty($category_info)) {
            return $this->categoryNotFount();
        }
            $data["breadcrumbs"] = $this->generateBreadcrumbs($category_id);
            // OCFilter start
            if (isset($this->request->get['filter_ocfilter'])) {
                $filter_ocfilter = $this->request->get['filter_ocfilter'];
            } else {
                $filter_ocfilter = '';
            }
            // OCFilter end

            $this->document->setTitle($category_info['meta_title']);
            $this->document->setDescription($category_info['meta_description']);
            $this->document->setKeywords($category_info['meta_keyword']);

            $data['heading_title'] = $category_info['name'];

            $data['text_refine'] = $this->language->get('text_refine');
            $data['text_empty'] = $this->language->get('text_empty');
            $data['text_quantity'] = $this->language->get('text_quantity');
            $data['text_manufacturer'] = $this->language->get('text_manufacturer');
            $data['text_model'] = $this->language->get('text_model');
            $data['text_price'] = $this->language->get('text_price');
            $data['text_tax'] = $this->language->get('text_tax');
            $data['text_points'] = $this->language->get('text_points');
            $data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
            $data['text_sort'] = $this->language->get('text_sort');
            $data['text_limit'] = $this->language->get('text_limit');

            $data['button_cart'] = $this->language->get('button_cart');
            $data['button_wishlist'] = $this->language->get('button_wishlist');
            $data['button_compare'] = $this->language->get('button_compare');
            $data['button_continue'] = $this->language->get('button_continue');
            $data['button_list'] = $this->language->get('button_list');
            $data['button_grid'] = $this->language->get('button_grid');

            if ((int)$category_info['parent_id'] === 0 && $category_info['image']) {
                $data['thumb'] = $this->model_tool_image->resize($category_info['image'], 250, 160);
            } elseif ($category_info['image']) {
                $data['thumb'] = $this->model_tool_image->resize($category_info['image'], $this->config->get($this->config->get('config_theme') . '_image_category_width'), $this->config->get($this->config->get('config_theme') . '_image_category_height'));
                $data['category_image'] = $this->model_tool_image->imageLocation($category_info['image']);
            } else {
                $data['thumb'] = $data['category_image'] = '';
            }
            $data['parent'] = $category_info['parent_id'];
            $data['description'] = html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8');
            $data['compare'] = $this->url->link('product/compare', '', true);



            $data['categories'] = array();
            $data['parent_category_info'] = $this->model_catalog_category->getCategoryLogo($category_id);



            $data['products'] = array();

            $filter_data = array(
                'filter_category_id' => $category_id,
                'filter_filter' => $filter,
                'sort' => $sort,
                'order' => $order,
                'start' => ($page - 1) * $limit,
                'limit' => $limit
            );

            // OCFilter start
            $filter_data['filter_ocfilter'] = $filter_ocfilter;
            // OCFilter end

            $product_total = $this->model_catalog_product->getTotalProducts($filter_data);

            $data["products"] = $this->getCategoryProducts($filter_data);

            $url = '';

            // OCFilter start
            if (isset($this->request->get['filter_ocfilter'])) {
                $url .= '&filter_ocfilter=' . $this->request->get['filter_ocfilter'];
            }
            // OCFilter end

            if (isset($this->request->get['filter'])) {
                $url .= '&filter=' . $this->request->get['filter'];
            }

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }

            $data['sorts'] = array();

            $data['sorts'][] = array(
                'text' => $this->language->get('text_default'),
                'value' => 'p.sort_order-ASC',
                'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.sort_order&order=ASC' . $url, true)
            );

            $data['sorts'][] = array(
                'text' => $this->language->get('text_name_asc'),
                'value' => 'pd.name-ASC',
                'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=pd.name&order=ASC' . $url, true)
            );

            $data['sorts'][] = array(
                'text' => $this->language->get('text_name_desc'),
                'value' => 'pd.name-DESC',
                'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=pd.name&order=DESC' . $url, true)
            );

            $data['sorts'][] = array(
                'text' => $this->language->get('text_price_asc'),
                'value' => 'p.price-ASC',
                'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.price&order=ASC' . $url, true)
            );

            $data['sorts'][] = array(
                'text' => $this->language->get('text_price_desc'),
                'value' => 'p.price-DESC',
                'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.price&order=DESC' . $url, true)
            );

            if ($this->config->get('config_review_status')) {
                $data['sorts'][] = array(
                    'text' => $this->language->get('text_rating_desc'),
                    'value' => 'rating-DESC',
                    'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=rating&order=DESC' . $url, true)
                );

                $data['sorts'][] = array(
                    'text' => $this->language->get('text_rating_asc'),
                    'value' => 'rating-ASC',
                    'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=rating&order=ASC' . $url, true)
                );
            }

            $data['sorts'][] = array(
                'text' => $this->language->get('text_model_asc'),
                'value' => 'p.model-ASC',
                'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.model&order=ASC' . $url, true)
            );

            $data['sorts'][] = array(
                'text' => $this->language->get('text_model_desc'),
                'value' => 'p.model-DESC',
                'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.model&order=DESC' . $url, true)
            );

            $url = '';

            if (isset($this->request->get['filter'])) {
                $url .= '&filter=' . $this->request->get['filter'];
            }

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            $data['limits'] = array();

            $limits = array_unique(array($this->config->get($this->config->get('config_theme') . '_product_limit'), 36));

            sort($limits);
            if (isset($this->request->get['limit'])) {
                if ((int)$this->request->get['limit'] > end($limits)) {
                    $this->request->get['limit'] = end($limits);
                }
            }

            foreach ($limits as $value) {
                $data['limits'][] = array(
                    'text' => $value,
                    'value' => $value,
                    'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url . '&limit=' . $value, true)
                );
            }

            $url = '';

            if (isset($this->request->get['filter'])) {
                $url .= '&filter=' . $this->request->get['filter'];
            }

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }

            $pagination = new \Pagination();
            $pagination->total = $product_total;
            $pagination->page = $page;
            $pagination->limit = $limit;
            $pagination->url = $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url . '&page={page}', true);

            $data['pagination'] = $pagination->render();

            $data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($product_total - $limit)) ? $product_total : ((($page - 1) * $limit) + $limit), $product_total, ceil($product_total / $limit));

            // http://googlewebmastercentral.blogspot.com/2011/09/pagination-with-relnext-and-relprev.html
            if (isset($this->request->get['page'])) {
                if ($page == 1) {
                    $this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id'], true), 'canonical');
                } elseif ($page == 2) {
                    $this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id'], true), 'prev');
                } else {
                    $this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id'] . '&page=' . ($page - 1), true), 'prev');
                }
            }
            if ($limit && ceil($product_total / $limit) > $page) {
                $this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id'] . '&page=' . ($page + 1), true), 'next');
            }

            $data['sort'] = $sort;
            $data['order'] = $order;
            $data['limit'] = $limit;


            // OCFilter Start
            $ocfilter_page_info = $this->load->controller('module/ocfilter/getPageInfo');

            if ($ocfilter_page_info) {
                $this->document->setTitle($ocfilter_page_info['meta_title']);

                if ($ocfilter_page_info['meta_description']) {
                    $this->document->setDescription($ocfilter_page_info['meta_description']);
                }

                if ($ocfilter_page_info['meta_keyword']) {
                    $this->document->setKeywords($ocfilter_page_info['meta_keyword']);
                }

                $data['heading_title'] = $ocfilter_page_info['title'];

                if ($ocfilter_page_info['description'] && !isset($this->request->get['page']) && !isset($this->request->get['sort']) && !isset($this->request->get['order']) && !isset($this->request->get['search']) && !isset($this->request->get['limit'])) {
                    $data['description'] = html_entity_decode($ocfilter_page_info['description'], ENT_QUOTES, 'UTF-8');
                }
            } else {
                $meta_title = $this->document->getTitle();
                $meta_description = $this->document->getDescription();
                $meta_keyword = $this->document->getKeywords();

                $filter_title = $this->load->controller('module/ocfilter/getSelectedsFilterTitle');

                if ($filter_title) {
                    if (false !== strpos($meta_title, '{filter}')) {
                        $meta_title = trim(str_replace('{filter}', $filter_title, $meta_title));
                    } else {
                        $meta_title .= ' ' . $filter_title;
                    }

                    $this->document->setTitle($meta_title);

                    if ($meta_description) {
                        if (false !== strpos($meta_description, '{filter}')) {
                            $meta_description = trim(str_replace('{filter}', $filter_title, $meta_description));
                        } else {
                            $meta_description .= ' ' . $filter_title;
                        }

                        $this->document->setDescription($meta_description);
                    }

                    if ($meta_keyword) {
                        if (false !== strpos($meta_keyword, '{filter}')) {
                            $meta_keyword = trim(str_replace('{filter}', $filter_title, $meta_keyword));
                        } else {
                            $meta_keyword .= ' ' . $filter_title;
                        }

                        $this->document->setKeywords($meta_keyword);
                    }

                    $heading_title = $data['heading_title'];

                    if (false !== strpos($heading_title, '{filter}')) {
                        $heading_title = trim(str_replace('{filter}', $filter_title, $heading_title));
                    } else {
                        $heading_title .= ' ' . $filter_title;
                    }

                    $data['heading_title'] = $heading_title;

                    $data['description'] = '';
                } else {
                    $this->document->setTitle(trim(str_replace('{filter}', '', $meta_title)));
                    $this->document->setDescription(trim(str_replace('{filter}', '', $meta_description)));
                    $this->document->setKeywords(trim(str_replace('{filter}', '', $meta_keyword)));

                    $data['heading_title'] = trim(str_replace('{filter}', '', $data['heading_title']));
                }
            }
            // OCFilter End


            $data['continue'] = $this->url->link('common/home', '', true);

            $data['column_left'] = $this->load->controller('common/column_left');
            $data['column_right'] = $this->load->controller('common/column_right');
            $data['content_top'] = $this->load->controller('common/content_top');
            $data['content_bottom'] = $this->load->controller('common/content_bottom');
            $data['footer'] = $this->load->controller('common/footer');
            $data['header'] = $this->load->controller('common/header');

            $this->response->setOutput($this->load->view('product/category', $data));

    }

    protected function getCategoryProducts(array $filter_data){
        $url = '';

        if (isset($this->request->get['filter'])) {
            $url .= '&filter=' . $this->request->get['filter'];
        }

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        if (isset($this->request->get['limit'])) {
            $url .= '&limit=' . $this->request->get['limit'];
        }
        
        $results = $this->model_catalog_product->getProducts($filter_data);
        $products = [];
        foreach ($results as $result) {
            if ($result['image']) {
                $image = $this->model_tool_image->resize($result['image'], $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height'));
            }

            if (empty($image)) {
                $image = $this->model_tool_image->resize('placeholder.png', $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height'));
            }

			$prices = [];

            if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
                $price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                if(isset($result['prices']['min'])){
					$prices['min'] = $this->currency->format($this->tax->calculate($result['prices']['min'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				}
				if(isset($result['prices']['max'])){
					$prices['max'] = $this->currency->format($this->tax->calculate($result['prices']['max'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				}
			} else {
                $price = false;
            }

            if ((float)$result['special']) {
                $special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
            } else {
                $special = false;
            }

            if ($this->config->get('config_tax')) {
                $tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price'], $this->session->data['currency']);
            } else {
                $tax = false;
            }

            if ($this->config->get('config_review_status')) {
                $rating = (int)$result['rating'];
            } else {
                $rating = false;
            }

            $product_attributes = $this->model_catalog_product->getProductAttributes($result['product_id']);
            $product_options = $this->model_catalog_product->getProductAttributes($result['product_id']);


            $products[] = array(
                'product_id' => $result['product_id'],
                'thumb' => $image,
                'name' => $result['name'],
                /*'description' =>
                    utf8_substr(
                        strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')
                        ), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')
                    ) . '..',*/
                'description' => $this->model_catalog_product->generateProductDescription($result['product_id']),
                'attributes' => $product_attributes,
                'price' => $price,
				'prices' => $prices,
                'special' => $special,
                'tax' => $tax,
                'minimum' => $result['minimum'] > 0 ? $result['minimum'] : 1,
                'rating' => $result['rating'],
                'href' => $this->url->link('product/product', 'path=' . $this->request->get['path'] . '&product_id=' . $result['product_id'] . $url, true),
				'options' => $result['options']
            );
        }

        return $products;

    }

    protected function categoryNotFount(){
        $url = '';

        if (isset($this->request->get['path'])) {
            $url .= '&path=' . $this->request->get['path'];
        }

        if (isset($this->request->get['filter'])) {
            $url .= '&filter=' . $this->request->get['filter'];
        }

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        if (isset($this->request->get['limit'])) {
            $url .= '&limit=' . $this->request->get['limit'];
        }

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_error'),
            'href' => $this->url->link('product/category', $url, true)
        );

        $this->document->setTitle($this->language->get('text_error'));

        $data['heading_title'] = $this->language->get('text_error');

        $data['text_error'] = $this->language->get('text_error');

        $data['button_continue'] = $this->language->get('button_continue');

        $data['continue'] = $this->url->link('common/home', '', true);

        $this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

        $data['column_left'] = $this->load->controller('common/column_left');
        $data['column_right'] = $this->load->controller('common/column_right');
        $data['content_top'] = $this->load->controller('common/content_top');
        $data['content_bottom'] = $this->load->controller('common/content_bottom');
        $data['footer'] = $this->load->controller('common/footer');
        $data['header'] = $this->load->controller('common/header');

        $this->response->setOutput($this->load->view('error/not_found', $data));
    }
}
