<?php

namespace Khoatran\CarForRent\Transformer;

use Khoatran\CarForRent\Model\User;

class UserTransformer
{
    public function toArray(User $user): array
    {
        return [
            'id' => $user->getId(),
            'username' => $user->getUsername(),
            'fullName' => $user->getFullname(),
            'phoneNumber' => $user->getPhoneNumber(),
            'role' => $user->getRole(),
        ];
    }
}
