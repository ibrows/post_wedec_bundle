<?php


namespace Ibrows\PostWedecBundle\Api\Delivery\Entity;


use JMS\Serializer\Annotation as Serializer;

class WedecOAuthResponse
{
    /**
     * @var string
     * @Serializer\SerializedName("access_token")
     * @Serializer\Type("string")
     */
    private $accessToken;

    /**
     * @var string
     * @Serializer\SerializedName("token_type")
     * @Serializer\Type("string")
     *
     */
    private $tokenType;

    /**
     * @var integer
     * @Serializer\SerializedName("expires_in")
     * @Serializer\Type("integer")
     */
    private $expiresIn;

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    /**
     * @param string $accessToken
     */
    public function setAccessToken(string $accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @return string
     */
    public function getTokenType(): string
    {
        return $this->tokenType;
    }

    /**
     * @param string $tokenType
     */
    public function setTokenType(string $tokenType)
    {
        $this->tokenType = $tokenType;
    }

    /**
     * @return int
     */
    public function getExpiresIn(): int
    {
        return $this->expiresIn;
    }

    /**
     * @param int $expiresIn
     */
    public function setExpiresIn(int $expiresIn)
    {
        $this->expiresIn = $expiresIn;
    }
}