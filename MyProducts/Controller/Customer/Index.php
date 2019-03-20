<?php
namespace ProKarma\MyProducts\Controller\Customer;
/**
 * Class Index
 * @package ProKarma\MyProducts\Controller\Customer
 */
class Index extends \Magento\Framework\App\Action\Action {
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_pageFactory;
    /**
     * @var \ProKarma\MyProducts\Helper\Customer\MyProducts
     */
    protected $myProductsHelper;


    /**
     * Index constructor.
     * @param \Magento\Framework\App\Action\Context $context
     * @param \ProKarma\MyProducts\Helper\Customer\MyProducts $myProductsHelper
     * @param \Magento\Framework\View\Result\PageFactory $pageFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \ProKarma\MyProducts\Helper\Customer\MyProducts $myProductsHelper,
        \Magento\Framework\View\Result\PageFactory $pageFactory
    )
    {
        $this->myProductsHelper = $myProductsHelper;
        $this->_pageFactory = $pageFactory;
        return parent::__construct($context);
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        if($this->myProductsHelper->validateCustomerLoggedIn()) {
            return $this->_pageFactory->create();
        } else {
            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setPath('customer/account/login/');
            return $resultRedirect;
        }
    }

}