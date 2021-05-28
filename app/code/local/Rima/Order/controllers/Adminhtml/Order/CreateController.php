<?php

class Rima_Order_Adminhtml_Order_CreateController extends Mage_Adminhtml_Controller_Action
{
   
    public function indexAction()
    {

        $this->loadLayout();
        $this->_setActiveMenu('order');
        $this->renderLayout();

    }
    

    public function addToCartAction()
    { 
        try 
        {
            $productIds = (array)$this->getRequest()->getParam('product');
            //print_r($productIds);
            $customerId = $this->getRequest()->getParam('id');

            foreach ($productIds as $key => $productId) 
            {
                $product = Mage::getModel('catalog/product')->load($productId);
                if(!$product)
                {
                  throw new Exception("Product is not valid" );
                }

            }
            
            $cart = $this->getCart($customerId);
            foreach ($productIds as $key => $productId) 
            {
              //print_r($productId);
              $product = Mage::getSingleton('catalog/product')->load($productId);
              $cart->addItemToCart($product,1,true); 

            }
            $this->_getSession()->addSuccess(
                        $this->__('Item successfully added into cart')
                    );
            
        }
        catch (Mage_Core_Model_Exception $e) 
        {
            $this->_getSession()->addError($e->getMessage());
        } 
        $this->_redirect('*/*/index',['id'=>$customerId]);

    }

    public function getCart($customerId)
    {
        echo "<pre>";
        $cart = Mage::getModel('order/cart');
        $cartcollection = $cart->getCollection();
        //$readConnection = $cart->getResource()->getReadConnection();
        $select = $cartcollection->getselect()
             ->reset(Zend_Db_Select::FROM)->reset(Zend_Db_Select::COLUMNS)
             ->from('cart')
             ->where('customer_id = ?',$customerId);
        
       $cart = $cartcollection->fetchItem($select);
       if($cart)
       {
          return $cart;
       }

       $cart = Mage::getModel('order/cart');

       $cart->customer_id = $customerId;
       $cart->created_at = date("Y-m-d H:i:s");
       $cart->save();    
       return $cart; 
    }

    public function updateAction()
    {
      try
      {
        //echo "<pre>";
        $customerId = $this->getRequest()->getParam('id');
        $quantities = $this->getRequest()->getParam('quantity');
        //print_r($quantities);
        //die();
        foreach ($quantities as $cartItemId => $quantity) 
        {
          //print_r($quantity);
          if($quantity == 0)
          {
           
            $cartItem = Mage::getModel('order/cart_item')->load($cartItemId)
            ->delete();
            $this->_redirect('*/*/index',['id'=>$customerId]);
            
          }
          $cartItem = Mage::getModel('order/cart_item')->load($cartItemId);

          $basePrice =  $quantity * $cartItem->price - ($cartItem->discount * $quantity);
          $cartItem->base_price = $basePrice; 
          $cartItem->quantity = $quantity;
          $cartItem->updated_at = date('Y-m-d H:i:s');
         // print_r($cartItem);die;
          $cartItem->save();  
          $this->_getSession()->addSuccess(
                        $this->__('Item Quantity successfully update into cart')
                    );
        }
      }
      catch (Mage_Core_Model_Exception $e) 
      {
          $this->_getSession()->addError($e->getMessage());
      } 
   
      $this->_redirect('*/*/index',['id'=>$customerId]);

    }
    public function deleteCartAction()
    {

      try
      {
        $cartId = $this->getRequest()->getParam('id');
        $customerId = $this->getRequest()->getParam('customerId');
        $cartItem = Mage::getModel('order/cart_item')->load($cartId)
            ->delete();
        $this->_getSession()->addSuccess(
                        $this->__('Item  detele  successfully')
                    );   
      }
      catch (Mage_Core_Model_Exception $e) 
      {
          $this->_getSession()->addError($e->getMessage());
      }
      $this->_redirect('*/*/index',['id'=>$customerId]);

    }

