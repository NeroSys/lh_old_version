<?php
namespace App\Overrides\Catalog\Model\Catalog;

use Tree\Node\Node;
use Tree\Node\NodeInterface;

require_once DIR_OPENCART . 'catalog/model/catalog/category.php';

class CategoryModel extends \ModelCatalogCategory
{
    public function getBreadcrumbs(int $category_id):array {
        $breadcrumbs = $this->getCategoryTree($category_id);
        // unset($breadcrumbs[count($breadcrumbs)-1]);
        return $breadcrumbs;
    }

    public function getCategoryLogo(int $category_id):?array{
        $cat_tree = $this->getCategoryTree($category_id);
        $parent = $this->getCategory($cat_tree[0]['category_id']);
        if(empty($parent['image'])){ return null;}
        $this->load->model('tool/image');
        $parent["image"] = $this->model_tool_image->imageLocation($parent['image']);
        return $parent;
    }

    public function getCategoryTree(string $category_id):?array {
         return $this->getCategoryTreeLeavsUp((int) $category_id);
    }

    public function getCategoryTreeDown(int $category_id):NodeInterface{
        $cache_key = "category_tree_down_".$category_id;
        if($leaves = $this->cache->get($cache_key)) {
            return $leaves;
        }
        $leaves = new Node("root");
        $this->getCategoryTreeLeavsDown((int) $category_id, $leaves);
        $this->cache->set($cache_key, $leaves);
        return $leaves;
    }

    protected function getCategoryTreeLeavsDown(int $category_id, Node $node):void{
        $query = $this->db->query("SELECT cd.name,cd.category_id,c.parent_id FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE c.parent_id = '" . (int) $category_id . "' AND cd.language_id = '" . (int) $this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int) $this->config->get('config_store_id') . "' AND c.status = '1' ORDER BY c.sort_order ASC");
        foreach ($query->rows as $belowCategory) {
            $belowCategory["href"] = $this->url->link('product/category', 'path=' . $belowCategory['category_id']);
            $leavNode = new Node($belowCategory);
            $node->addChild(
                $leavNode
            );
            $this->getCategoryTreeLeavsDown((int) $belowCategory["category_id"], $leavNode);
        }
    }

    protected function getCategoryTreeLeavsUp(int $category_id):?array{
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