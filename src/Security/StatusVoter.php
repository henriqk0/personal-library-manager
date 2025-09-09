<?php

namespace App\Security;

use App\Entity\User;
use App\Entity\Status;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

class StatusVoter extends Voter
{
    const VIEW = "view";
    const EDIT = "edit";
    const DELETE = "delete";

    public function __construct(
        private AccessDecisionManagerInterface $_accessDecisionManager,
    ) {
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        if(!in_array($attribute, [self::VIEW, self::EDIT, self::DELETE])){
            return false;
        }

        if(!$subject instanceof Status) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        if ($this->_accessDecisionManager->decide($token, ['ROLE_SUPER_ADMIN'])){
            return true;
        }

        /** @var Status $status */
        $status = $subject;

        return match($attribute) {
            self::VIEW => $this->canManipulate($status, $user),
            self::EDIT => $this->canManipulate($status, $user),
            self::DELETE => $this->canManipulate($status, $user),
            default => throw new \LogicException('This code shoud not be reached!')
        };
    }

    private function __itsOwner(Status $status, User $user): bool 
    {
        return $user === $status->getReader();
    }

    private function canManipulate(Status $status, User $user): bool
    {
        return $this->__itsOwner($status, $user);
    }
}

