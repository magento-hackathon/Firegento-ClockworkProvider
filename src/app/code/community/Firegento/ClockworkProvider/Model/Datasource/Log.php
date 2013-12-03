<?php
/**
 * 
 * 
 * 
 * 
 * 
 */ 

class Firegento_ClockworkProvider_Model_Datasource_Log extends \Clockwork\DataSource\DataSource
{

    /**
     * Adds log entries to the request
     */
    public function resolve(Clockwork\Request\Request $request)
    {
        //$request->log = array_merge($request->log, $this->log->toArray());
        // @todo write firegento-logger support

        return $request;
    }
}