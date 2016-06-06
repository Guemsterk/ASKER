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
use AskerBundle\Exception\Api\ApiNotFoundException;
use AskerBundle\Exception\NonExistingObjectException;
use AskerBundle\Model\Api\ApiCreatedResponse;
use AskerBundle\Model\Api\ApiGotResponse;
use AskerBundle\Model\Collection\CollectionInformation;
use AskerBundle\Model\Resources\ExerciseModelResource;
use AskerBundle\Model\Resources\ExerciseResource;
use AskerBundle\Model\Resources\ExerciseResourceFactory;

/**
 * Class ExerciseByExerciseModelController
 *
 * @author Baptiste Cablé <baptiste.cable@liris.cnrs.fr>
 */
class ExerciseByExerciseModelController extends BaseController
{
    /**
     * Generate an exercise from the model id
     *
     * @param int $exerciseModelId Exercise Model Id
     *
     * @throws ApiNotFoundException
     * @return ApiCreatedResponse
     */
    public function createAction($exerciseModelId)
    {
        try {
            $exercise = $this->get('asker.exercise.stored_exercise')->addByExerciseModel(
                $exerciseModelId
            );
            $exerciseResource = ExerciseResourceFactory::create($exercise);

            return new ApiCreatedResponse($exerciseResource, array('exercise', 'Default'));

        } catch (NonExistingObjectException $neoe) {
            throw new ApiNotFoundException('Exercise Model');
        }
    }

    /**
     * List the stored exercises of this model
     *
     * @param CollectionInformation $collectionInformation
     * @param int                   $exerciseModelId
     *
     * @throws ApiNotFoundException
     * @return ApiGotResponse
     */
    public function listAction(CollectionInformation $collectionInformation, $exerciseModelId)
    {
        try {
            $exercises = $this->get('asker.exercise.stored_exercise')->getAll
                (
                    $collectionInformation,
                    $exerciseModelId
                );

            $exerciseResources = ExerciseResourceFactory::createCollection($exercises);

            return new ApiGotResponse($exerciseResources, array(
                'list',
                'Default'
            ));
        } catch (NonExistingObjectException $neoe) {
            throw new ApiNotFoundException(ExerciseModelResource::RESOURCE_NAME);
        }
    }
}
