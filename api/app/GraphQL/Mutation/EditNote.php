<?php

namespace App\GraphQL\Mutation;

use App\Note;
use App\User;
use Carbon\Carbon;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

class EditNote extends Mutation
{
    protected $attributes = [
        'name' => 'EditNote'
    ];

    public function type()
    {
        return GraphQL::type('note');
    }

    public function args()
    {
        return [
            'text' => [
                'name' => 'text',
                'type' => Type::string()
            ],
            'user_id' => [
                'name' => 'user_id',
                'type' => Type::int()
            ],
        ];
    }

    public function rules(array $args = [])
    {
        return [
            'text' => ['string'],
            'user_id' => ['required', 'integer'],
        ];
    }

    public function validationErrorMessages ($args = [])
    {
        return [
            'user_id.required' => 'Please enter the user id',
        ];
    }

    public function resolve($root, $args, SelectFields $fields)
    {
        $user = User::find($args['user_id']);

        $note = $user->note;

        if(!empty($args['text'])){
            $note->text = $args['text'];
        }

        $note->save();

        return $note;

    }
}
