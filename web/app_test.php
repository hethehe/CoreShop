<?php
/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Enterprise License (PEL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 * @license    http://www.pimcore.org/license     GPLv3 and PEL
 */

use Pimcore\Tool;
use Symfony\Component\HttpFoundation\Request;

define('PIMCORE_PROJECT_ROOT', __DIR__ . '/..');
$_SERVER['PIMCORE_ENVIRONMENT'] = $_SERVER['APP_ENV'] = $_SERVER['SYMFONY_ENV'] = 'test';

include __DIR__ . "/../vendor/autoload.php";
include __DIR__ . "/../behat-bootstrap.php";

$request = Request::createFromGlobals();

// set current request as property on tool as there's no
// request stack available yet
Tool::setCurrentRequest($request);

/** @var \Pimcore\Kernel $kernel */
$kernel = \Pimcore\Bootstrap::kernel();

// reset current request - will be read from request stack from now on
Tool::setCurrentRequest(null);

$_SERVER['REQUEST_ID'] = uniqid();

$response = $kernel->handle($request);
$response->send();

$kernel->terminate($request, $response);
