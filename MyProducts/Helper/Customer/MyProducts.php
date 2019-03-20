<?php
namespace ProKarma\MyProducts\Helper\Customer;

/**
 * Class MyProducts
 * @package ProKarma\MyProducts\Helper\Customer
 */
class MyProducts extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
     * MyProducts constructor.
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Customer\Model\Session $customerSession
    ) {
        $this->customerSession = $customerSession;
        parent::__construct($context);
    }

    /**
     * @return bool
     */
    public function validateCustomerLoggedIn()
    {
        $isCustomer = false;
        if (!empty($this->customerSession->getCustomerId())) {
            $isCustomer = true;
        }

        return $isCustomer;
    }

    /**
     * @return int|null
     */
    public function getCustomerId(){
        return $this->customerSession->getCustomerId();
    }

}
