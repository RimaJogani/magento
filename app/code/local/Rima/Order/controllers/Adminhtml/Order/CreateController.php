<?php

class Rima_Order_Adminhtml_Order_CreateController extends Mage_Adminhtml_Controller_Action
{
   
    public function indexAction()
    {

        $this->loadLayout();
        $this->getLayout()->getBlock('cart')->setCart($this->getCart());
        $this->_setActiveMenu('order');
        $this->renderLayout();

    }
    

    public function addToCartAction()
    { 
        try 
        {
            $productIds = (array)$this->getRequest()->getParam('product');
            if(!$productIds)
            {
              $this->_getSession()->addSuccess(
                        $this->__('Invalid  Id')
                    );
            }

            $customerId = $this->getRequest()->getParam('id');
            if(!$customerId)
            {
              $this->_getSession()->addSuccess(
                        $this->__('Invalid  Id')
                    );
            }

            foreach ($productIds as $key => $productId) 
            {
                $product = Mage::getModel('catalog/product')->load($productId);
                if(!$product)
                {
                  throw new Exception("Product is not valid" );
                }

            }
            
            $cart = $this->getCart();
            foreach ($productIds as $key => $productId) 
            {
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

    public function getCart()
    {
        $customerId = $this->getRequest()->getParam('id');
        if(!$customerId)
        {
            throw new Exception("Customer Id Not Found");
            
        }
        $cart = Mage::getModel('order/cart')->load($customerId , 'customer_id' );
        if($cart->getData())
        {
            return $cart;
        }
       $customer = Mage::getModel('customer/customer')->load($customerId);
       $cart = Mage::getModel('order/cart');

       $cart->customer_id = $customerId;
       $cart->firstname = $customer->firstname;
       $cart->lastname = $customer->lastname;
       $cart->created_at = date("Y-m-d H:i:s");
       $cart->save();    
       return $cart; 
    }

    public function updateAction()
    {
      try
      {
        $customerId = $this->getRequest()->getParam('id');
        if(!$customerId)
        {
            throw new Exception("Customer Id Not Found");
            
        }
        $quantities = $this->getRequest()->getParam('quantity');
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
          $cartItem->price = $basePrice; 
          $cartItem->quantity = $quantity;
          $cartItem->updated_at = date('Y-m-d H:i:s');
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
            $cartItemId = $this->getRequest()->getParam('id');
            $customerId = $this->getRequest()->getParam('customer_id');
            if(!$customerId)
            {
                throw new Exception("Customer Id Not Found");
                
            }
            $cartItem = Mage::getModel('order/cart_item')->load($cartItemId)
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
        $cart = $this->getCart();
        $customer_id = $cart->getCustomerId();
        $billingData = $this->getRequest()->getPost('billing');
        $cartBillingAddress = $cart->getBillingAddress();
        if($cartBillingAddress->getId())
        {
            $cartBillingAddress->updated_at = date("Y-m-d H:i:s");
        }
        else
        {
          $cartBillingAddress->cart_id = $cart->getId();
          $cartBillingAddress->customer_id = $cart->getCustomerId();
          $cartBillingAddress->address_type = 'billing';
        }
        $cartBillingAddress->addData($billingData);
        $cartBillingAddress->save();

        if($billingData['save_in_address_book'])
        {
            $customerBillingAddress = $cart->getCustomer()->getBillingAddress();
            if($customerBillingAddress->getId())
            {
                $customerBillingAddress->updated_at = date("Y-m-d H:i:s");
            }
            else
            {

                $customerBillingAddress->setParentId($customer_id);
                $customerBillingAddress->setIsDefaultBilling(1);
                $customerBillingAddress->setCreatedAt(date("Y-m-d H:i:s"));
            }
            $customerBillingAddress->addData($billingData);
            $customerBillingAddress->save();
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
          $cart = $this->getCart();
          $customer_id = $cart->getCustomerId();
          $shippingData = $this->getRequest()->getParam('shipping');
          if($shippingData['shipping_as_billing'])
          {
                  $cartBillingAddress = $cart->getBillingAddress();


                  if($cartBillingAddress->getId())
                  {
                      $data = $cartBillingAddress->getData();
                      $cartShippinAddress = $cart->getShippingAddress();
                      if($cartShippinAddress->getId())
                      {
                          $addressId = $cartShippinAddress->getId();
                          $data['address_id'] = $addressId;
                          
                          $this->_getSession()->addSuccess(
                              $this->__('Successfully Update Shipping Address As Billing. ')
                          );
                      }
                      else
                      {
                        unset($data['address_id']);
                      }
                      $data['same_as_billing'] = 1;
                      $data['address_type'] = 'shipping';
                      $cartShippinAddress->addData($data);
                      $cartShippinAddress->save();
                      

                  }
                  else
                  {
                    Mage::getSingleton('adminhtml/session')->addError('Please Enter Billing Address First');
                  }
                  if($shippingData['save_in_address_book'])
                  {
                      $customerAddress = $cart->getCustomer()->getShippingAddress();
                      if(!$customerAddress->getId())
                      {
                        $customerAddress->setParentId($customer_id);
                        $customerAddress->setIsDefaultShipping(1);
                      }
                      $customerAddress->addData($cartBillingAddress->getData());
                      $customerAddress->save();
                      print_r($customerAddress->getData());
                  }
          }
          else
          {
              $cartShippingAddress = $cart->getShippingAddress();
              if($cartShippingAddress->getId())
              {
                
                $cartShippingAddress->same_as_billing = 0;
              }
              else
              {
                $cartShippingAddress->cart_id = $cart->getId();
                $cartShippingAddress->customer_id = $cart->getCustomerId();
                $cartShippingAddress->address_type = 'billing';
                $cartShippingAddress->same_as_billing = 0;
              }
              $cartShippingAddress->addData($shippingData);
              $cartShippingAddress->save();

              if($shippingData['save_in_address_book'])
                  {
                      $customerAddress = $cart->getCustomer()->getShippingAddress();
                      if(!$customerAddress->getId())
                      {
                        $customerAddress->setParentId($customer_id);
                        $customerAddress->setIsDefaultShipping(1);
                      }
                      $customerAddress->addData($shippingData);
                      $customerAddress->save();
                      print_r($customerAddress->getData());
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
          $paymentMethod = $this->getRequest()->getPost('paymentmethod');
          $customer_id = $this->getRequest()->getParam('id');
          $cart = $this->getCart();
          $cartId = $cart->getId();
          if(!$cartId)
          {
                    Mage::getSingleton('adminhtml/session')->addError('Please First Add To Cart Item');

          }
          else
          {

              $cart->payment_method_code = $paymentMethod;
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
    
    public function shippingMethodAction()
    {
      try
      {
        //echo 11;
        //echo "<pre>";
        $customer_id = $this->getRequest()->getParam('id');
        $shippingMethod = $this->getRequest()->getPost('shippingmethod');
        $cart = $this->getCart();
        $cartId = $cart->getId();
        if(!$cartId)
        {
                  Mage::getSingleton('adminhtml/session')->addError('Please First Add To Cart Item');

        }
        else
        {
            $data = explode(' ',$shippingMethod);
            $method = $data[0];
            $price = $data[1];
           
            $cart->shipping_method_code = $method;
            $cart->shipping_amount = $price;
            $cart->updated_at = date("Y-m-d H:i:s");
            $cart->save();
            $this->_getSession()->addSuccess(
                            $this->__('Shipping  Method Save')
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
