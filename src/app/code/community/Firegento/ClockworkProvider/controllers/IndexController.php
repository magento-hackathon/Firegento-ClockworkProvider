<?php
/**
 * 
 * 
 * 
 * 
 * 
 */ 

class Firegento_ClockworkProvider_IndexController extends Mage_Core_Controller_Front_Action
{
    protected function _construct()
    {
        parent::_construct();
    }
    
    public function indexAction(){

        echo "hello World";
    }
    
    public function showAction(){
        $id = $this->getRequest()->getParam('id');
        
        $storage = new Clockwork\Storage\FileStorage( Mage::getBaseDir('var').'/clockwork/' );
        echo $storage->retrieveAsJson( $id );
        return;
        $request = $storage->retrieve( $id );
        echo $request->toJson();
    }
}

