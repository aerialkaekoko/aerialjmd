<?php

namespace App\Http;

use Alexusmai\LaravelFileManager\Services\ACLService\ACLRepository;

class UsersACLRepository implements ACLRepository
{
    /**
     * Get user ID
     *
     * @return mixed
     */
    public function getUserID()
    {
        return \Auth::id();
    }

    /**
     * Get ACL rules list for user
     *
     * @return array
     */
    public function getRules(): array
    {
        if (\Auth::id() === 1) {
            return [
                ['disk' => 'files', 'path' => '*', 'access' => 2],
            ];
        }
        
        return [
            ['disk' => 'files', 'path' => '/', 'access' => 1],                                  // main folder - read
            ['disk' => 'files', 'path' => 'user', 'access' => 1],                              // only read
            ['disk' => 'files', 'path' => 'user/'. \Auth::user()->name, 'access' => 1],        // only read
            ['disk' => 'files', 'path' => 'user/'. \Auth::user()->name .'/*', 'access' => 2],  // read and write
        ];
    }
}