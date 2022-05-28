<?php

namespace Khoatran\CarForRent\Transformer;

use Khoatran\CarForRent\Model\UserModel;

class UserTransformer
{
    public function toArray(UserModel $user): array
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
