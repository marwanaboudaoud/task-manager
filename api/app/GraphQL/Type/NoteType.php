<?php

namespace App\GraphQL\Type;

use App\Note;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class NoteType extends GraphQLType
{
    protected $attributes = [
        'name'          => 'Note',
        'description'   => 'note',
        'model'         => Note::class
    ];

    public function fields()
    {
        return [
            'id' => [
                'type'          => Type::nonNull(Type::int()),
                'description'   => 'The id of the note',
            ],
            'text' => [
                'type'          => Type::string(),
                'description'   => 'The text of the note',
            ],
            'user' => [
                'type'          => GraphQL::type('user'),
                'description'   => 'The user of the note',
            ],
            'created_at' => [
                'type'          => Type::string(),
                'description'   => 'The created at timestamp of the task',
            ],
            'updated_at' => [
                'type'          => Type::string(),
                'description'   => 'The updated at timestamp of the task',
            ],
        ];
    }
}