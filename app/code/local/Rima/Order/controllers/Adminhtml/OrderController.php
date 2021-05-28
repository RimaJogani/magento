<?php

class Rima_Order_Adminhtml_OrderController extends Mage_Adminhtml_Controller_Action
{

    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('order');
        return $this;
    }
    public function indexAction()
    {
        $this->_title($this->__('Order System'))->_title($this->__('Orders'));
        $this->_initAction()
            ->renderLayout();
    }
    public function gridAction()
    {
        $this->loadLayout(false);
        $this->renderLayout();
    }

    public function saveOrderAction()
    {
        try
        {
            echo "<pre>";
                $customer_id = $this->getRequest()->getParam('id');

                $cart = Mage::getModel('order/cart');
                $cartcollection = $cart->getCollection();
                $select = $cartcollection->getselect()
                     ->reset(Zend_Db_Select::FROM)->reset(Zend_Db_Select::COLUMNS)
                     ->from('cart')
                     ->where('customer_id = ?',$customer_id);
                
               $cart = $cartcollection->fetchItem($select);
               if($cart)
               {
                   $cart_id = $cart->getId(); 
                   $orderModel = Mage::getModel('order/order');
                   $orderModel->customer_id = $customer_id;
                   $orderModel->total = $cart->total;
                   $orderModel->shipping_amount = $cart->shipping_amount;
                   $orderModel->shipping_method_code = $cart->shipping_method_code;
                   $orderModel->payment_method_code = $cart->payment_method_code;
                   $orderModel->created_at = date("Y-m-d H:i:s");
                   $orderModel->save();


                    $cartItem = Mage::getModel('order/cart_item');
                    $cartItemCollection = $cartItem->getCollection();
                    $cartItemCollection->getSelect()
                        ->reset(Zend_Db_Select::FROM)
                        ->reset(Zend_Db_Select::COLUMNS)
                        ->from('cart_item')
                        ->where('cart_id = ?',$cart_id);

                    $cartItems = $cartItemCollection->getData();

                    foreach ($cartItems as $key => $itemData) 
                    {
                        $orderItem = Mage::getModel('order/order_item');
                        $order_id = Mage::getModel('order/order')->load($customer_id , 'customer_id')->getOrderId();
                        $orderItem->order_id = $order_id;
                        $orderItem->product_id = $itemData['product_id'];
                        $orderItem->quantity = $itemData['quantity'];
                        $orderItem->base_price = $itemData['base_price'];
                        $orderItem->price = $itemData['price'];
                        $orderItem->name = $itemData['name'];
                        $orderItem->sku = $itemData['sku'];
                        $orderItem->created_at = date("Y-m-d H:i:s");
                        $orderItem->save();
                    }

                    $cartAddress = Mage::getModel('order/cart_address');
                    $cartAddressCollection = $cartAddress->getCollection();
                    $cartAddressCollection->getSelect()
                        ->reset(Zend_Db_Select::FROM)
                        ->reset(Zend_Db_Select::COLUMNS)
                        ->from('cart_address')
                        ->where('cart_id = ?',$cart_id);
                    
                    $cartAddresses = $cartAddressCollection->getData(); 
                    foreach ($cartAddresses as $key => $addressData) 
                    {
                        $orderAddress = Mage::getModel('order/order_address');
                        $order_id = Mage::getModel('order/order')->load($customer_id , 'customer_id')->getOrderId();
                        $orderAddress->order_id = $order_id;
                        $orderAddress->customer_id = $customer_id;
                        $orderAddress->cart_address_id = $addressData['address_id'];
                        $orderAddress->customer_firstname = $addressData['firstname'];
                        $orderAddress->customer_lastname = $addressData['lastname'];
                        $orderAddress->address_type = $addressData['address_type'];
                        $orderAddress->address = $addressData['street'];
                        $orderAddress->city = $addressData['city'];
                        $orderAddress->region = $addressData['region'];
                        $orderAddress->country_id = $addressData['country_id'];
                        $orderAddress->postcode = $addressData['postcode'];
                        $orderAddress->save();

                    }  

                    $cart = Mage::getModel('order/cart')->load($cart_id)->delete();
                    

                    $cartItem = Mage::getModel('order/cart_item');
                    $cartItemCollection = $cartItem->getCollection();
                    $cartItemCollection->getselect()
                        ->reset(Zend_Db_Select::FROM)
                        ->reset(Zend_Db_Select::COLUMNS)
                        ->from('cart_item')
                        ->where('cart_id = ?' , $cart_id);
                    $cartItems = $cartItemCollection->getData();

                    foreach ($cartItems as $key => $value) {
                        Mage::getModel('order/cart_item')->load($value['item_id'])->delete();       
                    }
                    
                    $cartAddress = Mage::getModel('order/cart_address')->load($customer_id ,'customer_id')->delete();

               }
               else
               {

                    $this->_getSession()->addError(
                                $this->__('please first add to cart')
                            );
               }

        }
        catch (Mage_Core_Model_Exception $e) 
        {
            $this->_getSession()->addError($e->getMessage());
        }
        $this->_redirect('*/*/index');
       
    }



    
   
}