    public function billingAddressAction()
    {
      try
      {
        //echo "<pre>";
        $customer_id = $this->getRequest()->getParam('customer_id');
        $cart_id = $this->getRequest()->getParam('cart_id');
        if(!$cart_id)
        {
                  Mage::getSingleton('adminhtml/session')->addError('Please First Add To Cart Item');

        }
        else
        {
            $billingData = $this->getRequest()->getPost('billing');
            $addressId = $this->getRequest()->getParam('address_id');
            $cartBillingAddress = Mage::getModel('order/cart_address');
            //print_r($billingData);
            if($addressId)
            {
              $cartBillingAddress->address_id = $addressId;
              $this->_getSession()->addSuccess(
                        $this->__('Successfully Update Billing Address. ')
                    );
            }

            $cartBillingAddress->cart_id = $cart_id;
            $cartBillingAddress->customer_id = $customer_id;
            $cartBillingAddress->address_type = 'billing'; 
            $cartBillingAddress->addData($billingData);
            //print_r($cartBillingAddress);die();
            $cartBillingAddress->save();
            $this->_getSession()->addSuccess(
                        $this->__('Successfully Save Billing Address. ')
                    );

            if($billingData['save_in_address_book'])
            {
              $customer_id = $this->getRequest()->getParam('customer_id');
              $customerAddress = Mage::getModel('customer/customer')->load($customer_id)->getDefaultBillingAddress();
              //print_r($customerAddress->getData());die();
              if($customerAddress)
              {
                $customerAddress->setFirstname($billingData['firstname']);
                $customerAddress->setLastname($billingData['lastname']);
                $customerAddress->setStreet($billingData['street']);
                $customerAddress->setCity($billingData['city']);
                $customerAddress->setRegion($billingData['region']);
                $customerAddress->setCountryId($billingData['country_id']);
                $customerAddress->setPostcode($billingData['postcode']);
                //print_r($customerAddress->getData());die();
                $customerAddress->save();
                $this->_getSession()->addSuccess(
                        $this->__('Successfully Update Billing Address. ')
                    );
              }
              else
              {
                $customerAddress = Mage::getModel('customer/address');
                $customerAddress->setEntityTypeId($customerAddress->getEntityTypeId());
                $customerAddress->setFirstname($billingData['firstname']);
                $customerAddress->setLastname($billingData['lastname']);
                $customerAddress->setParentId($customer_id);
                $customerAddress->setCustomerId($customer_id);
                $customerAddress->setStreet($billingData['street']);
                $customerAddress->setCity($billingData['city']);
                $customerAddress->setRegion($billingData['region']);
                $customerAddress->setCountryId($billingData['country_id']);
                $customerAddress->setPostcode($billingData['postcode']);
                $customerAddress->setIsDefaultBilling(1);
                $customerAddress->save();
                $this->_getSession()->addSuccess(
                        $this->__('Successfully Save Billing Address. ')
                    );
              }

            }
        }
        
        

        
      }
      catch (Mage_Core_Model_Exception $e) 
      {
          $this->_getSession()->addError($e->getMessage());
      }
      $this->_redirect('*/*/index',['id'=>$customer_id]);
      
      
    }

