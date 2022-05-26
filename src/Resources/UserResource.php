<?php

namespace Khoatran\CarForRent\Resources;

use Khoatran\CarForRent\Model\UserModel;

class UserResource
{
    public function toArray(UserModel $user): array
    {
        return [
            'id' => $user->getId(),
            'username' => $user->getUsername(),
            'fullName' => $user->getFullname(),
            'phoneNumber' => $user->getPhoneNumber(),
            'type' => $user->getType(),
        ];
    }
}
