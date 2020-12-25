<?php

declare(strict_types=1);

namespace App\Application\Security;

use App\Domain\Todo\Port\UserRepositoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class ApiTokenAuthenticator extends AbstractGuardAuthenticator
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepo;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function supports(Request $request)
    {
        // look for header "Authorization: Bearer <token>"
        return $request->headers->has('Authorization')
            && 0 === strpos($request->headers->get('Authorization'), 'Bearer ');

    }

    public function getCredentials(Request $request)
    {
        $authorizationHeader = $request->headers->get('Authorization');
        // skip beyond "Bearer "
        $token = substr($authorizationHeader, 7);
        return substr($authorizationHeader, 7);
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $user = $this->userRepo->findByToken($credentials);
        if (!$user) {
            return null;
        }
        return $userProvider->loadUserByUsername($user->getUserName() ?? '');
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        if (!$user) {
            throw new AuthenticationException();
        }

        return true;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $data = [
            // you may want to customize or obfuscate the message first
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData())

            // or to translate this message
            // $this->translator->trans($exception->getMessageKey(), $exception->getMessageData())
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $providerKey)
    {
        // TODO: Implement onAuthenticationSuccess() method.
    }

    public function supportsRememberMe()
    {
        // TODO: Implement supportsRememberMe() method.
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        return new Response('Auth header required', 401);
    }
}

