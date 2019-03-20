<?php
namespace ProKarma\MyProducts\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;

/**
 * Class CartAddObserver
 * @package ProKarma\MyProducts\Observer
 */
class CartAddObserver implements ObserverInterface
{
    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $request;

    /**
     * CartAddObserver constructor.
     * @param \Magento\Framework\App\RequestInterface $request
     */
    public function __construct(
        \Magento\Framework\App\RequestInterface $request
    )
    {
        $this->request = $request;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        $reorderItemQty = $this->request->getPost('reorder-item-qty');
        if(isset($reorderItemQty) && !empty($reorderItemQty)){
            $quoteItem = $observer->getItems();
            $quoteItem[0]->setQty($reorderItemQty);
        }
    }
}
