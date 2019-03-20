<?php
namespace ProKarma\MyProducts\Block\Customer;

/**
 * Class MyProducts
 * @package ProKarma\MyProducts\Block\Customer
 */
class MyProducts extends \Magento\Framework\View\Element\Template
{
    /**
     * Image Height
     */
    const PRODUCT_IMAGE_HEIGHT = '150';

    /**
     * Image width
     */
    const PRODUCT_IMAGE_WIDTH = '150';

    /**
     * Default Message for empty response
     */
    const DEFAULT_MESSAGE = "You don't have products to show";

    /**
     * @var \ProKarma\MyProducts\Helper\Customer
     */
    protected $myProductsHelper;

    /**
     * @var \Magento\Sales\Model\Order
     */
    protected $order;

    /**
     * @var \Magento\Catalog\Helper\Image
     */
    protected $imageHelper;

    /**
     * @var \Magento\Framework\Pricing\Helper\Data
     */
    protected $pricingHelper;

    /**
     * MyProducts constructor.
     * @param \ProKarma\MyProducts\Helper\Customer\MyProducts $myProductsHelper
     * @param \Magento\Sales\Model\Order $order
     * @param \Magento\Catalog\Helper\Image $imageHelper
     * @param \Magento\Framework\Pricing\Helper\Data $pricingHelper
     * @param \Magento\Framework\View\Element\Template\Context $context
     */
    public function __construct(
        \ProKarma\MyProducts\Helper\Customer\MyProducts $myProductsHelper,
        \Magento\Sales\Model\Order $order,
        \Magento\Catalog\Helper\Image $imageHelper,
        \Magento\Framework\Pricing\Helper\Data $pricingHelper,
        \Magento\Framework\View\Element\Template\Context $context
    )
    {
        $this->myProductsHelper = $myProductsHelper;
        $this->order = $order;
        $this->imageHelper = $imageHelper;
        $this->pricingHelper = $pricingHelper;
        parent::__construct($context);
    }

    /**
     * @return array|string
     */
    public function getMyOrderedProducts()
    {
        $orderDetails = self::DEFAULT_MESSAGE;
        $sort = $this->getRequest()->getParam('sort');
        if ($this->myProductsHelper->validateCustomerLoggedIn()) {
            $customerId = $this->myProductsHelper->getCustomerId();
            $orders = $this->order->getCollection()->addFieldToFilter("customer_id", $customerId);
            if (count($orders) > 0) {
                $orderDetails = $this->formatProductsDetails($orders, $sort);
            } else {
                $orderDetails = self::DEFAULT_MESSAGE;
            }
        }
        return $orderDetails;
    }

    public function sortByOptions($array,$key,$sort='asc') {
        foreach($array as $k=>$v) {
            $b[] = strtolower($v[$key]);
        }
        if($sort=="asc"){
            asort($b);
        }else if($sort=="desc"){
            asort($b);
           $b= array_reverse($b,true);
        }

        foreach($b as $k=>$v) {
            $c[] = $array[$k];
        }

        return $c;
    }

