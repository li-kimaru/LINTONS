
<\?php
/**
 * @package magento 2.3.5 p1   
 * @author      kimaru <kimaruaw@gmailcom>
  **/


namespace liElement\CustomRoute\Controller\Path;

class Action extends \Magento\Framework\App\Action\Action 
{
	
    protected $_context;
    protected $_pageFactory;
    protected $_jsonEncoder;
    
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Json\EncoderInterface $encoder,
        \Magento\Framework\View\Result\PageFactory $pageFactory
    ) {
        $this->_context = $context;
        $this->_pageFactory = $pageFactory;
		$this->_jsonEncoder = $encoder;        
        parent::__construct($context);
    }
    
    /**
     * Takes the place of the M1 indexAction. 
     * Now, every action has an execute
     *
     **/

    public function execute() 
    {
    	$response = array('status'=>'success');
        $this->getResponse()->representJson($this->_jsonEncoder->encode($response));
        return;
    }
}

/**
** CREATES A JSON FOR A DATAFETCH
**/



$oid = $this->getRequest()->getParam('oid');
$orderData = ['response'=>null];
if ($oid) {
    $orderData['response'] = $this->_orderHelper->getOrderInfo($oid);
} else {
    $orderData = array('error' => 'The order does not exist or was not provided');
}
$this->getResponse()->representJson($this->_jsonEncoder->encode($orderData));
return;


/**
*executeS THE FILE
 */
