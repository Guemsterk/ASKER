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
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * API Item controller
 *
 * @author Baptiste Cablé <baptiste.cable@liris.cnrs.fr>
 */
class ItemController extends BaseController
{
    /**
     * View action. View an item with its solution.
     *
     * @param int $itemId
     *
     * @throws ApiNotFoundException
     * @return ApiGotResponse
     */
    public function viewAction($itemId)
    {
        try {
            // Call to the item service to get the item and its correction if there is one
            $item = $this->get('asker.exercise.item')->get($itemId);

            $itemResource = ItemResourceFactory::create($item);

//            return new ApiGotResponse($itemResource, array("not_corrected", 'Default'));
            return new ApiGotResponse($itemResource, array("details", 'Default'));

        } catch (NonExistingObjectException $neoe) {
            throw new ApiNotFoundException(ItemResource::RESOURCE_NAME);
        }
    }

    /**
     * Get all items
     *
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     * @throws \AskerBundle\Exception\Api\ApiNotFoundException
     * @return ApiGotResponse
     */
    public function listAction()
    {
        if (!$this->get('security.authorization_checker')->getToken()->getUser()->hasRole('ROLE_WS_CREATOR')) {
            throw new AccessDeniedException();
        }

        try {
            $items = $this->get('asker.exercise.item')->getAll();

            $itemResources = ItemResourceFactory::createCollection($items);

            return new ApiGotResponse($itemResources, array('list'));
        } catch (NonExistingObjectException $neoe) {
            throw new ApiNotFoundException(ItemResource::RESOURCE_NAME);
        }
    }
}
