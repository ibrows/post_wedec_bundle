<?php


namespace Ibrows\PostWedecBundle\Api\Delivery\WedecDeliveryBundle\Util;


use Ibrows\PostWedecBundle\Api\Delivery\WedecDeliveryBundle\Model\WedecOAuthClientInterface;

class WedecOAuthUriBuilder
{
    const OAUTH_TYPE_CREDENTIALS    = 'client_credentials';

    // Parameter keys
    const PARAMS_GRANT_TYPE_KEY     = 'grant_type';
    const PARAMS_CLIENT_ID_KEY      = 'client_id';
    const PARAMS_CLIENT_SECRET_KEY  = 'client_secret';
    const PARAMS_SCOPE_KEY          = 'scope';

    const OAUTH_URI_POSTFIX = '/WEDECOAuth/authorization?';

    /**
     * @param WedecOAuthClientInterface $authClient
     * @param string $scope
     * @return array
     */
    public static function getOAuthParametersWithCredentials(WedecOAuthClientInterface $authClient, $scope)
    {
        return [
            self::PARAMS_GRANT_TYPE_KEY       => self::OAUTH_TYPE_CREDENTIALS,
            self::PARAMS_CLIENT_ID_KEY        => $authClient->getClientId(),
            self::PARAMS_CLIENT_SECRET_KEY    => $authClient->getClientSecret(),
            self::PARAMS_SCOPE_KEY            => $scope,
        ];
    }

    /**
     * @param WedecOAuthClientInterface $authClient
     * @param string $scope
     * @return string
     */
    public static function getOAuthUriParametersWithCredentials(WedecOAuthClientInterface $authClient, $scope)
    {
        $oauthUriParams = self::PARAMS_GRANT_TYPE_KEY . '=' . self::OAUTH_TYPE_CREDENTIALS . '&';
        $oauthUriParams .= self::PARAMS_CLIENT_ID_KEY . '=' . $authClient->getClientId() . '&';
        $oauthUriParams .= self::PARAMS_CLIENT_SECRET_KEY . '=' . $authClient->getClientSecret() . '&';
        $oauthUriParams .= self::PARAMS_SCOPE_KEY . '=' . $scope;

        return $oauthUriParams;
    }

    /**
     * @param string $baseUri
     * @return string
     */
    public static function getOAuthUriPrefix(string $baseUri)
    {
        return $baseUri . WedecOAuthUriBuilder::OAUTH_URI_POSTFIX;
    }

    public static function getOAuthUri(string $baseUri, WedecOAuthClientInterface $authClient, string $scope)
    {
        return self::getOAuthUriPrefix($baseUri) . self::getOAuthUriParametersWithCredentials($authClient, $scope);
    }

    /**
     * @param string $token
     * @return array
     */
    public static function authorizationHeadersWithToken(string $token)
    {
        return [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'authorization' => 'Bearer ' . $token,
        ];
    }

    public static function contentTypeUrlEncoded()
    {
        return [
            'Content-Type' => 'application/x-www-form-urlencoded',
        ];
    }
}