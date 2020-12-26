<?php

declare(strict_types=1);

namespace App\Application\Security;

use App\Domain\Todo\Entity\TaskEntity;
use App\Domain\Todo\Entity\UserEntity;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class TaskVoter extends Voter
{
    const VIEW = 'view';
    const EDIT = 'edit';

    protected function supports(string $attribute, $subject)
    {
        if (!in_array($attribute, [self::VIEW, self::EDIT])) {
            return false;
        }

        if (!$subject instanceof TaskEntity) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof UserEntity) {
            return false;
        }

        /** @var TaskEntity $task */
        $task = $subject;

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($task, $user);
            case self::EDIT:
                return $this->canEdit($task, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canView(TaskEntity $task, UserEntity $user)
    {
        if ($this->canEdit($task, $user)) {
            return true;
        }

        return false;
    }

    private function canEdit(TaskEntity $task, UserEntity $user)
    {
        return $user->getId() === $task->getUserId();
    }
}
