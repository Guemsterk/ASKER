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
use AskerBundle\Exception\Api\ApiBadRequestException;
use AskerBundle\Exception\Api\ApiNotFoundException;
use AskerBundle\Exception\NonExistingObjectException;
use AskerBundle\Model\Api\ApiCreatedResponse;
use AskerBundle\Model\Api\ApiGotResponse;
use AskerBundle\Model\Collection\CollectionInformation;
use AskerBundle\Model\Resources\TestAttemptResourceFactory;
use AskerBundle\Model\Resources\TestResource;

/**
 * Class TestAttemptByTestController
 *
 * @author Baptiste Cablé <baptiste.cable@liris.cnrs.fr>
 */
class TestAttemptByTestController extends BaseController
{
    /**
     * Create a test attempt for a test
     *
     * @param int $testId
     *
     * @return ApiCreatedResponse
     * @throws ApiBadRequestException
     * @throws ApiNotFoundException
     */
    public function createAction($testId)
    {
        try {
            $testAttempt = $this->get('asker.exercise.test_attempt')->add(
                $testId,
                $this->getUserId()
            );

            $testAttemptResource = TestAttemptResourceFactory::create($testAttempt);

            return new ApiCreatedResponse($testAttemptResource, array('details', 'Default'));

        } catch (NonExistingObjectException $neoe) {
            throw new ApiNotFoundException(TestResource::RESOURCE_NAME);
        }
    }

    /**
     * List the test attempts for this test
     *
     * @param CollectionInformation $collectionInformation
     * @param int                   $testId
     *
     * @throws ApiBadRequestException
     * @throws ApiNotFoundException
     * @return ApiGotResponse
     */
    public function listAction(
        CollectionInformation $collectionInformation,
        $testId
    )
    {
        try {
            $testAttempts = $this->get('asker.exercise.test_attempt')->getAll(
                $collectionInformation,
                $this->getUserId(),
                $testId
            );

            $testAttemptResources = TestAttemptResourceFactory::createCollection($testAttempts);

            return new ApiGotResponse($testAttemptResources, array(
                'list',
                'Default'
            ));
        } catch (NonExistingObjectException $neoe) {
            throw new ApiNotFoundException(TestResource::RESOURCE_NAME);
        }
    }
}
