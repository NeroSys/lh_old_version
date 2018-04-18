<?php
namespace App\Overrides\Catalog\Model\Catalog;

require_once DIR_OPENCART . 'catalog/model/catalog/category.php';

class CategoryModel extends \ModelCatalogCategory
{
    public function getBreadcrumbs(int $category_id):array {
        $breadcrumbs = $this->getCategoryTree($category_id);
        // unset($breadcrumbs[count($breadcrumbs)-1]);
        return $breadcrumbs;
    }

    public function getCategoryLogo(int $category_id){
        $cat_tree = $this->getCategoryTree($category_id);
        $parent = $this->getCategory($cat_tree[0]['category_id']);
        $this->load->model('tool/image');
        $parent["image"] = $this->model_tool_image->imageLocation($parent['image']);
        return $parent;
    }

    public function getCategoryTree(string $category_id) {
        $result = true;
        $breadcrumbs = [];
        do {
            $query = $this->db->query("SELECT cd.name,cd.category_id,c.parent_id FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE c.category_id = '" . (int) $category_id . "' AND cd.language_id = '" . (int) $this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int) $this->config->get('config_store_id') . "' AND c.status = '1' LIMIT 1");
            if ($result = $query->row) {
                $breadcrumbs[] = $result;
                $category_id = $result['parent_id'];
            }
        } while ($result);
        return array_reverse($breadcrumbs);
    }

    public function getOneLevelCategories(int $category_id = 0, int $parent_id = 0){
        $query = $this->db->query("SELECT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias ua WHERE ua.query = concat('category_id=',c.category_id) LIMIT 1) as href FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE c.parent_id = '" . (int) $parent_id . "' AND cd.language_id = '" . (int) $this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int) $this->config->get('config_store_id') . "'  AND c.status = '1' ORDER BY c.sort_order ASC, LCASE(cd.name)");
        return $query->rows;
    }

}