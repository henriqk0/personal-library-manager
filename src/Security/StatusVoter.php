<?php

namespace App\Security;

use App\Entity\User;
use App\Entity\Status;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;


class StatusVoter extends Voter
{
    const VIEW = "view";
    const EDIT = "edit";
    const DELETE = "edit";

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

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token, ?Vote $vote = null): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            $vote?->addReason('The user is not logged in.');
            return false;
        }

        $status = $subject;
        return match($attribute) {
            self::VIEW => $this->canView($status, $user),
            self::EDIT => $this->canView($status, $user, $vote),
            self::DELETE => $this->canView($status, $user),
            default => throw new \LogicException('This code shoud not be reached!')
        };
    }

    private function canView(Status $status, User $user): bool
    {
        if ($this->canEdit($status, $user)) {
            return true;
        }
        return !$status->isPrivate();
    }

    private function canEdit(Status $status, User $user, ?Vote $vote): bool
    {
        if ($user === $status->getReader()) {
            return true;
        }

        $vote?->addReason(sprintf('The logged in user (username: $s) is not the reader of this (id: %d: $).',
            $user->getEmail(), $status->getId()));

        return false;
    }
}