    public function shippingAddressAction()
    {
      try
      {
        echo "<pre>";
        $customer_id = $this->getRequest()->getParam('customer_id');
        $cart_id = $this->getRequest()->getParam('cart_id');
        if(!$cart_id)
        {
                  Mage::getSingleton('adminhtml/session')->addError('Please First Add To Cart Item');

        }
        else
        {
            $shippingData = $this->getRequest()->getPost('shipping');
            //print_r($shippingData);
            if($shippingData['shipping_as_billing']) 
            {
                
                $cartBillingAddress = Mage::getModel('order/cart_address');
                $cartBillingCollection = $cartBillingAddress->getCollection();
                $select = $cartBillingCollection->getSelect()
                ->reset(Zend_Db_Select::FROM)
                ->reset(Zend_Db_Select::COLUMNS)
                ->from('cart_address')
                ->where('cart_id = ?', $cart_id)
                ->where('address_type = ?', 'billing');
            
                $cartBillingAddress = $cartBillingCollection->fetchItem($select);
                //print_r($cartBillingAddress);die();
                $cartShippingAddress = Mage::getModel('order/cart_address');

                $cartShippingCollection = $cartShippingAddress->getCollection();
                $select = $cartShippingCollection->getSelect()
                ->reset(Zend_Db_Select::FROM)
                ->reset(Zend_Db_Select::COLUMNS)
                ->from('cart_address')
                ->where('cart_id = ?', $cart_id)
                ->where('address_type = ?', 'shipping');

                $cartShippingAddress = $cartShippingCollection->fetchItem($select);
                if($cartShippingAddress)
                {
                  $ShippindId = $cartShippingAddress->getId();
                  $shippingAddress = $cartBillingAddress->getData();
                  $shippingAddress['address_id'] = $ShippindId;
                  $shippingAddress['address_type'] = 'shipping';
                  $shippingAddress['same_as_billing'] = 1;
                  $cartShippingAddress->addData($shippingAddress);
                  //print_r($cartShippingAddress);
                  $cartShippingAddress->save();
                  $this->_getSession()->addSuccess(
                        $this->__('Successfully Update Shipping Address As Billing. ')
                    );
                } 
                else
                {
                    if($cartBillingAddress)
                    {
                        $cartAddress = Mage::getModel('order/cart_address');
                        $billing = $cartBillingAddress->getData();
                        unset($billing['address_id']);
                        $billing['address_type'] = 'shipping';
                        $billing['same_as_billing'] = 1;
                        $cartAddress->addData($billing);
                        //print_r($cartAddress);
                        $cartAddress->save();
                        $this->_getSession()->addSuccess(
                        $this->__('Successfully Save In Shipping Address As Billing. ')
                    );
                    }
                    else
                    {
                      Mage::getSingleton('adminhtml/session')->addError('Please Enter Billing Address First');
                      
                    }
                }
                
                if($shippingData['save_in_address_book'])
                {
                    // echo 11;
                    // $customer_id = $this->getRequest()->getParam('customer_id');
                    $customerAddress = Mage::getModel('customer/customer')->load($customer_id)->getDefaultShippingAddress();
                    //print_r($customerAddress->getData());
                    if($customerAddress)
                    {
                      //echo 11;
                      $customerAddress->setFirstname($cartBillingAddress['firstname']);
                      $customerAddress->setLastname($cartBillingAddress['lastname']);
                      $customerAddress->setStreet($cartBillingAddress['street']);
                      $customerAddress->setCity($cartBillingAddress['city']);
                      $customerAddress->setRegion($cartBillingAddress['region']);
                      $customerAddress->setCountryId($cartBillingAddress['country_id']);
                      $customerAddress->setPostcode($cartBillingAddress['postcode']);
                      //print_r($customerAddress->getData());die();
                      $customerAddress->save();
                       $this->_getSession()->addSuccess(
                        $this->__('Successfully Update Shipping Address. ')
                    );
                    }
                    else
                    {
                      $customerAddress = Mage::getModel('customer/address');
                      $customerAddress->setEntityTypeId($customerAddress->getEntityTypeId());
                      $customerAddress->setFirstname($cartBillingAddress['firstname']);
                      $customerAddress->setLastname($cartBillingAddress['lastname']);
                      $customerAddress->setParentId($customer_id);
                      $customerAddress->setCustomerId($customer_id);
                      $customerAddress->setStreet($cartBillingAddress['street']);
                      $customerAddress->setCity($cartBillingAddress['city']);
                      $customerAddress->setRegion($cartBillingAddress['region']);
                      $customerAddress->setCountryId($cartBillingAddress['country_id']);
                      $customerAddress->setPostcode($cartBillingAddress['postcode']);
                      $customerAddress->setIsDefaultShipping(1);
                      $customerAddress->save();
                       $this->_getSession()->addSuccess(
                        $this->__('Successfully Save Shipping Address. ')
                    );

                    }

                }
               
            }
            else
            {
                //echo 11;
                $cartShippingAddress = Mage::getModel('order/cart_address');

                $cartShippingCollection = $cartShippingAddress->getCollection();
                $select = $cartShippingCollection->getSelect()
                ->reset(Zend_Db_Select::FROM)
                ->reset(Zend_Db_Select::COLUMNS)
                ->from('cart_address')
                ->where('cart_id = ?', $cart_id)
                ->where('address_type = ?', 'shipping');

                $cartShippingAddress = $cartShippingCollection->fetchItem($select);
                $cartShippingAddressModel = Mage::getModel('order/cart_address');

                if($cartShippingAddress->getData())
                {
                  $ShippindId = $cartShippingAddress->getId();
                  $cartShippingAddressModel->address_id = $ShippindId;
                  $this->_getSession()->addSuccess(
                        $this->__('Successfully Update Shipping Address. ')
                    );

                }

                $cartShippingAddressModel->cart_id = $cart_id;
                $cartShippingAddressModel->customer_id = $customer_id;
                $cartShippingAddressModel->address_type = 'shipping'; 
                //print_r($cartShippingAddressModel);die();
                $cartShippingAddressModel->addData($shippingData);
                $cartShippingAddressModel->save();
                $this->_getSession()->addSuccess(
                        $this->__('Successfully Save Shipping Address. ')
                    );

                //print_r($cartShippingAddressModel);die();
                if($shippingData['save_in_address_book'])
                {
                    $customerAddress = Mage::getModel('customer/customer')->load($customer_id)->getDefaultShippingAddress();
                    //print_r($customerAddress->getData());
                    if($customerAddress)
                    {
                      
                      $customerAddress->setFirstname($shippingData['firstname']);
                      $customerAddress->setLastname($shippingData['lastname']);
                      $customerAddress->setStreet($shippingData['street']);
                      $customerAddress->setCity($shippingData['city']);
                      $customerAddress->setRegion($shippingData['region']);
                      $customerAddress->setCountryId($shippingData['country_id']);
                      $customerAddress->setPostcode($shippingData['postcode']);
                      $customerAddress->save();
                      $this->_getSession()->addSuccess(
                        $this->__('Successfully Update Shipping Address. ')
                    );

                      //print_r($customerAddress->getData());die();
                    }
                    else
                    {
                      $customerAddress = Mage::getModel('customer/address');
                      $customerAddress->setEntityTypeId($customerAddress->getEntityTypeId());
                      $customerAddress->setFirstname($shippingData['firstname']);
                      $customerAddress->setLastname($shippingData['lastname']);
                      $customerAddress->setParentId($customer_id);
                      $customerAddress->setCustomerId($customer_id);
                      $customerAddress->setStreet($shippingData['street']);
                      $customerAddress->setCity($shippingData['city']);
                      $customerAddress->setRegion($shippingData['region']);
                      $customerAddress->setCountryId($shippingData['country_id']);
                      $customerAddress->setPostcode($shippingData['postcode']);
                      $customerAddress->setIsDefaultShipping(1);
                      $customerAddress->save();
                      $this->_getSession()->addSuccess(
                        $this->__('Successfully Save Shipping Address. ')
                    );


                    }
                  }
            }
        }    
      }
      catch (Mage_Core_Model_Exception $e) 
      {
          $this->_getSession()->addError($e->getMessage());
      }
      $this->_redirect('*/*/index',['id'=>$customer_id]);
      
      
    }


