<?php

namespace App\GraphQL\Mutation;

use App\Category;
use App\MeetingList;
use App\Src\services\mailService\MailService;
use App\Task;
use App\User;
use Carbon\Carbon;
use GraphQL\Type\Definition\Type;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;

class EditTask extends Mutation
{
    protected $attributes = [
        'name' => 'EditTask'
    ];

    public function type()
    {
        return GraphQL::type('task');
    }

    public function args()
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::int()
            ],
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
            'email' => [
                'name' => 'email',
                'type' => Type::string()
            ],
            'meeting_list_id' => [
                'name' => 'meeting_list_id',
                'type' => Type::int()
            ],
            'is_completed' => [
                'name' => 'is_completed',
                'type' => Type::boolean()
            ],
        ];
    }

    public function rules(array $args = [])
    {
        return [
            'id' => ['required', 'integer'],
            'title' => ['string'],
            'description' => ['string', 'nullable'],
            'deadline' => ['date_format:d-m-Y H:i:s'],
            'email' => ['email'],
            'category_id' => ['integer'],
            'meeting_list_id' => ['required', 'integer'],
            'is_completed' => ['boolean'],
        ];
    }

    public function validationErrorMessages ($args = [])
    {
        return [
            'id.required' => 'Please provide the task id',
            'deadline.date' => 'Deadline is not in a correct format',
            'meeting_list_id.required' => 'Please provide the meeting list id',
            'email.email' => 'Please provide a valid email'
        ];
    }

    public function resolve($root, $args, SelectFields $fields)
    {
        try{
            $task = Task::findOrFail($args['id']);
        }
        catch (ModelNotFoundException $e){
            abort(403, $e->getMessage());
        }

        $task->title = $args['title'] ?? $task->title;
        if ($args['title']){
            $task->title = encrypt($args['title']);
        }

        $task->is_completed = $args['is_completed'] ?? $task->is_completed;

        if(isset($args['description'])){
            if ($args['description'] == ""){
                $task->description = encrypt($args['description']);
            }
            else{
                if($args['description']){
                    $task->description = encrypt($args['description']);
                }
            }
        }

        $mailService = new MailService();

        if(!empty($args['deadline'])){
            $task->deadline = new Carbon($args['deadline']);
        }

        if(!empty($args['email'])){

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

        $task->save();

        return $task;
    }
}