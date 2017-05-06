<?php
namespace api\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;


/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_NOT_ACTIVE = 5;
    const STATUS_ACTIVE = 10;

    public $password;
    public $password_old;
    public $password_repeat;
    public $role;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_at',
                ],
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],

            [['username', 'email'], 'required'],
            [['created_at', 'updated_at', 'role', 'full_name', 'display_name'], 'safe'],
            [['username', 'email', 'password', 'password_reset_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['password_hash'], 'string', 'max' => 60],

            ['username', 'validateUsername'],
            ['email', 'required', 'on' => 'request_reset_password'],
            [['password', 'password_old', 'password_repeat'], 'required', 'on' => 'resetPassword'],
            ['password_old', 'passwordValidation'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],
            ['password', 'required', 'on' => 'register'],
        ];
    }


    public function validateUsername($attribute, $params)
    {
        if (preg_match('/[^a-z])/i', $this->$attribute)) {
             $this->addError($attribute, 'Username should only contain alphabets');
        }
        if ( ! preg_match('/^.{3,15}$/', $this->$attribute) ) {
             $this->addError($attribute, 'Username must be between 3 to 15 characters.');
        }
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_key' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function getFullname(){
        return $this->username;
    }

    /**
     * Validate password when resetting
     */
    public function passwordValidation()
    {
        $user = static::findOne(Yii::$app->user->id);

        if (!$user || !$user->validatePassword($this->password_old)) {
            $this->addError('password_old', Yii::t('app', 'The old password is not correct.'));
        }
    }

    /**
     * Check permission of accessed model by current user.
     */
    public function checkPermission()
    {
        if ((Yii::$app->user->can('superadmin') && $this->id !== Yii::$app->user->id)
            || (Yii::$app->user->can('administrator') && !Yii::$app->authManager->checkAccess($this->id,
                    'administrator'))
        ) {
            return true;
        }

        return false;
    }

    /**
     * Get array of user status.
     *
     * @return array
     */
    public function getStatuses()
    {
        return [
            self::STATUS_ACTIVE => "Active",
            self::STATUS_NOT_ACTIVE => "Not Active",
            self::STATUS_DELETED => "Deleted",
        ];
    }

    /**
     * Get text from user status.
     *
     * @return string
     */
    public function getStatusText()
    {
        $status = $this->getStatuses();

        return isset($status[$this->status]) ? $status[$this->status] : "unknown($this->status)";
    }
}