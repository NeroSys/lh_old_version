<?php

namespace App\ErpIntegration\Queue;

use ActiveRecord\ConnectionManager;
use App\Entity\Category;
use App\Entity\CategoryPath;
use LHGroup\From1cToWeb\Notify\NotifyInterface;
use LHGroup\From1cToWeb\Queue\Product as BasicProductQueue;
use Psr\SimpleCache\CacheInterface;
use Tymosh\ErpExchangeReader\Interfaces\ReaderInterface;


class Product extends BasicProductQueue
{
    protected $cache;
    protected $categoryModel;

    public function __construct(
        ReaderInterface $reader,
        CacheInterface $cache = null)
    {
        parent::__construct($reader);
        $this->cache = $cache;
    }

    public function processMessage(string $xmlMessage, NotifyInterface $notifier)
    {
        parent::processMessage($xmlMessage, $notifier);
        $this->cache->clear();
        $this->repairCategories(0);

    }

    /**
     * чудный опенкарт костыль, пришлось его задублировать/ не хочется тянуть весь гамуз опенкарта только для этого метода в модели категорий или делать что-то еще сложнее
     */
    protected function repairCategories($parent_id = 0) {
        $categories = Category::find('all', array('conditions' => array('parent_id' => $parent_id)));

        foreach ($categories as $category) {
            // Delete the path below the current one
            //$this->db->query("DELETE FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$category['category_id'] . "'");
            CategoryPath::delete_all(array('conditions' => array('category_id = ?', $category->category_id)));
            // Fix for records with no paths
            $level = 0;

            $categoriesByLevel = CategoryPath::find('all', array('conditions' => array('category_id' => $parent_id), 'order' =>'level ASC'));
            //$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$parent_id . "' ORDER BY level ASC");

            foreach ($categoriesByLevel as $result) {
                $catPath = new CategoryPath();
                $catPath->category_id = $category->category_id;
                $catPath->path_id = $result->path_id;
                $catPath->level = $level;
                $catPath->save();

               /* $this->db->query("INSERT INTO `" . DB_PREFIX . "category_path` SET
                category_id = '" . (int)$category['category_id'] . "',
                `path_id` = '" . (int)$result['path_id'] . "', level = '" . (int)$level . "'");*/

                $level++;
            }
            $connection = ConnectionManager::get_connection();
            $connection->query("REPLACE INTO `oc_category_path` SET 
                              `category_id` = '" . (int)$category->category_id . "', 
                              `path_id` = '" . (int)$category->category_id . "', `level` = '" . $level . "' ");

            $this->repairCategories($category->category_id);
        }
    }

}