<?php

namespace AndrykVP\Rancor\Package\View\Components;

use Illuminate\View\Component;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
// use AndrykVP\Rancor\Auth\Models\Permission;
// use AndrykVP\Rancor\Auth\Models\Role;
// use AndrykVP\Rancor\Structure\Models\Award;
// use AndrykVP\Rancor\Structure\Models\Department;
// use AndrykVP\Rancor\Structure\Models\Faction;
// use AndrykVP\Rancor\Structure\Models\Rank;
// use AndrykVP\Rancor\Structure\Models\Type;
// use AndrykVP\Rancor\News\Models\Article;
// use AndrykVP\Rancor\News\Models\Tag;
// use AndrykVP\Rancor\Forums\Models\Board;
// use AndrykVP\Rancor\Forums\Models\Category;
// use AndrykVP\Rancor\Forums\Models\Discussion;
// use AndrykVP\Rancor\Forums\Models\Group;
// use AndrykVP\Rancor\Forums\Models\Reply;
// use AndrykVP\Rancor\Holocron\Models\Collection;
// use AndrykVP\Rancor\Holocron\Models\Node;
// use AndrykVP\Rancor\Scanner\Models\Entry;

class AdminLayout extends Component
{
    /**
     * Array of links to use in Admin Panel
     * 
     * @var array|Illuminate\Support\Collection
     */
    public $links;

    /**
     * Create a new component instance.
     *
     * @param \Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $user = $request->user();
        $links = [
            'Auth' => collect([]),
            'Structure' => collect([]),
            'News' => collect([]),
            'Forums' => collect([]),
            'Holocron' => collect([]),
            'Scanner' => collect([]),
        ];

        if($user->can('viewAny', User::class))
        {
            $links['Auth']->push([
                'uri' => 'users',
                'label' => 'Users'
            ]);
        }

        $models = [
            ['namespace' => 'Auth', 'class' => 'Permission'],
            ['namespace' => 'Auth', 'class' => 'Role'],
            ['namespace' => 'Structure', 'class' => 'Faction'],
            ['namespace' => 'Structure', 'class' => 'Department'],
            ['namespace' => 'Structure', 'class' => 'Rank'],
            ['namespace' => 'Structure', 'class' => 'Award'],
            ['namespace' => 'Structure', 'class' => 'Type', 'label' => 'Award Types'],
            ['namespace' => 'News', 'class' => 'Article'],
            ['namespace' => 'News', 'class' => 'Tag'],
            ['namespace' => 'Forums', 'class' => 'Group', 'label' => 'Usergroups'],
            ['namespace' => 'Forums', 'class' => 'Category'],
            ['namespace' => 'Forums', 'class' => 'Board'],
            ['namespace' => 'Forums', 'class' => 'Discussion'],
            ['namespace' => 'Holocron', 'class' => 'Collection'],
            ['namespace' => 'Holocron', 'class' => 'Node'],
            ['namespace' => 'Scanner', 'class' => 'Entry'],
        ];
        
        foreach($models as $model)
        {
            if($user->can('viewAny', "\\AndrykVP\\Rancor\\".$model['namespace']."\\Models\\".$model['class']))
            {
                $class = Str::plural($model['class']);
                
                $link = [
                    'uri' => strtolower($class),
                    'label' => array_key_exists('label', $model) ? $model['label'] : $class
                ];
                
                $links[$model['namespace']]->push($link);
            }
        }

        $this->links = collect($links);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('rancor::layouts.admin');
    }
}
