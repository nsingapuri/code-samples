<?php
/**
 * Two classes, GraphNode and Graph which model a directed Graph.
 *   Graph::addNode adds a new node to the Graph.
 *   Graph::addDirectedEdge adds a relation between two GraphNodes, creating the
 *     nodes where necessary.
 *   GraphNode::addDirectedEdge does cycle detection and updates visited edges
 *     to allow for efficient cycle detection.
 *   Graph::toDot prints out the graph in a textual form (string formated for
 *     as a valid .dot file)
 *   Graph::toPng saves a image file of the graph in a visual form (.png file)
 *     toPng will require the graphviz library
 *
 *
 * PHP version >= 5.5
 *
 * @author Nalin Singapuri <nalins@gmail.com>
 * @see http://nalin.singapuri.com
 *
 * @example
 *   g = new Graph();
 *
 *   g->addNode(1);
 *   g->addDirectedEdge(1, 2);
 *   g->addDirectedEdge(1, 3);
 *   g->addDirectedEdge(1, 4);
 *   g->addDirectedEdge(2, 5);
 *   g->addDirectedEdge(3, 6);
 *   g->addDirectedEdge(4, 3);
 *   g->addDirectedEdge(4, 6);
 *   g->addDirectedEdge(5, 6);
 *
 *   fileName = 'graph.png';
 *   g->toPng($fileName);
 *
 *   echo "created " . getcwd() . "/" . $fileName . PHP_EOL;
 *
 *   g->addDirectedEdge(1, 1); //throws 'cycle detected'
 *   g->addDirectedEdge(6, 1); //throws 'cycle detected'
 */

/**
 * Represents a directed graph node
 */
class GraphNode
{
    /**
     * @var int the value of this node
     */
    public $value;

    /**
     * @var GraphNode[] the child edges which are connected to this node
     */
    protected $edges;

    /**
     * @var GraphNode[] the parent edges which connect to this node
     */
    protected $reverseEdges;

    /**
     * @var array[] a hash containing values for all children edges connected to this node
     */
    protected $visitedNodes;

    /**
     * Add a new node with a value of $i
     *
     * @param $i int
     */
    public function __construct($i) {
        $this->value = $i;
        $this->edges = [];
        $this->reverseEdges = [];
        $this->visitedNodes = [$i=>true];
    }

    /**
     * Add a new directed edge, $e
     *
     * @param $e GraphNode
     *
     * @throws Exception cycle detected
     */
    public function addDirectedEdge(&$g) {
        if (isset($g->visitedNodes[$this->value])) {
            throw new Exception("cycle detected");
        }

        $this->edges[] = $g;
        $g->reverseEdges[] = &$this;

        $this->visitNodes($g);
    }

    /**
     * Mark the $e->value and $e descendants as visited.
     *   Traverse up the graph and make sure the upstream nodes are mark their descendants as visited
     *
     * @param $e GraphNode
     */
    protected function visitNodes(&$g) {
        // mark $g as visited
        $this->visitedNodes[$g->value] = true;

        // mark $g's children as visited
        if (count($g->visitedNodes)) {
            foreach ($g->visitedNodes as $k=>$v) {
                $this->visitedNodes[$k] = true;
            }
        }

        // update visitedNodes for the parent nodes of $this, and recursively correct the graph
        if (count($this->reverseEdges)) {
            foreach ($this->reverseEdges as $e) {
                $e->visitNodes($this);
            }
        }

    }

    /**
     * Generate .dot file representation of this GraphNode
     *
     * @return string
     */
    public function toDot() {
        $returnValue = "";

        foreach ($this->edges as $edge) {
            $returnValue .= "    {$this->value} -> {$edge->value};" . PHP_EOL;
        }

        return $returnValue;
    }

    /**
     * Generate string representation of this GraphNode
     *
     * @return string
     *
     * @todo this output is not very meaningful
     */
    public function __toString() {
        return "{$this->value}";
    }
}

/**
 * Represents a Graph
 *
 * @todo methods are constrained to those needed for directed graphs.
 */
class Graph
{
    /**
     * @var GraphNode[] the nodes contained in this Graph
     */
    protected $nodes;

    /**
     * Create a new Graph
     */
    public function __construct() {
        $this->nodes = [];
    }

    /**
     * Add a GraphNode.
     *   This method is redundant, calling addDirectedEdge will create nodes as necessary
     *
     * @param int $i
     */
    public function addNode($i) {
        $this->nodes[$i] = new GraphNode($i);
    }

    /**
     * Add a directed edge between two GraphNodes.
     *
     * @param int $i the parent node
     * @param int $j the child node
     *
     * @throws Exception 'cycle detected'
     */
    public function addDirectedEdge($i, $j) {
        if (!isset($this->nodes[$i])) {
            $this->addNode($i);
        }
        if (!isset($this->nodes[$j])) {
            $this->addNode($j);
        }

        $this->nodes[$i]->addDirectedEdge($this->nodes[$j]);
    }

    /**
     * Get a .dot file representation of the Graph
     */
    protected function toDot() {
        $returnValue = "digraph G {" . PHP_EOL;

        foreach ($this->nodes as $node) {
            $returnValue .= $node->toDot();
        }

        $returnValue .= "}" . PHP_EOL;
        return $returnValue;
    }

    /**
     * Generate a png representation of the graph using graphviz 'dot' command line utility.
     *
     * @param string $outputFilename the file to output
     * @param string $dotFilename the dot file
     * @param bool $preserveDotfile a boolean value to indicate whether to preserve the temporary file $dotFilename
     *
     * @throws Exception dot binary not found, output requires graphviz package.
     */
    public function toPng($outputFilename = "graph.png", $dotFilename = 'temp.dot', $preserveDotfile = false) {
        exec("which dot", $output, $returnVal);
        if ($returnVal !== 0) {
            throw new Exception('dot binary not found, output requires graphviz package.');
        }

        // Create a .dot file representing the graph
        $dotFilecontents = $this->toDot();

        $handle = fopen($dotFilename, 'w');
        fwrite($handle, $dotFilecontents);
        fclose($handle);

        // Transform the .dot file into a .png representation
        exec("dot -Tpng {$dotFilename} -o {$outputFilename}");

        if (!$preserveDotfile) {
            exec("rm {$dotFilename}");
        }
    }

    /**
     * Generate string representation of this Graph
     *
     * @return string
     *
     * @todo this output is even less meaningful
     */
    public function __toString() {
        return implode(PHP_EOL, $this->nodes);
    }
}

?>