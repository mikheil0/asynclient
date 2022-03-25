<?php

/**
 * Description of AsynClient
 *
 * @author mikheil0
 */


class AsynClient {

    private array $shards;

    public function setShard(DBConnection $connection): void {
        $this->shards[] = $connection;
    }
    
    
    public function fetch(string $query): array {
        $results = [];
        $all_links = [];
        
        
        //connecting to all added shards
        foreach ($this->shards as $shard) {
            $link = $shard->connect();
            
            if ($link){
                //this code runs immidiately
                $link->query($query, MYSQLI_ASYNC);
                
                $all_links[] = $link;
            }
        }
        
        
        
        $processed = 0;

        do {
            $links = $errors = $reject = array();
            
            foreach ($all_links as $link) {
                $links[] = $errors[] = $reject[] = $link;
            }
           
            //asking to poll all available links
            if (!mysqli_poll($links, $errors, $reject, 1)) {
                continue;
            }
            
            foreach ($links as $link) {
                //get result from async query
                $result = $link->reap_async_query();
                
                if ($result) {
                    //if aleady available fetch data
                    
                    while ($row = $result->fetch_object()){
                        $results[] = $row;
                    }
                    
                    $result->free();
                    $processed++;
                    
                } 
            }
        } while ($processed < count($all_links));
        
        
        return $results;
    }
    
    
    

}
