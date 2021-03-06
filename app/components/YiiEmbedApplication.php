<?php
/**
 * Copyright (c) 2014, Mr PHP <info@mrphp.com.au>
 * All rights reserved.
 *  _____     _____ _____ _____
 * |     |___|  _  |  |  |  _  |
 * | | | |  _|   __|     |   __|
 * |_|_|_|_| |__|  |__|__|__|
 *
 *
 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:
 *
 * * Redistributions of source code must retain the above copyright notice, this
 *   list of conditions and the following disclaimer.
 *
 * * Redistributions in binary form must reproduce the above copyright notice, this
 *   list of conditions and the following disclaimer in the documentation and/or
 *   other materials provided with the distribution.
 *
 * * Neither the name of the organization nor the names of its
 *   contributors may be used to endorse or promote products derived from
 *   this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR
 * ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
 * ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

/**
 * YiiEmbedApplication
 *
 * @property YiiEmbedController $controller
 * @property YiiEmbedClientScript $clientScript
 * @property YiiEmbedReturnUrl $returnUrl
 * @property YiiEmbedWebUser $user
 * @property TbApi $bootstrap
 *
 * @package yii-embed-wordpress
 */
class YiiEmbedApplication extends CWebApplication
{

    /**
     * @var array List of routes that will exit after running
     * @see YiiEmbedApplication::runController()
     */
    public $exitRoutes = array();

    /**
     * @var CController Stores the main application controller after runController completes.
     */
    public $appController;

    /**
     * Runs a Yii controller.
     */
    public function runController($route)
    {
        // run the controller
        parent::runController($route);
        // exit for some routes to prevent wordpress output
        foreach ($this->exitRoutes as $exitRoute)
            if (strpos($route, $exitRoute) === 0)
                Yii::app()->end();
    }

    /**
     * Create a Controller
     * If the owner is not set (means we are not in a module) then
     * store the controller in $this->appController for later use.
     *
     * @param string $route
     * @param null $owner
     * @return array
     */
    public function createController($route, $owner = null)
    {
        $ca = parent::createController($route, $owner);
        if (!$owner)
            $this->appController = $ca[0];
        return $ca;
    }

    /**
     * @return CController the currently active controller, or if not set the application controller.
     */
    public function getController()
    {
        $controller = parent::getController();
        return $controller ? $controller : $this->appController;
    }

}
