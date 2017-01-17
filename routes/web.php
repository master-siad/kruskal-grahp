<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
 */

class Edge
{
    public $Source;
    public $Destination;
    public $Weight;
}

class Graph
{
    public $VerticesCount;
    public $EdgesCount;
    public $_edge = array();
}

class Subset
{
    public $Parent;
    public $Rank;
}

function CreateGraph($verticesCount, $edgesCoun)
{
    $graph = new Graph();
    $graph->VerticesCount = $verticesCount;
    $graph->EdgesCount = $edgesCoun;
    $graph->_edge = array();

    for ($i = 0; $i < $graph->EdgesCount; ++$i) {
        $graph->_edge[$i] = new Edge();
    }

    return $graph;
}

function Find($subsets, $i)
{
    if ($subsets[$i]->Parent != $i) {
        $subsets[$i]->Parent = Find($subsets, $subsets[$i]->Parent);
    }

    return $subsets[$i]->Parent;
}

function Union($subsets, $x, $y)
{
    $xroot = Find($subsets, $x);
    $yroot = Find($subsets, $y);

    if ($subsets[$xroot]->Rank < $subsets[$yroot]->Rank) {
        $subsets[$xroot]->Parent = $yroot;
    } else if ($subsets[$xroot]->Rank > $subsets[$yroot]->Rank) {
        $subsets[$yroot]->Parent = $xroot;
    } else {
        $subsets[$yroot]->Parent = $xroot;
        ++$subsets[$xroot]->Rank;
    }
}

function CompareEdges($a, $b)
{
    return $a->Weight > $b->Weight;
}

function PrintResult($result, $e)
{
    for ($i = 0; $i < $e; ++$i) {
        echo $result[$i]->Source . " -- " . $result[$i]->Destination . " == " . $result[$i]->Weight . "<br/>";
    }

}

function Kruskal($graph)
{
    $verticesCount = $graph->VerticesCount;
    $result = array();
    $i = 0;
    $e = 0;

    usort($graph->_edge, "CompareEdges");

    $subsets = array();

    for ($v = 0; $v < $verticesCount; ++$v) {
        $subsets[$v] = new Subset();
        $subsets[$v]->Parent = $v;
        $subsets[$v]->Rank = 0;
    }

    while ($e < $verticesCount - 1) {
        $nextEdge = $graph->_edge[$i++];
        $x = Find($subsets, $nextEdge->Source);
        $y = Find($subsets, $nextEdge->Destination);

        if ($x != $y) {
            $result[$e++] = $nextEdge;
            Union($subsets, $x, $y);
        }
    }

    //PrintResult($result, $e);

    return $result;
}

function getNodes()
{
    return [
        ['id' => 0, 'label' => 'user0'],
        ['id' => 1, 'label' => 'user1'],
        ['id' => 2, 'label' => 'user2'],
        ['id' => 3, 'label' => 'user3'],
        ['id' => 4, 'label' => 'user4'],
        ['id' => 5, 'label' => 'user5'],
        ['id' => 6, 'label' => 'user6'],
        ['id' => 7, 'label' => 'user7'],
        ['id' => 8, 'label' => 'user8'],
        ['id' => 9, 'label' => 'user9'],
        ['id' => 10, 'label' => 'user10'],
        ['id' => 11, 'label' => 'user11'],
        ['id' => 12, 'label' => 'user12'],
    ];
}

function getEdges()
{
    return [
        ['from' => 0, 'to' => 1, 'label' => 20],
        ['from' => 1, 'to' => 2, 'label' => 2],
        ['from' => 2, 'to' => 3, 'label' => 16],
        ['from' => 3, 'to' => 4, 'label' => 18],
        ['from' => 3, 'to' => 5, 'label' => 5],
        ['from' => 3, 'to' => 6, 'label' => 7],
        ['from' => 4, 'to' => 5, 'label' => 18],
        ['from' => 5, 'to' => 6, 'label' => 55],
        ['from' => 6, 'to' => 7, 'label' => 3],
        ['from' => 7, 'to' => 8, 'label' => 9],
        ['from' => 7, 'to' => 9, 'label' => 22],
        ['from' => 9, 'to' => 10, 'label' => 17],
        ['from' => 10, 'to' => 1, 'label' => 1],
        ['from' => 11, 'to' => 1, 'label' => 1],
        ['from' => 12, 'to' => 12, 'label' => 14],
        ['from' => 12, 'to' => 0, 'label' => 5],
    ];
}

Route::get('/minimal', function () {

    $verticesCount = 0;

    $edgesCount = 0;

    foreach (getNodes() as $node) {
        $verticesCount++;
    }
    foreach (getEdges() as $edge) {
        $edgesCount++;
    }
    $graph = CreateGraph($verticesCount, $edgesCount);

    foreach (getEdges() as $key => $value) {
        $graph->_edge[$key]->Source = $value['from'];
        $graph->_edge[$key]->Destination = $value['to'];
        $graph->_edge[$key]->Weight = $value['label'];
    }
    $results = Kruskal($graph);

    //dd($results);

    $nodes = collect([]);
    $edges = collect([]);
    $minimal = 0;
    foreach ($results as $key => $value) {
        $nodes->push(['id' => $value->Source, 'label' => 'user' . $value->Source]);
        $nodes->push(['id' => $value->Destination, 'label' => 'user' . $value->Destination]);
        $edges->push(['from' => $value->Source, 'to' => $value->Destination, 'label' => $value->Weight]);
        $minimal += $value->Weight;
    }

    $nodes = $nodes->unique('id')->values()->toJson();
    $edges = $edges->toJson();

    //dd($nodes, $edges);

    return view('recomendation.minimal', compact('nodes', 'edges', 'minimal'));
});

Route::get('/', function () {

    $nodes = collect(getNodes())->toJson();

    $edges = collect(getEdges())->toJson();

    return view('recomendation.index', compact('nodes', 'edges'));
});
