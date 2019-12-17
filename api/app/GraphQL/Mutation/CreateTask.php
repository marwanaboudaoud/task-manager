<?php

namespace App\GraphQL\Mutation;

use App\Category;
use App\MeetingList;
use App\Src\services\mailService\MailService;
use App\Task;
use App\User;
use Carbon\Carbon;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use App\Src\services\JWTService\JWTService;
use Rebing\GraphQL\Support\SelectFields;

class CreateTask extends Mutation
{
    protected $attributes = [
        'name' => 'CreateTask'
    ];

    public function type()
    {
        return GraphQL::type('task');
    }

    public function args()
    {
        return [
            'title' => [
                'name' => 'title',
                'type' => Type::string()
            ],
            'description' => [
                'name' => 'description',
                'type' => Type::string()
            ],
            'deadline' => [
                'name' => 'deadline',
                'type' => Type::string()
            ],
            'category_id' => [
                'name' => 'category_id',
                'type' => Type::int()
            ],
            'meeting_list_id' => [
                'name' => 'meeting_list_id',
                'type' => Type::int()
            ],
            'email' => [
                'name' => 'email',
                'type' => Type::string()
            ],
        ];
    }

    public function rules(array $args = [])
    {
        return [
            'title' => ['required', 'string'],
            'description' => ['string'],
            'deadline' => ['date_format:d-m-Y H:i:s'],
            'email' => ['email'],
            'category_id' => ['integer'],
            'meeting_list_id' => ['required', 'integer'],
        ];
    }

    public function validationErrorMessages ($args = [])
    {
        return [
            'title.required' => 'Please enter a title',
            'deadline.date' => 'Deadline is not in a correct format',
            'meeting_list_id.required' => 'Please enter a meeting',
        ];
    }

    public function resolve($root, $args, SelectFields $fields)
    {
        $task = new Task();

        $task->title = encrypt($args['title']);
        $task->description = encrypt($args['description']) ?? null;

        if(!empty($args['deadline'])){
            $task->deadline = new Carbon($args['deadline']);
        }

        if(!empty($args['email'])){

            $mailService = new MailService();
            $user = User::where('email', $args['email'])->first();

            if (!$user){
                $user = new User();
                $user->email = $args['email'];
                $user->save();

                $mailService->sendAddNonExistingAssigneeMail($task, $user);
            }
            else{
                $mailService->sendAddExistingAssigneeMail($task, $user);
            }

            $task->assignee()->associate($user);
        }

        $meetingList = MeetingList::find($args['meeting_list_id']);

        if(!empty($args['category_id'])){
            $category = Category::find($args['category_id']);

            if(empty($category))
                abort(400, 'Category does not exists');

            if($category->meetingList->id !== $meetingList->id){
                abort(400, 'Category does not belong to this meetingList');
            }
            $task->category()->associate($category);
        }
        else {
            $task->category()->associate($meetingList->categories()->where('slug',$meetingList->id.'-overige')->first());
        }

        $task->save();

        return $task;
    }
}