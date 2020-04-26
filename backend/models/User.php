<?php
/**
 * User: TheCodeholic
 * Date: 4/26/2020
 * Time: 5:37 PM
 */

namespace backend\models;


/**
 * Class User
 *
 * @author  Zura Sekhniashvili <zurasekhniashvili@gmail.com>
 * @package backend\models
 */
class User extends \common\models\User
{
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => self::class, 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => self::class, 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['password_repeat', 'required'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],
        ];
    }

    public function createUser($data, UserProfile $profile)
    {
        if (!$this->load($data) || !$profile->load($data) || !$this->save()) {
            return false;
        }
        //TODO Send email
        $profile->user_id = $this->id;
        $this->link('profile', $profile);
        return true;
    }
}