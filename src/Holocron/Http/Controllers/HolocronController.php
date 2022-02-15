<?php

namespace Rancor\Holocron\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Rancor\Holocron\Models\Node;
use Rancor\Holocron\Models\Collection;

class HolocronController extends Controller
{
   /**
    * Index Page for Holocron
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
      return $this->collection_index();
   }

   /**
    * Displays all Collections
    *
    * @return \Illuminate\Http\Response
    */
   public function collection_index()
   {
      $collections = Collection::with('nodes')->orderBy('name')->get();

      return view('rancor::holocron.collections.index', compact('collections'));
   }

   /**
    * Displays all Nodes
    *
    * @return \Illuminate\Http\Response
    */
   public function node_index()
   {
      $nodes = Node::orderBy('name')->get()->mapToGroups(function($item, $key) {
         return [ $item['name'][0] => [
            'id' => $item['id'],
            'name' => $item['name']
         ]];
      });

      return view('rancor::holocron.nodes.index', compact('nodes'));
   }

   /**
    * Displays all published Nodes under a specific Collection
    *
    * @param \Rancor\Holocron\Models\Collection  $collection;
    * @return \Illuminate\Http\Response
    */
   public function collection_show(Collection $collection)
   {
      $nodes = $collection->nodes()->with('author','editor','collections')->get()->mapToGroups(function($item, $key) {
         return [ $item['name'][0] => [
            'id' => $item['id'],
            'name' => $item['name']
         ]];
      });

      return view('rancor::holocron.collections.show', compact('collection', 'nodes'));
   }

   /**
    * Displays all published Nodes
    *
    * @param \Rancor\Holocron\Models\Node  $node
    * @return \Illuminate\Http\Response
    */
   public function node_show(Node $node)
   {
      $this->authorize('view', $node);

      $node->load('author','editor','collections');

      return view('rancor::holocron.nodes.show', compact('node'));
   }
}