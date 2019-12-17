<?php

use App\GraphQL\Type\AuthType;

return [

    'prefix' => 'graphql',

    'routes' => '{graphql_schema?}',

    'controllers' => \Rebing\GraphQL\GraphQLController::class . '@query',

    'middleware' => [
        \Barryvdh\Cors\HandleCors::class,
    ],

    'route_group_attributes' => [],

    'default_schema' => 'default',

    'schemas' => [
        'default' => [
            'query' => [
                'user' => \App\GraphQL\Query\UserQuery::class,
                'searchUser' => \App\GraphQL\Query\AutoCompleteUserQuery::class,

                'meetingList' => \App\GraphQL\Query\MeetingListQuery::class,
                'meetingLists' => \App\GraphQL\Query\MeetingListsQuery::class,

                'task' => \App\GraphQL\Query\TaskQuery::class,
                'myTasks' => \App\GraphQL\Query\MyTasksQuery::class,
                'tasksTotal' => \App\GraphQL\Query\TasksTotalQuery::class,
                'tasksDone' => \App\GraphQL\Query\TasksDoneQuery::class,
            ],
            'mutation' => [
                'createMeetingList' => \App\GraphQL\Mutation\CreateMeetingList::class,
                'editMeetingList' => \App\GraphQL\Mutation\EditMeetingList::class,

                'addAttendee' => \App\GraphQL\Mutation\AddAttendeeToMeetingList::class,
                'registerAttendee' => \App\GraphQL\Mutation\CreateAccountAddAttendee::class,
                'removeAttendee' =>\App\GraphQL\Mutation\RemoveAttendeeFromMeetingList::class,

                'createTask' => \App\GraphQL\Mutation\CreateTask::class,
                'editTask' => \App\GraphQL\Mutation\EditTask::class,
                'deleteTask' => \App\GraphQL\Mutation\DeleteTask::class,

                'createCategory' => \App\GraphQL\Mutation\CreateCategory::class,
                'reOrderCategory' => \App\GraphQL\Mutation\ReOrderCategory::class,

                'editCategory' =>\App\GraphQL\Mutation\EditCategory::class,

                'editNote' => \App\GraphQL\Mutation\EditNote::class,
            ],
            'middleware' => ['jwt.auth'],
            'method' => ['get', 'post'],
        ],
    ],

    'types' => [
        'user'           => \App\GraphQL\Type\UserType::class,
        'auth'           => AuthType::class,
        'meetingList'    => \App\GraphQL\Type\MeetingListType::class,
        'category'       => \App\GraphQL\Type\CategoryType::class,
        'task'           => \App\GraphQL\Type\TaskType::class,
        'note'           => \App\GraphQL\Type\NoteType::class,
        'myTask'         => \App\GraphQL\Type\MyTaskType::class,

        'OrderTypeEnum'  => \App\GraphQL\Enum\OrderTypeEnum::class,
        'TaskTypeEnum'   => \App\GraphQL\Enum\TaskTypeEnum::class,
    ],

    'error_formatter' => [\App\GraphQL\Error\CustomErrorGraphQL::class, 'formatError'],

    'errors_handler' => ['\Rebing\GraphQL\GraphQL', 'handleErrors'],

    'params_key'    => 'variables',

    'security' => [
        'query_max_complexity' => 200,
        'query_max_depth' => 15,
        'disable_introspection' => false
    ],

    'pagination_type' => \Rebing\GraphQL\Support\PaginationType::class,

    'graphiql' => [
        'prefix' => '/graphiql/{graphql_schema?}',
        'controller' => \Rebing\GraphQL\GraphQLController::class.'@graphiql',
        'middleware' => [],
        'view' => 'graphql::graphiql',
        'display' => env('ENABLE_GRAPHIQL', true),
    ],
];
