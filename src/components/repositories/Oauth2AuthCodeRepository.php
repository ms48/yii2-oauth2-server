<?php

namespace rhertogh\Yii2Oauth2Server\components\repositories;

use League\OAuth2\Server\Entities\AuthCodeEntityInterface;
use rhertogh\Yii2Oauth2Server\components\repositories\base\Oauth2BaseTokenRepository;
use rhertogh\Yii2Oauth2Server\components\repositories\traits\Oauth2RepositoryIdentifierTrait;
use rhertogh\Yii2Oauth2Server\interfaces\components\repositories\Oauth2AuthCodeRepositoryInterface;
use rhertogh\Yii2Oauth2Server\interfaces\models\Oauth2AuthCodeInterface;

class Oauth2AuthCodeRepository extends Oauth2BaseTokenRepository implements Oauth2AuthCodeRepositoryInterface
{
    use Oauth2RepositoryIdentifierTrait;

    /**
     * @inheritDoc
     * @return class-string<Oauth2AuthCodeInterface>
     */
    public function getModelClass()
    {
        return Oauth2AuthCodeInterface::class;
    }

    /**
     * @inheritDoc
     */
    public function getNewAuthCode()
    {
        return static::getNewTokenInternally();
    }

    /**
     * @inheritDoc
     */
    public function persistNewAuthCode(AuthCodeEntityInterface $authCodeEntity)
    {
        static::persistToken($authCodeEntity);
    }

    /**
     * @inheritDoc
     */
    public function revokeAuthCode($codeId)
    {
        static::revokeToken($codeId);
    }

    /**
     * @inheritDoc
     */
    public function isAuthCodeRevoked($codeId)
    {
        return static::isTokenRevoked($codeId);
    }
}
