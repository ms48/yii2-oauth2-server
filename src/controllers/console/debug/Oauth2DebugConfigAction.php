<?php

namespace rhertogh\Yii2Oauth2Server\controllers\console\debug;

use League\OAuth2\Server\Grant\GrantTypeInterface;
use rhertogh\Yii2Oauth2Server\controllers\console\Oauth2DebugController;
use rhertogh\Yii2Oauth2Server\Oauth2Module;
use yii\base\Action;
use yii\console\ExitCode;
use yii\console\widgets\Table;

/**
 * @property Oauth2DebugController $controller
 */
class Oauth2DebugConfigAction extends Action
{
    public function run()
    {
        $module = $this->controller->module;

        $configuration = $this->getConfiguration($module);

        $this->controller->stdout('Configuration:' . PHP_EOL);
        $this->controller->stdout(Table::widget([
            'headers' => ['Setting', 'Value'],
            'rows' => array_map(fn($setting) => [$setting, $configuration[$setting]], array_keys($configuration)),
        ]));

        $endpoints = $this->getEndpoints($module);

        $this->controller->stdout(PHP_EOL);
        $this->controller->stdout('Endpoints:' . PHP_EOL);
        $this->controller->stdout(Table::widget([
            'headers' => ['Endpoint', 'URL', 'Setting(s)'],
            'rows' => $endpoints,
        ]));

        return ExitCode::OK;
    }

    /**
     * @param Oauth2Module $module
     * @return array
     */
    protected function getConfiguration($module)
    {
        $serverRoles = [];
        if ($module->serverRole & Oauth2Module::SERVER_ROLE_AUTHORIZATION_SERVER) {
            $serverRoles[] = 'Authorization Server';
            $grantTypes = implode(', ', array_map(
                fn(GrantTypeInterface $grant) => $grant->getIdentifier(),
                $module->getAuthorizationServer()->getEnabledGrantTypes()
            ));
        } else {
            $grantTypes = '-';
        }

        if ($module->serverRole & Oauth2Module::SERVER_ROLE_RESOURCE_SERVER) {
            $serverRoles[] = 'Resource Server';
        }

        $privateKey = $module->privateKey ? '[SET]' : '[NOT SET]';
        $privateKeyPassphrase = $module->privateKeyPassphrase ? '[SET]' : '[NOT SET]';
        $publicKey = $module->publicKey ? '[SET]' : '[NOT SET]';
        $codesEncryptionKey = $module->codesEncryptionKey ? '[SET]' : '[NOT SET]';
        $storageEncryptionKeys = $module->storageEncryptionKeys ? '[SET]' : '[NOT SET]';

        return [
            'serverRole' => $module->serverRole . ' (' . implode(', ', $serverRoles) . ')',

            'privateKey' => $privateKey,
            'privateKeyPassphrase' => $privateKeyPassphrase,
            'publicKey' => $publicKey,
            'codesEncryptionKey' => $codesEncryptionKey,
            'storageEncryptionKeys' => $storageEncryptionKeys,
            'defaultStorageEncryptionKey' => $module->defaultStorageEncryptionKey,

            'identityClass' => $module->identityClass,

            'urlRulesPrefix' => $module->urlRulesPrefix,
            'authorizePath' => $module->authorizePath,
            'accessTokenPath' => $module->accessTokenPath,
            'jwksPath' => $module->jwksPath,
            'clientAuthorizationUrl' => $module->clientAuthorizationUrl,
            'clientAuthorizationPath' => $module->clientAuthorizationPath,
            'clientAuthorizationView' => $module->clientAuthorizationView,
            'openIdConnectUserinfoPath' => $module->openIdConnectUserinfoPath,

            'grantTypes' => $grantTypes,

            'defaultAccessTokenTTL' => $module->defaultAccessTokenTTL,
            'resourceServerAccessTokenRevocationValidation' => $module->resourceServerAccessTokenRevocationValidation,

            'enableOpenIdConnect' => $module->enableOpenIdConnect ? 'true' : 'false',
            'enableOpenIdConnectDiscovery' => $module->enableOpenIdConnectDiscovery ? 'true' : 'false',
            'openIdConnectDiscoveryIncludeSupportedGrantTypes' =>
                $module->openIdConnectDiscoveryIncludeSupportedGrantTypes ? 'true' : 'false',
            'openIdConnectUserinfoEndpoint' => $module->openIdConnectUserinfoEndpoint ? 'true' : 'false',
            'openIdConnectDiscoveryServiceDocumentationUrl' => $module->openIdConnectDiscoveryServiceDocumentationUrl,
            'openIdConnectIssueRefreshTokenWithoutOfflineAccessScope' =>
                $module->openIdConnectIssueRefreshTokenWithoutOfflineAccessScope ? 'true' : 'false',

            'defaultUserAccountSelection' => $module->defaultUserAccountSelection,

            'displayConfidentialExceptionMessages' => $module->displayConfidentialExceptionMessages === null
                ? 'null'
                : ($module->displayConfidentialExceptionMessages ? 'true' : 'false'),
        ];
    }

