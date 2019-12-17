<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgotRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Note;
use App\Src\models\authModel\AuthModel;
use App\Src\models\authModel\AuthResetModel;
use App\Src\services\mailService\MailService;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            $response = new \stdClass();
            $response->message = 'Unable to sign in. Check your email/password';

            return response()->json($response, 401);
        }

        $user = User::where('email', request('email'))->first();

        return $this->respondWithToken($token, $user);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, User $user = null)
    {
        $response = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
        ];

        if ($user){
            $response['user'] = $user;
        }

        return response()->json($response);
    }

    public function register(RegisterRequest $request)
    {

        $user = new User();

//        $user = User::where('afas_id', $request['email'])->first();
//
//        if(!isset($user)) {
//            return response()->json([
//                'message' => 'Emailadres is niet toegestaan!'
//            ], 401);
//        }

//        dd($request['password'],$request['password_confirmation']);

        $authModel = new AuthModel();
        $authModel->setFirstName($request['first_name'] ?? '');
        $authModel->setLastName($request['last_name'] ?? '');
        $authModel->setEmail($request['email'] ?? '');
        $authModel->setPassword($request['password'] ?? '');
        $authModel->setPasswordRepeat($request['password_confirmation'] ?? '');


        $user->email = $request['email'];

        $user->password = Hash::make($authModel->getPassword());

        $user->save();

        $note = new Note();

        $note->text = " ";
        $note->user_id = $user->id;

        $note->save();

        $user->note = $note;

        $mailingService = new MailService();
        $mailingService->sendRegisterMail($user);

        return response()->json([
            'message' => 'Check your inbox!'
        ], 200);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $authModel = new AuthResetModel();
        $authModel->setEmail($request['email']);
        $authModel->setPassword($request['password']);
        $authModel->setPasswordRepeat($request['password_confirmation']);
        $authModel->setResetToken($request['reset_token']);

        $check = $this->checkResetToken($authModel);

        if ($check instanceof \Throwable){
            return response()->json([
                'message' => $check->getMessage()
            ], 400);
        }

        try{
            $user = User::where('email', $authModel->getEmail())->first();
            $user->password = Hash::make($authModel->getPassword());
            $user->update();

            return response()->json([
                'message' => 'Password has been reset'
            ], 200);
        }
        catch (\Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function forgot(ForgotRequest $request)
    {
        $user = User::where('email', $request['email'])->first();

        $service = new MailService();
        $service->sendRequestPasswordResetMail($user);

        return response()->json([
            'message' => 'Email send, Check your inbox'
        ], 200);
    }

    /**
     * @param AuthResetModel $authResetModel
     * @return bool|Exception
     */
    public function checkResetToken(AuthResetModel $authResetModel)
    {
        $token = DB::table('password_resets')
            ->where('email', '=', $authResetModel->getEmail())
//            ->where('token', '=', Hash::make($authResetModel->getResetToken()))
            ->where('created_at', '>', Carbon::now()->subHours(1))
            ->first();

        try {
            if (!$token || !Hash::check($authResetModel->getResetToken(), $token->token)) {
                throw new Exception('Deze link is verlopen of bestaat niet');
            }

            DB::table('password_resets')
                ->where('email', '=', $authResetModel->getEmail())
                ->where('token', $authResetModel->getResetToken())
                ->delete();

            return true;
        } catch (\Exception $e) {
            return $e;
        }
    }
}