    public function paymentMethodAction()
    {
      try
      {
        
        //echo "<pre>";

        $customer_id = $this->getRequest()->getParam('customer_id');
        $cart_id = $this->getRequest()->getParam('cart_id');
        if(!$cart_id)
        {
                  Mage::getSingleton('adminhtml/session')->addError('Please First Add To Cart Item');

        }
        else
        {

            $paymentMethod = $this->getRequest()->getPost('paymentmethod');
        
            $cart = Mage::getModel('order/cart')->load($cart_id);

            $cart->payment_method_code = $paymentMethod;
            $cart->updated_at = date("Y-m-d H:i:s");
            //$cart->save();
            $this->_getSession()->addSuccess(
                            $this->__('Payment Method Save')
                        );   
        }
       
      }
      catch (Mage_Core_Model_Exception $e) 
      {
          $this->_getSession()->addError($e->getMessage());
      }
      $this->_redirect('*/*/index',['id'=>$customer_id]);
    }
    
    public function shippingMethodAction()
    {
      try
      {
        //echo 11;
        //echo "<pre>";
        $customer_id = $this->getRequest()->getParam('customer_id');
        $cart_id = $this->getRequest()->getParam('cart_id');
        if(!$cart_id)
        {
                  Mage::getSingleton('adminhtml/session')->addError('Please First Add To Cart Item');

        }
        else
        {
            $shippingMethod = $this->getRequest()->getPost('shippingmethod');
            $data = explode(' ',$shippingMethod);
            $method = $data[0];
            $price = $data[1];
            
            $cart = Mage::getModel('order/cart')->load($cart_id);
            //print_r($cart);die();
            $cart->shipping_method_code = $method;
            $cart->shipping_amount = $price;
            $cart->updated_at = date("Y-m-d H:i:s");
            $cart->save();
            $this->_getSession()->addSuccess(
                            $this->__('Payment Method Save')
                        );  
        } 
      }
      catch (Mage_Core_Model_Exception $e) 
      {
          $this->_getSession()->addError($e->getMessage());
      }
      $this->_redirect('*/*/index',['id'=>$customer_id]);
    }

    
}
