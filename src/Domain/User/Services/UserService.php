<?php 

namespace Src\Domain\User\Services;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Src\Domain\User\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Src\Infrastructure\Users\Repositories\UserRepository;
use Illuminate\Support\Str;

class UserService
{
    /**
     * @var UserRepository
     */
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function store($request) :JsonResponse
    {
        try 
        {
            $user = $this->repository->store($request);

            return response()->json(
                [
                    'data' => $user,
                    'success' => true
                ],201
            );
            
        } catch(QueryException $e)
        { 
            return response()->json([
                'error' => "Erro ao cadastrar usuário",
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $e) 
        {
            return response()->json([   
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(User $user,Request $request) :JsonResponse
    {
        $user->update($request->all());
        $this->repository->updatePassword($user);
        
        return response()->json([
            'success' => true,
            'data' => [
                $user
            ]
        ],200);
    }

    public function delete($user)
    {
        $this->repository->deleteById($user);
        
        return response()->json(
            ['succes' => true]
        ,200);
    }

    public function forgotPassword($request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status == Password::RESET_LINK_SENT) {
           return[
            'status' => __($status)
           ];
        }

        throw ValidationException::withMessages([
            'email' => [trans($status)],
        ]);
    }

    public function resetPassword($request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            return response([
                'message' => 'Senha com atualizada com Sucesso!'
            ], 200);
        }

        return response([
            'message' => __($status)
        ], 500);
    }
}