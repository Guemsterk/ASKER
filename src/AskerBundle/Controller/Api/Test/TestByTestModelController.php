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
use AskerBundle\Model\Api\ApiCreatedResponse;
use AskerBundle\Model\Api\ApiGotResponse;
use AskerBundle\Model\Collection\CollectionInformation;
use AskerBundle\Model\Resources\TestModelResource;
use AskerBundle\Model\Resources\TestResource;
use AskerBundle\Model\Resources\TestResourceFactory;

/**
 * Class TestByTestModelController
 *
 * @author Baptiste Cablé <baptiste.cable@liris.cnrs.fr>
 */
class TestByTestModelController extends BaseController
{
    /**
     * Generate a test from a test model
     *
     * @param $testModelId
     *
     * @return ApiCreatedResponse
     * @throws ApiNotFoundException
     */
    public function createAction($testModelId)
    {
        try {
            $test = $this->get('asker.exercise.test')->add($testModelId);

            $testResource = TestResourceFactory::create($test);

            return new ApiCreatedResponse($testResource, array('test', 'Default'));

        } catch (NonExistingObjectException $neoe) {
            throw new ApiNotFoundException(TestResource::RESOURCE_NAME);
        }
    }

    /**
     * List the tests for a test model
     *
     * @param CollectionInformation $collectionInformation
     * @param int                   $testModelId
     *
     * @throws ApiNotFoundException
     * @return ApiGotResponse
     */
    public function listAction(CollectionInformation $collectionInformation, $testModelId)
    {
        try {
            $tests = $this->get('asker.exercise.test')->getAll
                (
                    $collectionInformation,
                    $testModelId
                );

            $testResources = TestResourceFactory::createCollection($tests);

            return new ApiGotResponse($testResources, array('list', 'Default'));
        } catch (NonExistingObjectException $neoe) {
            throw new ApiNotFoundException(TestModelResource::RESOURCE_NAME);
        }
    }
}
