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
use AskerBundle\Model\Api\ApiGotResponse;
use AskerBundle\Model\Resources\ItemResource;
use AskerBundle\Model\Resources\ItemResourceFactory;

/**
 * API ItemByExercise controller
 *
 * @author Baptiste Cablé <baptiste.cable@liris.cnrs.fr>
 */
class ItemByExerciseController extends BaseController
{
    /**
     * Get all items
     *
     * @param int $exerciseId    Exercise id
     *
     * @throws ApiNotFoundException
     * @return ApiGotResponse
     */
    public function listAction($exerciseId)
    {
        try {
            $items = $this->get('asker.exercise.item')->getAll($exerciseId);

            $itemResources = ItemResourceFactory::createCollection($items);

            return new ApiGotResponse($itemResources, array('list', 'Default'));
        } catch (NonExistingObjectException $neoe) {
            throw new ApiNotFoundException(ItemResource::RESOURCE_NAME);
        }
    }
}
