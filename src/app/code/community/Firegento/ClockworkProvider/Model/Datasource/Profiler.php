<?php
/**
 * 
 * 
 * 
 * 
 * 
 */
class Firegento_ClockworkProvider_Model_Datasource_Profiler extends \Clockwork\DataSource\DataSource{
    
    public function resolve(Clockwork\Request\Request $request){
        $timelineData = array();
        
        #var_dump( Varien_Profiler::getTimers() ); die(__FILE__.':'.__LINE__);
        
        foreach( Varien_Profiler::getTimers() as $name=>$timer ){
            $start  = $timer['start'] ? $timer['start'] : $end;
            $end    = $start + $timer['sum'];
            if( $timer['sum'] < 0.010 ){ continue;}
            $timelineData[$name] = array(
                'start'       => $start,
                'end'         => $end,
                'duration'    => $timer['sum'] * 1000,
                'description' => $name."({$timer['count']})",
                'additional'  => json_encode( array(
                        "count"         => $timer['count'],
                        "realmem"       => $timer['realmem'],
                        "emalloc"       => $timer['emalloc'],
                        "realmem_start" => $timer['realmem_start'],
                        "emalloc_start" => $timer['emalloc_start'],
                ) ),
            );
        }

        $request->timelineData = $timelineData;
    }
    
}