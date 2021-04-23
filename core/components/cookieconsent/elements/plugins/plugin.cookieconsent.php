<?php
/** @var array $scriptProperties */
/** @var modX $modx */
/** @var modDocument $resource */
switch ($modx->event->name)
{
  case 'OnWebPagePrerender':
    $resource = $modx->resource;
    $html = 1;

    if (strtolower($resource->get('content_type')) != $html) {
      return '';
    }


    $c = $modx->getOption('cookieName', $scriptProperties, 'CookieConsent');

    if (!isset($_COOKIE[ $c ]))
    {
      //cookie disclaimer has NOT been acknowledged as read

      if ($modx->getOption('site_dev') == 1)
      {
          $p = $modx->getOption('cookieconsent.core_path');
        } else {
          $p = $modx->getOption('core_path').'components/cookieconsent/';
      }
      
      $cc = $modx->getService(  'cookieconsent',
                                'CookieConsent',
                                $p.'model/cookieconsent/'
                              );
                                
      if (!($cc instanceof CookieConsent)) return '';

      $cc->appendDisclaimer($scriptProperties);
      
      unset($cc, $c);
    }
    
    break;
}
