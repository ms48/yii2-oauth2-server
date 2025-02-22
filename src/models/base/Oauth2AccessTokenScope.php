<?php
// This class was automatically generated by a giiant build task.
// You should not change it manually as it will be overwritten on next build.

namespace rhertogh\Yii2Oauth2Server\models\base;

use Yii;

/**
 * This is the base-model class for table "oauth2_access_token_scope".
 *
 * @property integer $access_token_id
 * @property integer $scope_id
 * @property integer $created_at
 *
 * @property \rhertogh\Yii2Oauth2Server\models\Oauth2AccessToken $accessToken
 * @property \rhertogh\Yii2Oauth2Server\models\Oauth2Scope $scope
 * @property string $aliasModel
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
abstract class Oauth2AccessTokenScope extends \rhertogh\Yii2Oauth2Server\models\base\Oauth2BaseActiveRecord
{




    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['access_token_id', 'scope_id', 'created_at'], 'required'],
            [['access_token_id', 'scope_id', 'created_at'], 'default', 'value' => null],
            [['access_token_id', 'scope_id', 'created_at'], 'integer'],
            [['access_token_id', 'scope_id'], 'unique', 'targetAttribute' => ['access_token_id', 'scope_id']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'access_token_id' => Yii::t('oauth2', 'Access Token ID'),
            'scope_id' => Yii::t('oauth2', 'Scope ID'),
            'created_at' => Yii::t('oauth2', 'Created At'),
        ];
    }
    
    /**
     * @return \rhertogh\Yii2Oauth2Server\interfaces\models\queries\Oauth2AccessTokenQueryInterface     */
    public function getAccessToken()
    {
        return $this->hasOne(\rhertogh\Yii2Oauth2Server\models\Oauth2AccessToken::className(), ['id' => 'access_token_id'])->inverseOf('accessTokenScopes');
    }
    
    /**
     * @return \rhertogh\Yii2Oauth2Server\interfaces\models\queries\Oauth2ScopeQueryInterface     */
    public function getScope()
    {
        return $this->hasOne(\rhertogh\Yii2Oauth2Server\models\Oauth2Scope::className(), ['id' => 'scope_id'])->inverseOf('accessTokenScopes');
    }


    
    /**
     * @inheritdoc
     * @return \rhertogh\Yii2Oauth2Server\interfaces\models\queries\Oauth2AccessTokenScopeQueryInterface the active query used by this AR class.
     */
    public static function find()
    {
        return Yii::createObject(\rhertogh\Yii2Oauth2Server\interfaces\models\queries\Oauth2AccessTokenScopeQueryInterface::class, [get_called_class()]);
    }


}
