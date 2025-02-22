<?php
// This class was automatically generated by a giiant build task.
// You should not change it manually as it will be overwritten on next build.

namespace rhertogh\Yii2Oauth2Server\models\base;

use Yii;

/**
 * This is the base-model class for table "oauth2_scope".
 *
 * @property integer $id
 * @property string $identifier
 * @property string $description
 * @property string $authorization_message
 * @property integer $applied_by_default
 * @property boolean $required_on_authorization
 * @property boolean $enabled
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property \rhertogh\Yii2Oauth2Server\models\Oauth2AccessTokenScope[] $accessTokenScopes
 * @property \rhertogh\Yii2Oauth2Server\models\Oauth2AccessToken[] $accessTokens
 * @property \rhertogh\Yii2Oauth2Server\models\Oauth2AuthCodeScope[] $authCodeScopes
 * @property \rhertogh\Yii2Oauth2Server\models\Oauth2AuthCode[] $authCodes
 * @property \rhertogh\Yii2Oauth2Server\models\Oauth2ClientScope[] $clientScopes
 * @property \rhertogh\Yii2Oauth2Server\models\Oauth2Client[] $clients
 * @property \rhertogh\Yii2Oauth2Server\models\Oauth2UserClientScope[] $userClientScopes
 * @property \rhertogh\Yii2Oauth2Server\models\Oauth2UserClient[] $userClients
 * @property string $aliasModel
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
abstract class Oauth2Scope extends \rhertogh\Yii2Oauth2Server\models\base\Oauth2BaseActiveRecord
{




    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['identifier', 'created_at', 'updated_at'], 'required'],
            [['description', 'authorization_message'], 'string'],
            [['applied_by_default', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['applied_by_default', 'created_at', 'updated_at'], 'integer'],
            [['required_on_authorization', 'enabled'], 'boolean'],
            [['identifier'], 'string', 'max' => 255],
            [['identifier'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('oauth2', 'ID'),
            'identifier' => Yii::t('oauth2', 'Identifier'),
            'description' => Yii::t('oauth2', 'Description'),
            'authorization_message' => Yii::t('oauth2', 'Authorization Message'),
            'applied_by_default' => Yii::t('oauth2', 'Applied By Default'),
            'required_on_authorization' => Yii::t('oauth2', 'Required On Authorization'),
            'enabled' => Yii::t('oauth2', 'Enabled'),
            'created_at' => Yii::t('oauth2', 'Created At'),
            'updated_at' => Yii::t('oauth2', 'Updated At'),
        ];
    }
    
    /**
     * @return \rhertogh\Yii2Oauth2Server\interfaces\models\queries\Oauth2AccessTokenScopeQueryInterface     */
    public function getAccessTokenScopes()
    {
        return $this->hasMany(\rhertogh\Yii2Oauth2Server\models\Oauth2AccessTokenScope::className(), ['scope_id' => 'id'])->inverseOf('scope');
    }
    
    /**
     * @return \rhertogh\Yii2Oauth2Server\interfaces\models\queries\Oauth2AccessTokenQueryInterface     */
    public function getAccessTokens()
    {
        return $this->hasMany(\rhertogh\Yii2Oauth2Server\models\Oauth2AccessToken::className(), ['id' => 'access_token_id'])->via('accessTokenScopes');
    }
    
    /**
     * @return \rhertogh\Yii2Oauth2Server\interfaces\models\queries\Oauth2AuthCodeScopeQueryInterface     */
    public function getAuthCodeScopes()
    {
        return $this->hasMany(\rhertogh\Yii2Oauth2Server\models\Oauth2AuthCodeScope::className(), ['scope_id' => 'id'])->inverseOf('scope');
    }
    
    /**
     * @return \rhertogh\Yii2Oauth2Server\interfaces\models\queries\Oauth2AuthCodeQueryInterface     */
    public function getAuthCodes()
    {
        return $this->hasMany(\rhertogh\Yii2Oauth2Server\models\Oauth2AuthCode::className(), ['id' => 'auth_code_id'])->via('authCodeScopes');
    }
    
    /**
     * @return \rhertogh\Yii2Oauth2Server\interfaces\models\queries\Oauth2ClientScopeQueryInterface     */
    public function getClientScopes()
    {
        return $this->hasMany(\rhertogh\Yii2Oauth2Server\models\Oauth2ClientScope::className(), ['scope_id' => 'id'])->inverseOf('scope');
    }
    
    /**
     * @return \rhertogh\Yii2Oauth2Server\interfaces\models\queries\Oauth2ClientQueryInterface     */
    public function getClients()
    {
        return $this->hasMany(\rhertogh\Yii2Oauth2Server\models\Oauth2Client::className(), ['id' => 'client_id'])->via('clientScopes');
    }
    
    /**
     * @return \rhertogh\Yii2Oauth2Server\interfaces\models\queries\Oauth2UserClientScopeQueryInterface     */
    public function getUserClientScopes()
    {
        return $this->hasMany(\rhertogh\Yii2Oauth2Server\models\Oauth2UserClientScope::className(), ['scope_id' => 'id'])->inverseOf('scope');
    }
    
    /**
     * @return \rhertogh\Yii2Oauth2Server\interfaces\models\queries\Oauth2UserClientQueryInterface     */
    public function getUserClients()
    {
        return $this->hasMany(\rhertogh\Yii2Oauth2Server\models\Oauth2UserClient::className(), ['user_id' => 'user_id', 'client_id' => 'client_id'])->via('userClientScopes');
    }


    
    /**
     * @inheritdoc
     * @return \rhertogh\Yii2Oauth2Server\interfaces\models\queries\Oauth2ScopeQueryInterface the active query used by this AR class.
     */
    public static function find()
    {
        return Yii::createObject(\rhertogh\Yii2Oauth2Server\interfaces\models\queries\Oauth2ScopeQueryInterface::class, [get_called_class()]);
    }


}
