<?php

namespace Member\Options;

interface RoutingOptionsInterface
{

	function setLoginFromRedirectRoute($loginFormRedirectRoute);
	function getLoginFormRedirectRoute();
	function setLoginRedirectRoute($loginRedirectRoute);
	function getLoginRedirectRoute();
	function setLogoutRedirectRoute($logoutRedirectRoute);
	function getLogoutRedirectRoute();

}
