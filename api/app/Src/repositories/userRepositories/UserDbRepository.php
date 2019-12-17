<?php

namespace App\Src\repositories\userRepositories;

use App\GraphQLModel;
use App\Src\mappings\tokenModelMapping\TokenModelMapping;
use App\Src\mappings\userDbModelMappings\UserDbModelMapping;
use App\Src\models\authModel\AuthModel;
use App\Src\models\authModel\AuthResetModel;
use App\Src\models\TokenModel\TokenModel;
use App\Src\models\userModels\UserModel;
use App\Src\services\mailService\MailService;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserDbRepository implements IUserRepository
{
    /**
     * @param $id
     * @param $fields
     * @return UserModel|Exception
     */
    public function findById($id, $fields)
    {
        $user = User::where('id', $id)->select($fields)->first();
        try{
            if(!$user){
                throw new Exception('User not found');
            }
        }
        catch (Exception $e){
            return $e;
        }

        return UserDbModelMapping::toUserModelMapping($user);
    }

    /**
     * @param string $string
     * @return Collection
     */
    public function search(string $string)
    {
        $users = User::where('first_name', 'LIKE', '%' . $string . '%')
            ->orWhere('last_name', 'LIKE', '%' . $string . '%')
            ->orWhere('email', 'LIKE', '%' . $string . '%')
            ->get();

        $collection = collect();

        foreach($users as $user){
            $collection->push(UserDbModelMapping::toUserModelMapping($user));
        }

        return $collection;
    }

    /**
     * @param AuthModel $authModel
     * @return UserModel|Exception|mixed
     */
    public function create(AuthModel $authModel)
    {
        try {
            if (User::where('email', $authModel->getEmail())->first()) {
                throw new Exception('Email already taken');
            }
        }
        catch (Exception $e){
            return $e;
        }

        try{
            $user = new User();
            $user->first_name = $authModel->getFirstName();
            $user->last_name = $authModel->getLastName();
            $user->name = $authModel->getFullName();
            $user->email = $authModel->getEmail();
            $user->password = Hash::make($authModel->getPassword());

            $user->save();
        }
        catch (\Exception $e){
            return $e;
        }

        $mailingService = new MailService();
        $mailingService->sendRegisterMail(UserDbModelMapping::toUserModelMapping($user));

        return UserDbModelMapping::toUserModelMapping($user);
    }

    /**
     * @param UserModel $userModel
     * @return UserModel|\Exception
     */
    public function edit(UserModel $userModel)
    {
        $user = User::where('email', $userModel->getEmail())->first();

        try {
            if (!$user) {
                throw new Exception('user not found');
            }
        }
        catch (Exception $e){
            return $e;
        }

        try {
            $user->first_name = $userModel->getFirstName();
            $user->last_name = $userModel->getLastName();
            $user->password = Hash::make($userModel->getPassword());
            $user->name = $userModel->getFullName();
            $user->save();
        } catch (Exception $e) {
            return $e;
        }

        return UserDbModelMapping::toUserModelMapping($user);
    }

    /**
     * @param AuthModel $authModel
     * @return GraphQLModel|Exception|mixed
     */
    public function login(AuthModel $authModel)
    {
        $user = User::whereEmail($authModel->getEmail())->first();

        try{
            if (!$user || !Hash::check($authModel->getPassword(), $user->password)) {
                throw new Exception('email/password combination not found in db');
            }
        }
        catch (Exception $e){
            return $e;
        }

        auth('api')->login($user);

        $tokenModel = new TokenModel(auth('api'), $user);

        return TokenModelMapping::toGraphQLModelMapping($tokenModel);
    }

    /**
     * @param AuthResetModel $authResetModel
     * @return UserModel|bool|Exception
     */
    public function reset(AuthResetModel $authResetModel)
    {
        $check = $this->checkResetToken($authResetModel);

        if ($check instanceof \Throwable){
            return $check;
        }

        try{
            $user = User::where('email', $authResetModel->getEmail())->first();
            $user->password = Hash::make($authResetModel->getPassword());
            $user->update();
        }
        catch (\Exception $e){
            return $e;
        }

        return UserDbModelMapping::toUserModelMapping($user);
    }

    /**
     * @param AuthResetModel $authResetModel
     * @return bool|Exception
     */
    public function checkResetToken(AuthResetModel $authResetModel)
    {
        $token = DB::table('password_resets')
                    ->where('email', '=', $authResetModel->getEmail())
                    ->where('token', '=', $authResetModel->getResetToken())
                    ->where('created_at', '>', Carbon::now()->subHours(1))
                    ->first();

        try{
            if (!$token){
                throw new Exception('Deze link is verlopen of bestaat niet');
            }

            DB::table('password_resets')
                ->where('email', '=', $authResetModel->getEmail())
                ->where('token', $authResetModel->getResetToken())
                ->delete();

            return true;
        }
        catch (\Exception $e){
            return $e;
        }
    }
}