    /**
     * @param Oauth2Module $module
     * @return array
     */
    protected function getEndpoints($module)
    {
        if ($module->serverRole & Oauth2Module::SERVER_ROLE_AUTHORIZATION_SERVER) {
            $authorizeClientValue = $module->urlRulesPrefix . '/' . $module->authorizePath;
            $authorizeClientSettings = 'urlRulesPrefix, authorizePath';

            $accessTokenValue = $module->urlRulesPrefix . '/' . $module->accessTokenPath;
            $accessTokenSettings = 'urlRulesPrefix, accessTokenPath';

            $jwksValue = $module->urlRulesPrefix . '/' . $module->jwksPath;
            $jwksSettings = 'urlRulesPrefix, jwksPath';

            $clientAuthorizationValue = $module->urlRulesPrefix . '/' . $module->clientAuthorizationPath;
            $clientAuthorizationSettings = 'urlRulesPrefix, clientAuthorizationPath';

            if ($module->enableOpenIdConnect) {
                if (!empty($module->openIdConnectUserinfoEndpoint)) {
                    if ($module->openIdConnectUserinfoEndpoint === true) {
                        $oidcUserinfoValue = $module->urlRulesPrefix . '/' . $module->openIdConnectUserinfoPath;
                        $oidcUserinfoSettings = 'urlRulesPrefix, openIdConnectUserinfoPath';
                    } else {
                        $oidcUserinfoValue = $module->openIdConnectUserinfoEndpoint;
                        $oidcUserinfoSettings = 'openIdConnectUserinfoEndpoint';
                    }
                } else {
                    $oidcUserinfoValue = '[Userinfo Endpoint is disabled]';
                    $oidcUserinfoSettings = '-';
                }
            } else {
                $oidcUserinfoValue = '[OpenID Connect is disabled]';
                $oidcUserinfoSettings = '-';
            }
        } else {
            $authorizeClientValue = '[Only available for "authorization_server" role]';
            $authorizeClientSettings = '-';

            $accessTokenValue = '[Only available for "authorization_server" role]';
            $accessTokenSettings = '-';

            $jwksValue = '[Only available for "authorization_server" role]';
            $jwksSettings = '-';

            $clientAuthorizationValue = '[Only available for "authorization_server" role]';
            $clientAuthorizationSettings = '-';

            $oidcUserinfoValue = '[Only available for "authorization_server" role]';
            $oidcUserinfoSettings = '-';
        }

        return [
            'authorizeClient' => ['Authorize Client', $authorizeClientValue, $authorizeClientSettings],
            'accessToken' => ['Access Token', $accessTokenValue, $accessTokenSettings],
            'jwks' => ['JSON Web Key Sets', $jwksValue, $jwksSettings],
            'clientAuthorization' => ['Client Authorization', $clientAuthorizationValue, $clientAuthorizationSettings],
            'oidcUserinfo' => ['OpenId Connect Userinfo', $oidcUserinfoValue, $oidcUserinfoSettings],
        ];
    }
}
