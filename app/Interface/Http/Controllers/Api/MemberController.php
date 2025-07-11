<?php

namespace App\Interface\Http\Controllers\Api;

use App\Application\Auth\UseCase\GetAuthenticatedUser;
use App\Application\Auth\UseCase\LoginUserJwt;
use App\Application\Auth\UseCase\LogoutTokenJwt;
use App\Application\User\DTOs\LoginUserDTO;
use App\Http\Controllers\Controller;
use App\Interface\Http\Requests\LoginRequest;
use App\Traits\ApiResponseTrait;
use Exception;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    use ApiResponseTrait;

    public function __construct() {}

    public function logout(Request $request, LogoutTokenJwt $usecase)
    {
        try {
            $usecase->execute($request);

            return $this
                ->apiResponse()
                ->setMessage('Logged out successfully')
                ->send();
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }

    public function getMe(GetAuthenticatedUser $usecase)
    {
        try {
            $token = $usecase->execute();
            return $this
                ->apiResponse($token)
                ->send();
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }

    public function doLogin(LoginRequest $request, LoginUserJwt $doLogin)
    {
        try {
            $dto = LoginUserDTO::fromRequest($request);
            $items = $doLogin->execute($dto, $request);
            return $this->apiResponse($items)->send();
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }
}
