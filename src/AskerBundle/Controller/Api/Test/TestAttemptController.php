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
use AskerBundle\Model\Api\ApiGotResponse;
use AskerBundle\Model\Collection\CollectionInformation;
use AskerBundle\Model\Resources\TestAttemptResource;
use AskerBundle\Model\Resources\TestAttemptResourceFactory;

/**
 * Class TestAttemptController
 *
 * @author Baptiste Cablé <baptiste.cable@liris.cnrs.fr>
 */
class TestAttemptController extends BaseController
{
    /**
     * Get a specific Attempt resource
     *
     * @param int $testAttemptId
     *
     * @throws ApiNotFoundException
     * @return ApiGotResponse
     */
    public function viewAction($testAttemptId)
    {
        try {
            $testAttempt = $this->get('asker.exercise.test_attempt')->get(
                $testAttemptId,
                $this->getUserId()
            );
            $testAttemptResource = TestAttemptResourceFactory::create($testAttempt);

            return new ApiGotResponse($testAttemptResource, array("test_attempt", 'Default'));

        } catch (NonExistingObjectException $neoe) {
            throw new ApiNotFoundException(TestAttemptResource::RESOURCE_NAME);
        }
    }

    /**
     * List the test attempts for this test
     *
     * @param CollectionInformation $collectionInformation
     *
     * @throws ApiBadRequestException
     * @throws ApiNotFoundException
     * @return ApiGotResponse
     */
    public function listAction(
        CollectionInformation $collectionInformation
    )
    {
        try {
            $testAttempts = $this->get('asker.exercise.test_attempt')->getAll
                (
                    $collectionInformation,
                    $this->getUserId()
                );

            $testAttemptResources = TestAttemptResourceFactory::createCollection($testAttempts);

            return new ApiGotResponse($testAttemptResources, array(
                'list',
                'Default'
            ));
        } catch (NonExistingObjectException $neoe) {
            throw new ApiNotFoundException(TestAttemptResource::RESOURCE_NAME);
        }
    }
}
