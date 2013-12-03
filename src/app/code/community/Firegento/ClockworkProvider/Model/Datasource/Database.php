<?php
/**
 *
 *
 *
 *
 *
 */

class Firegento_ClockworkProvider_Model_Datasource_Database extends \Clockwork\DataSource\DataSource
{

    /**
     * Adds log entries to the request
     */
    public function resolve(Clockwork\Request\Request $request)
    {
        //$request->databaseQueries = array_merge($request->databaseQueries, $this->getDatabaseQueries());
        $request->databaseQueries = $this->getDatabaseQueries();

        return $request;
    }



    /**
     * Returns an array of runnable queries and their durations from a database connection
     */
    protected function getDatabaseQueries()
    {
        $queries = array();
        
        /** @var Zend_Db_Profiler $profiler */
        $profiler = Mage::getSingleton('core/resource')->getConnection('core_write')->getProfiler();
        $profilerQueries = $profiler->getQueryProfiles();
        if(!$profilerQueries){
            $profilerQueries = array();
        }
        
        foreach ($profilerQueries as $query){
            /** @var Zend_Db_Profiler_Query $query */
            $queryParams = $query->getQueryParams();
            $queries[] = array(
                'query'    => $query->getQuery() . ( empty($queryParams) ? '' : " Params:".json_encode($queryParams) ),
                'duration' => $query->getElapsedSecs(),
            );
        }
        
        return $queries;
    }
}