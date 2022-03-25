
Task: We have two tables with the same data structure in a databases on different hosts. We need to get some data from both tables and then concatenate data in a PHP array.

Problem: 

1) PHP does not support parallel activities. When issuing a database query PHP waits for the database server to execute the query. Until it gets a response PHP is blocked. No new query can proceed. 


2) When using MySQL, PHP is either inactive and waits until the MySQL Server has calculated the query result and all query results have been transferred to PHP. PHP is blocked until results have been fetched and decoded.

Because of that reason we are losing time when we would like to get data from different shards.

Solution: 

The solution is to ask MySQL to proceed with queries in parallel and return available data as soon as it is ready to be returned to PHP. For that:
 
1) We are creating new connections for parallel queries
2) We are processing queries asynchronously using MYSQLI_ASYNC flag
3) We are fetching data from MySQL as soon as it is available 
