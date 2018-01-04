<?php

/*
 * This file is part of the Swagger package.
 *
 * (c) EXSyst
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EXSyst\Component\Swagger;

use EXSyst\Component\Swagger\Parts\DescriptionPart;
use EXSyst\Component\Swagger\Util\MergeHelper;

class SecurityScheme extends AbstractModel
{
    use DescriptionPart;

    /** @var string */
    private $name;

    /** @var string */
    private $type;

    /** @var string */
    private $in;

    /** @var string */
    private $flow;

    /** @var string */
    private $authorizationUrl;

    /** @var string */
    private $tokenUrl;

    /** @var array */
    private $scopes;

    public function __construct($data = [])
    {
        $this->merge($data);
    }

    /**
     * Return the name of the header or query parameter to be used.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the name of the header or query parameter to be used.
     *
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Returns the type of the security scheme.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets the type of the security scheme.
     *
     * @param string $type Valid values are "basic", "apiKey" or "oauth2"
     *
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Returns the location of the API key.
     *
     * @return string
     */
    public function getIn()
    {
        return $this->in;
    }

    /**
     * Sets the location of the API key.
     *
     * @param string $in Valid values are "query" or "header"
     *
     * @return $this
     */
    public function setIn($in)
    {
        $this->in = $in;

        return $this;
    }

    /**
     * Retunrs the flow used by the OAuth2 security scheme.
     *
     * @return string
     */
    public function getFlow()
    {
        return $this->flow;
    }

    /**
     * Sets the flow used by the OAuth2 security scheme.
     *
     * @param string $flow Valid values are "implicit", "password", "application" or "accessCode"
     *
     * @return $this
     */
    public function setFlow($flow)
    {
        $this->flow = $flow;

        return $this;
    }

    /**
     * Returns the authorization URL to be used for this flow.
     *
     * @return string
     */
    public function getAuthorizationUrl()
    {
        return $this->authorizationUrl;
    }

    /**
     * Sets the authorization URL to be used for this flow.
     *
     * @param string $authorizationUrl
     *
     * @return $this
     */
    public function setAuthorizationUrl($authorizationUrl)
    {
        $this->authorizationUrl = $authorizationUrl;

        return $this;
    }

    /**
     * Returns the token URL to be used for this flow.
     *
     * @return string
     */
    public function getTokenUrl()
    {
        return $this->tokenUrl;
    }

    /**
     * Sets the token URL to be used for this flow.
     *
     * @param string $tokenUrl
     *
     * @return $this
     */
    public function setTokenUrl($tokenUrl)
    {
        $this->tokenUrl = $tokenUrl;

        return $this;
    }

    /**
     * Returns the scopes.
     *
     * @return array
     */
    public function getScopes()
    {
        return $this->scopes;
    }

    /**
     * @return $this
     */
    public function setScopes(array $scopes = null)
    {
        $this->scopes = $scopes;

        return $this;
    }

    protected function doMerge($data, $overwrite = false)
    {
        MergeHelper::mergeFields($this->name, $data['name'] ?? null, $overwrite);
        MergeHelper::mergeFields($this->type, $data['type'] ?? null, $overwrite);
        MergeHelper::mergeFields($this->in, $data['in'] ?? null, $overwrite);
        MergeHelper::mergeFields($this->flow, $data['flow'] ?? null, $overwrite);
        MergeHelper::mergeFields($this->authorizationUrl, $data['authorizationUrl'] ?? null, $overwrite);
        MergeHelper::mergeFields($this->tokenUrl, $data['tokenUrl'] ?? null, $overwrite);
        MergeHelper::mergeFields($this->scopes, $data['scopes'] ?? null, $overwrite);

        $this->mergeDescription($data, $overwrite);
    }

    protected function doExport()
    {
        return [
            'name' => $this->name,
            'type' => $this->type,
            'in' => $this->in,
            'flow' => $this->flow,
            'authorizationUrl' => $this->authorizationUrl,
            'tokenUrl' => $this->tokenUrl,
            'scopes' => $this->scopes,
            'description' => $this->description,
        ];
    }
}
