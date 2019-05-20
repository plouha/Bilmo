<?php

namespace App\Security\Voter;

use App\Entity\User;
use App\Entity\Client;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class UserVoter extends Voter
{
    const VIEW = 'view';
    const DELETE = 'delete';
    
    protected function supports($attribute, $subject)
    {
     // if the attribute isn't one we support, return false
    if (!in_array($attribute, array(self::VIEW, self::DELETE))) {
        return false;
    }
    // only vote on User objects inside this voter
    if (!$subject instanceof User) {
        return false;
        }

    return true;
    }
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $client = $token->getUser();
        if (!$client instanceof Client) {
            // the client must be logged in; if not, deny access
            return false;
        }
        $user = $subject;
        switch ($attribute) {
            case self::VIEW:
                return $this->hasRight($user, $client);
            case self::DELETE:
                return $this->hasRight($user, $client);
        }
    }

    private function hasRight(User $user, Client $client)
    {
        return $client === $user->getClient();
    }
}





/*    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['POST_EDIT', 'POST_VIEW'])
            && $subject instanceof \App\Entity\BlogPost;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'POST_EDIT':
                // logic to determine if the user can EDIT
                // return true or false
                break;
            case 'POST_VIEW':
                // logic to determine if the user can VIEW
                // return true or false
                break;
        }

        return false;
    }
}*/
