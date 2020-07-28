<?php

namespace App\GraphQL\Queries;

use App\Cat;
use App\Dog;
use App\DogItem;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class AnimalResolver
{
    /**
     * Return a value for the field.
     *
     * @param  null  $rootValue Usually contains the result returned from the parent field. In this case, it is always `null`.
     * @param  mixed[]  $args The arguments that were passed into the field.
     * @param  \Nuwave\Lighthouse\Support\Contracts\GraphQLContext  $context Arbitrary data that is shared between all fields of a single query.
     * @param  \GraphQL\Type\Definition\ResolveInfo  $resolveInfo Information about the query itself, such as the execution state, the field name, path to the field from the root, and more.
     * @return mixed
     */
    public function list($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $cat = new Cat;
        $cat->id = 1;
        $cat->name = 'hoge_cat';
        $cat->feed = 'pet_food';

        $dog = new Dog;
        $dog->id = 2;
        $dog->name = 'fuga_dog';

//        $dog_item = new DogItem;
//        $dog_item->id = 1;
//        $dog_item->name = 'ball';

        $dog_item = [
                'id' => 1,
                'name' => 'ball'
        ];

        $dog->favorite = [$dog_item];

        return [
            $cat,
            $dog
        ];
    }
}
