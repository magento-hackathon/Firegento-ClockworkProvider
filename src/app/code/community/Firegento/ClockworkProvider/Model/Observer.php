<?php

class Firegento_ClockworkProvider_Model_Observer{
    
    /** @var \Clockwork\Clockwork  */
    static $_clockwork = false;
    
    public function initByRequest( $observer ){

        /** @var Mage_Core_Controller_Varien_Action $controllerAction */
        $controllerAction = $observer->getEvent()->getControllerAction();
        
        if( $controllerAction->getRequest()->getModuleName() != 'clockwork' ){

            $clockwork = new \Clockwork\Clockwork();
            $clockwork->setStorage(new Clockwork\Storage\FileStorage( Mage::getBaseDir('var').'/clockwork/' ));
            $clockwork->resolveRequest();
            $clockwork->storeRequest();

            $controllerAction->getResponse()->setHeader('X-Clockwork-Id'     , $clockwork->getRequest()->id );
            $controllerAction->getResponse()->setHeader('X-Clockwork-Version', \Clockwork\Clockwork::VERSION );
            $controllerAction->getResponse()->setHeader('X-Clockwork-Path', '/__clockwork/' );

            self::$_clockwork = $clockwork;
            
        }
        
        return $this;
    }
    
    public function saveByRequest( $observer ){

        if(  self::$_clockwork ){
            $clockwork = self::$_clockwork;
            $clockwork->addDataSource(new Clockwork\DataSource\PhpDataSource());
            $clockwork->addDataSource(new Firegento_ClockworkProvider_Model_Datasource_Database());
            $clockwork->addDataSource(new Firegento_ClockworkProvider_Model_Datasource_Profiler());
            $clockwork->resolveRequest();
            $clockwork->storeRequest();
            
        }

        
    }
    
    
}