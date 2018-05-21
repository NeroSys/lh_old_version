<?php
use App\Overrides\Catalog\Model\Catalog\CategoryModel;
use App\Overrides\Catalog\Model\Catalog\ProductModel;
use Tree\Node\Node;

class ControllerModuleCategory extends Controller {

    protected $categoryId;

    protected $current_opened_category_tree_ids;
    /**
     * @var CategoryModel
     */
    protected $category_model;
    /**
     * @var ProductModel
     */
    protected $product_model;

    public function __construct($registry)
    {
        parent::__construct($registry);
        $this->category_model = $this->load->model('catalog/category');
        $this->product_model = $this->load->model('catalog/product');

    }

    protected function findOutCategoryId(){
        if(null === $this->categoryId){

        $parts = explode('_', (string)$this->request->get['path']);
        $this->categoryId = (int)end($parts);
        }
        return $this->categoryId;
    }

    protected function findOutOpenedAncestors():array{
        if(null === $this->current_opened_category_tree_ids) {
            $openedCategoryTree = $this->category_model->getCategoryTree($this->findOutCategoryId());
            foreach ($openedCategoryTree as $openedCategory){
                $this->current_opened_category_tree_ids[] = $openedCategory["category_id"];
            }
        }
        return $this->current_opened_category_tree_ids;
    }

    public function index() {
		$this->load->language('module/category');
		$data['heading_title'] = $this->language->get('heading_title');



        $recursiveCategories = $this->category_model->getCategoryTreeDown(0);

        ob_start();
        $this->generateHtmlTree($recursiveCategories);
        $content = ob_get_contents();
        ob_end_clean();
		$data["category_html"] = $content;

		return $this->load->view('module/category', $data);
	}

	protected function generateHtmlTree(\Tree\Node\NodeInterface $node){
        foreach ($node->getChildren() as $nodeWithChildrens) {
            $category = $nodeWithChildrens->getValue();
            $hasChildren = $nodeWithChildrens->getChildren() ? true:false;
            echo $hasChildren ? "<li class='hadchild'>": "<li>";

            $item_active_class = '';
            if ((int) $category['category_id'] === $this->findOutCategoryId()){ $item_active_class= 'active';  }

            if($hasChildren) {
                echo in_array($category["category_id"], $this->findOutOpenedAncestors()) ?
                    '<span class="button-view ttclose">close</span>':
                    '<span class="button-view ttopen">view</span>';
            }

            echo '<a href="'.$category['href'].'" class="list-group-item '.$item_active_class.'"><span><b>'.$category['name'].'</b></span></a>';

            if($hasChildren) {
               echo in_array($category["category_id"], $this->findOutOpenedAncestors()) ?
                   '<ul style="display: block;">':
                   '<ul style="display: none;">';

                $this->generateHtmlTree($nodeWithChildrens);
                echo '</ul>';
            }
            echo "</li>";
        }

    }
}
