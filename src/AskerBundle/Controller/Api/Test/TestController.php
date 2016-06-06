<?php
/*
 * This file is part of CLAIRE.
 *
 * CLAIRE is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * CLAIRE is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with CLAIRE. If not, see <http://www.gnu.org/licenses/>
 */

namespace AskerBundle\Controller\Api\Test;

use AskerBundle\Controller\BaseController;
use AskerBundle\Exception\Api\ApiNotFoundException;
use AskerBundle\Exception\NonExistingObjectException;
use AskerBundle\Model\Api\ApiGotResponse;
use AskerBundle\Model\Collection\CollectionInformation;
use AskerBundle\Model\Resources\TestResource;
use AskerBundle\Model\Resources\TestResourceFactory;

/**
 * API Test controller
 *
 * @author Baptiste Cablé <baptiste.cable@liris.cnrs.fr>
 */
class TestController extends BaseController
{
    /**
     * View a test
     *
     * @param int $testId Exercise id
     *
     * @return ApiGotResponse
     * @throws ApiNotFoundException
     */
    public function viewAction($testId)
    {
        try {
            $test = $this->get('asker.exercise.test')->get($testId);
            $testResource = TestResourceFactory::create($test);

            return new ApiGotResponse($testResource, array("test", 'Default'));

        } catch (NonExistingObjectException $neoe) {
            throw new ApiNotFoundException(TestResource::RESOURCE_NAME);
        }
    }

    /**
     * Get all the tests
     *
     * @param CollectionInformation $collectionInformation
     *
     * @throws ApiNotFoundException
     * @return ApiGotResponse
     */
    public function listAction(CollectionInformation $collectionInformation)
    {
        try {
            $tests = $this->get('asker.exercise.test')->getAll(
                $collectionInformation
            );

            $testResources = TestResourceFactory::createCollection($tests);

            return new ApiGotResponse($testResources, array('list', 'Default'));
        } catch (NonExistingObjectException $neoe) {
            throw new ApiNotFoundException(TestResource::RESOURCE_NAME);
        }
    }
}
