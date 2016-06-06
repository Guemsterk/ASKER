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
use AskerBundle\Exception\AnswerAlreadyExistsException;
use AskerBundle\Exception\Api\ApiBadRequestException;
use AskerBundle\Exception\Api\ApiNotFoundException;
use AskerBundle\Exception\InvalidAnswerException;
use AskerBundle\Exception\NonExistingObjectException;
use AskerBundle\Model\Api\ApiGotResponse;
use AskerBundle\Model\Api\ApiResponse;
use AskerBundle\Model\Resources\AnswerResource;
use AskerBundle\Model\Resources\AnswerResourceFactory;

/**
 * API AnswerByItemByAttempt Controller
 *
 * @author Baptiste Cablé <baptiste.cable@liris.cnrs.fr>
 */
class AnswerByItemByAttemptController extends BaseController
{
    /**
     * List the answers fot this item
     *
     * @param int $attemptId
     * @param int $itemId
     *
     * @throws ApiNotFoundException
     * @return ApiGotResponse
     */
    public function listAction($attemptId, $itemId)
    {
        try {

            $answers = $this->get('asker.exercise.answer')->getAll(
                $itemId,
                $attemptId,
                $this->getUserId()
            );

            $answerResources = AnswerResourceFactory::createCollection($answers);

            return new ApiGotResponse($answerResources, array('list', 'Default'));
        } catch (NonExistingObjectException $neoe) {
            throw new ApiNotFoundException(AnswerResource::RESOURCE_NAME);
        }
    }

    /**
     * Answer action. Create an answer for the given stored exercise.
     *
     * @param int            $attemptId
     * @param int            $itemId
     * @param AnswerResource $answerResource
     *
     * @throws ApiBadRequestException
     * @throws ApiNotFoundException
     * @return ApiResponse
     */
    public function createAction($attemptId, $itemId, AnswerResource $answerResource)
    {
        try {
            $this->validateResource($answerResource, array('create', 'Default'));

            // send to the answer service in order to create the answer
            $itemResource = $this->get('asker.exercise.answer')
                ->add($itemId, $answerResource, $attemptId, $this->getUserId());

            return new ApiGotResponse($itemResource, array("corrected", 'Default'));

        } catch (NonExistingObjectException $neoe) {
            throw new ApiNotFoundException(AnswerResource::RESOURCE_NAME);
        } catch (InvalidAnswerException $iae) {
            throw new ApiBadRequestException($iae->getMessage());
        } catch (AnswerAlreadyExistsException $aaee) {
            throw new ApiBadRequestException($aaee->getMessage());
        }
    }
}
