<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * oauth actions.
 *
 * @package    OpenPNE
 * @subpackage action
 * @author     Kousuke Ebihara <ebihara@tejimaya.com>
 */
class oauthActions extends sfActions
{
  public function executeRequestToken(sfWebRequest $request)
  {
    require_once 'OAuth.php';

    $authRequest = OAuthRequest::from_request();
    $token = $this->getServer()->fetch_request_token($authRequest);

    $this->getResponse()->setContent((string)$token);

    return sfView::NONE;
  }

  public function executeAuthorizeToken(sfWebRequest $request)
  {
    $token = $request->getParameter('oauth_token');
    $this->information = Doctrine::getTable('OAuthAdminToken')->findByKeyString($token);
    $this->forward404Unless($this->information);
  }

  public function executeAccessToken(sfWebRequest $request)
  {
    require_once 'OAuth.php';

    $authRequest = OAuthRequest::from_request();
    $token = $this->getServer()->fetch_access_token($authRequest);

    $this->getResponse()->setContent((string)$token);

    return sfView::NONE;
  }

  protected function getServer()
  {
    $server = new opOAuthServer(new opOAuthDataStore());

    return $server;
  }
}