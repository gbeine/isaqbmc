<?php

namespace Member\Options;

use Member\Options\RoutingOptionsInterface;

interface MemberControllerOptionsInterface extends RoutingOptionsInterface
{
    /**
     * set use redirect param if present
     *
     * @param bool $useRedirectParameterIfPresent
     */
    public function setUseRedirectParameterIfPresent($useRedirectParameterIfPresent);

    /**
     * get use redirect param if present
     *
     * @return bool
     */
    public function getUseRedirectParameterIfPresent();
}
