<?php 
Function Declaration :this code builds a graph from input and uses BFS to find the shortest path from the first node to the last node.
/***
Graph build: O(n + E)
BFS with path copying: O(E × n)
Bottleneck: copying the path for every queue item.
Overall space complexity: O(n + E + E × n) ≈ O(E × n) (dominated by path copies in queue)
**/
function GraphChallenge($strArr) {
  $n = (int)$strArr[0]; # The first element in the array will be the number of nodes N
 
  $nodes = array_slice($strArr, 1, $n); # The next N elements , node names

#initialising the graph
#$graph will store which nodes are connected to which.
#Each node starts with an empty list of neighbors.
  $graph = [];
  foreach($nodes as $node){
    $graph[$node] = []; #initiate empty neighbours
  }

  #adding edges
  for($i = $n + 1; $i < count($strArr); $i++){
    #each edge is the format A-B
    /*
    *The rest of the array tells us which nodes are connected (edges).
    * Example: "A-B" means A is connected to B.
    * We split "A-B" into ["A","B"] using explode.
    * Then we add them to each other’s nxt ($graph[$a][] = $b).
    */
    [$a,$b] = explode("-", $strArr[$i]);
    #graph is undirected
    $graph[$a][] = $b;
    $graph[$b][] = $a;
    /*
	*After this step, the graph looks like a map of all connections:
	A => [B, C]
	B => [A, D]
	C => [A]
	D => [B]
    */
  }
  
  
  #retrieve the first and last nodes
  $first = $nodes[0];
  $last = $nodes[$n-1];
  #tracking visited nodes via the graph
  $seen = [];
  $queu = [[$first, [$first]]];
 
  #Breadth-First Search (BFS) with pointer
  $front = 0;
  /***
  * $seen keeps track of visited nodes so we don’t get stuck in loops.
  *$queu (queue) is a list of nodes to explore with the path we took to reach them.
  *$front is like a pointer to the “current node we’re exploring”.
  */
  
  while(count($queu) > $front){
    #de queue 
    list($current, $path) = $queu[$front];
/***
Loop through nodes in the queue.

$current = the node we are visiting.

$path = how we got to this node.
*/
    
    if($current === $last){ #If we reached the last node, return the path as a string, e.g., "A-B-D".
      return implode("-", $path);
    }
    
    #check on neighbours
    foreach($graph[$current] as $nxt){
    /***
	*Look at all friends of the current node.If we haven’t visited them, mark as visited and add them to the queue with the path updated
	*/
      if(!isset($seen[$nxt])){
        $seen[$nxt] = true;
        $nxtPath = $path; #copy path
        $nxtPath[] = $nxt; #add nxt to path
        $queu[] = [ $nxt, $nxtPath]; #enqueu

	
      }

    }
    $front++ ;#move the pointer forward
/****
*Move the pointer to the next node in the queue.

This is BFS in action: explore nodes level by level.
*/
    
  }
   

  #if there is not path
  return "-";


}
   
// keep this function call here  
echo GraphChallenge(fgets(fopen('php://stdin', 'r')));  

?>