    /**
     * @param $orders
     * @param $sort
     * @return array
     */
    public function formatProductsDetails($orders, $sort)
    {
        $price=0;
        $products = array();
        $productIds = array();
        $i=0;
        foreach ($orders as $order) {
            foreach ($order->getAllVisibleItems() as $item) {
                 $productId=$item->getProductId();
                if(in_array($productId,$productIds)){
                    for($k=0;$k<count($products) ; $k++){ // loop through complete array and find product add qty
                        if($products[$k]['product_id']==$productId){
                            $products[$k]['total_sale']=$products[$k]['total_sale']+$item->getQtyOrdered();
                        }
                    }

                }else{ // add new product into array
                    $products[$i]['product_id'] = $item->getProductId();
                    $products[$i]['name'] = $item->getName();
                    $products[$i]['item_id'] = $item->getId();
                    $products[$i]['price'] = $item->getPrice();
                    $products[$i]['qty'] = $item->getQtyOrdered();
                    $products[$i]['total_sale'] = $item->getQtyOrdered();
                    $products[$i]['image'] = $this->getProductImage($item);
                    $products[$i]['image_height'] = self::PRODUCT_IMAGE_HEIGHT;
                    $products[$i]['image_width'] = self::PRODUCT_IMAGE_WIDTH;
                    $products[$i]['custom_options'] = $this->getformatedCustomOptions($item->getProductOptions());
                    $productIds[] =  $productId;
                    $i++;
                }

            }

        }
        // Sorting the list by criteria
        if($sort=="lth"){
            $products = $this->sortByOptions($products,'price','asc');
        }else if($sort=="htl"){
            $products = $this->sortByOptions($products,'price','desc');
        }else  if($sort=="mo"){
            $products = $this->sortByOptions($products,'total_sale','desc');
        }else if ($sort=="lo"){
            $products = $this->sortByOptions($products,'total_sale','asc');
        }else{
            $products = $this->sortByOptions($products,'price');
        }
        return $products;
    }

    /**
     * @param $item
     * @return mixed
     */
    public function getProductImage($item)
    {
        return $this->imageHelper
            ->init($item->getProduct(), 'product_page_image_small')
            ->setImageFile($item->getProduct()->getImage())
            ->resize(self::PRODUCT_IMAGE_WIDTH, self::PRODUCT_IMAGE_HEIGHT)
            ->getUrl();
    }

    /**
     * @param $options
     * @return string
     */
    public function getformatedCustomOptions($options)
    {
        $formatedOptions = '';
        if (isset($options['options']) && !empty($options['options'])) {
            foreach ($options['options'] as $option) {
                $formatedOptions .= "<strong>" . $option['label'] . "</strong>: <span>" . $option['print_value'] . "</span></br>";
            }
        }
        return $formatedOptions;
    }

    /**
     * @return string
     */
    public function getCustomSortByOptions()
    {
        $sort = $this->getRequest()->getParam('sort');
        if ($sort == 'htl') {
            $selectHtl = "selected";
        } else {
            $selectHtl = "";
        } // high to low
        if ($sort == 'lth') {
            $selectLth = "selected";
        } else {
            $selectLth = "";
        } // low to high
        if ($sort == 'mo') {
            $selectMo = "selected";
        } else {
            $selectMo = "";
        } // most ordered
        if ($sort == 'lo') {
            $selectLo = "selected";
        } else {
            $selectLo = "";
        } // least ordered
        $customSortByOptions = '<select name="custom_sort_by_options" onchange="window.location = this.value;" style="max-width: 20%;">
            <option value="' . $this->getMyProductActionUrl() . '">Select Sort Option</option>
            <option ' . $selectHtl . ' value="' . $this->getMyProductActionUrl() . 'sort/htl" >high to low</option>
            <option ' . $selectLth . ' value="' . $this->getMyProductActionUrl() . 'sort/lth">low to high</option>
            <option ' . $selectMo . ' value="' . $this->getMyProductActionUrl() . 'sort/mo">most ordered</option>
            <option ' . $selectLo . ' value="' . $this->getMyProductActionUrl() . 'sort/lo">least ordered</option>
        </select>';

        return $customSortByOptions;
    }

    /**
     * @param $price
     * @param bool $format
     * @param bool $includeContainer
     * @return mixed
     */
    public function getFormattedPrice($price, $format = true, $includeContainer = true)
    {
        return $this->pricingHelper->currency($price, $format, $includeContainer);
    }

    /**
     * @return mixed
     */

    public function getMyProductActionUrl()
    {
        return $this->getUrl("myproducts/customer/index");
    }

    /**
     * @return mixed
     */
    public function getAddToCartOrderedItemActionUrl()
    {
        return $this->getUrl("checkout/cart/addgroup/");
    }
}