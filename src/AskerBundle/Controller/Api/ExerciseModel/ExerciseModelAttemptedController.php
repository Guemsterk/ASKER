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

namespace AskerBundle\Controller\Api\ExerciseModel;

use AskerBundle\Controller\BaseController;
use AskerBundle\Entity\ExerciseModel\ExerciseModel;
use AskerBundle\Exception\Api\ApiBadRequestException;
use AskerBundle\Exception\Api\ApiNotFoundException;
use AskerBundle\Exception\FilterException;
use AskerBundle\Exception\NonExistingObjectException;
use AskerBundle\Model\Api\ApiGotResponse;
use AskerBundle\Model\Resources\ExerciseModelResource;
use AskerBundle\Model\Resources\ExerciseModelResourceFactory;

/**
 * API Exercise Model controller
 *
 * @author Baptiste Cablé <baptiste.cable@liris.cnrs.fr>
 */
class ExerciseModelAttemptedController extends BaseController
{
    /**
     * Get a specific exerciseModel resource
     *
     * @param int $exerciseModelId Exercise Model id
     *
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     * @throws \AskerBundle\Exception\Api\ApiNotFoundException
     * @return ApiGotResponse
     */
    public function viewAction($exerciseModelId)
    {
        try {
            /** @var ExerciseModel $exerciseModel */
            $exerciseModel = $this->get('asker.exercise.exercise_model')
                ->getAllByUserWhoAttemptedByModel($this->getUserId(), $exerciseModelId);

            $exerciseModelResource = ExerciseModelResourceFactory::create($exerciseModel, true);

            return new ApiGotResponse($exerciseModelResource, array("details", 'Default'));

        } catch (NonExistingObjectException $neoe) {
            throw new ApiNotFoundException(ExerciseModelResource::RESOURCE_NAME);
        }
    }

    /**
     * Get the list of exercise models that the user answered
     *
     * @throws \AskerBundle\Exception\Api\ApiBadRequestException
     * @return ApiGotResponse
     */
    public function listAction()
    {
        try {
            $exerciseModels = $this->get('asker.exercise.exercise_model')
                ->getAllByUserWhoAttempted($this->getUserId());

            $exerciseModelResources = ExerciseModelResourceFactory::createCollection
                (
                    $exerciseModels,
                    true
                );

            return new ApiGotResponse($exerciseModelResources, array(
                'details',
                'Default'
            ));
        } catch (FilterException $fe) {
            throw new ApiBadRequestException($fe->getMessage());
        }
    }
}
