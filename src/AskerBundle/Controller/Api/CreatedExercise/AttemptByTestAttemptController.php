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

namespace AskerBundle\Controller\Api\CreatedExercise;

use AskerBundle\Controller\BaseController;
use AskerBundle\Exception\Api\ApiBadRequestException;
use AskerBundle\Exception\Api\ApiNotFoundException;
use AskerBundle\Exception\NonExistingObjectException;
use AskerBundle\Model\Api\ApiGotResponse;
use AskerBundle\Model\Collection\CollectionInformation;
use AskerBundle\Model\Resources\AnswerResource;
use AskerBundle\Model\Resources\AttemptResourceFactory;

/**
 * API AttemptByTestAttempt Controller
 *
 * @author Baptiste Cablé <baptiste.cable@liris.cnrs.fr>
 */
class AttemptByTestAttemptController extends BaseController
{
    /**
     * List the attempts fot this exercise
     *
     * @param CollectionInformation $collectionInformation
     * @param int                   $testAttemptId
     *
     * @throws ApiBadRequestException
     * @throws ApiNotFoundException
     * @return ApiGotResponse
     */
    public function listAction(CollectionInformation $collectionInformation, $testAttemptId)
    {
        try {
            $attempts = $this->get('asker.exercise.attempt')->getAll(
                $collectionInformation,
                $this->getUserId(),
                null,
                $testAttemptId
            );

            $attemptResources = AttemptResourceFactory::createCollection($attempts);

            return new ApiGotResponse($attemptResources, array('list', 'Default'));
        } catch (NonExistingObjectException $neoe) {
            throw new ApiNotFoundException(AnswerResource::RESOURCE_NAME);
        }
    }
}
