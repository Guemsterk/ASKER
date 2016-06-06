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

use Doctrine\DBAL\DBALException;
use AskerBundle\Controller\BaseController;
use AskerBundle\Exception\Api\ApiBadRequestException;
use AskerBundle\Exception\Api\ApiConflictException;
use AskerBundle\Exception\Api\ApiNotFoundException;
use AskerBundle\Exception\EntityDeletionException;
use AskerBundle\Exception\NoAuthorException;
use AskerBundle\Exception\NonExistingObjectException;
use AskerBundle\Model\Api\ApiCreatedResponse;
use AskerBundle\Model\Api\ApiDeletedResponse;
use AskerBundle\Model\Api\ApiEditedResponse;
use AskerBundle\Model\Api\ApiGotResponse;
use AskerBundle\Model\Api\ApiResponse;
use AskerBundle\Model\Collection\CollectionInformation;
use AskerBundle\Model\Resources\TestModelResource;
use AskerBundle\Model\Resources\TestModelResourceFactory;

/**
 * API Test Model controller
 *
 * @author Baptiste Cablé <baptiste.cable@liris.cnrs.fr>
 */
class TestModelController extends BaseController
{
    /**
     * Get a specific test Model resource
     *
     * @param int $testModelId Exercise Model id
     *
     * @throws ApiNotFoundException
     * @return ApiGotResponse
     */
    public function viewAction($testModelId)
    {
        try {
            $testModel = $this->get('asker.exercise.test_model')->get($testModelId);
            $testModelResource = TestModelResourceFactory::create($testModel);

            return new ApiGotResponse($testModelResource, array("details", 'Default'));

        } catch (NonExistingObjectException $neoe) {
            throw new ApiNotFoundException(TestModelResource::RESOURCE_NAME);
        }
    }

    /**
     * Get the list of test models.
     *
     * @param CollectionInformation $collectionInformation
     *
     * @return ApiGotResponse
     */
    public function listAction(CollectionInformation $collectionInformation)
    {
        $testModels = $this->get('asker.exercise.test_model')->getAll(
            $collectionInformation
        );

        $testModelResources = TestModelResourceFactory::createCollection($testModels);

        return new ApiGotResponse($testModelResources, array('list', 'Default'));
    }

    /**
     * Create a new test model
     *
     * @param TestModelResource $testModelResource
     *
     * @throws ApiBadRequestException
     * @throws ApiNotFoundException
     * @return ApiResponse
     */
    public function createAction(
        TestModelResource $testModelResource
    )
    {
        try {
            $userId = null;
            if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
                $userId = $this->getUserId();
            }

            $this->validateResource($testModelResource, array('create', 'Default'));

            $model = $this->get('asker.exercise.test_model')->createAndAdd
                (
                    $testModelResource,
                    $userId
                );

            $testModelResource = TestModelResourceFactory::create($model);

            return new ApiCreatedResponse($testModelResource, array("details", 'Default'));

        } catch (NonExistingObjectException $neoe) {
            throw new ApiNotFoundException(TestModelResource::RESOURCE_NAME);
        } catch (NoAuthorException $nae) {
            throw new ApiBadRequestException($nae->getMessage());
        }
    }

    /**
     * Edit a model
     *
     * @param TestModelResource $testModelResource
     * @param int               $testModelId
     *
     * @throws ApiBadRequestException
     * @throws ApiNotFoundException
     * @throws ApiConflictException
     * @return ApiEditedResponse
     */
    public function editAction(TestModelResource $testModelResource, $testModelId)
    {
        try {
            $this->validateResource($testModelResource, array('edit', 'Default'));

            $resource = $this->get('asker.exercise.test_model')->edit
                (
                    $testModelResource,
                    $testModelId
                );
            $testModelResource = TestModelResourceFactory::create($resource);

            return new ApiEditedResponse($testModelResource);

        } catch (NonExistingObjectException $neoe) {
            throw new ApiNotFoundException(TestModelResource::RESOURCE_NAME);
        } catch (DBALException $eoe) {
            throw new ApiConflictException($eoe->getMessage());
        } catch (NoAuthorException $nae) {
            throw new ApiBadRequestException($nae->getMessage());
        }
    }

    /**
     * Delete a model
     *
     * @param int $testModelId
     *
     * @throws \AskerBundle\Exception\Api\ApiBadRequestException
     * @throws \AskerBundle\Exception\Api\ApiNotFoundException
     * @return ApiDeletedResponse
     */
    public function deleteAction($testModelId)
    {
        try {
            $this->get('asker.exercise.test_model')->remove($testModelId);

            return new ApiDeletedResponse();

        } catch (NonExistingObjectException $neoe) {
            throw new ApiNotFoundException(TestModelResource::RESOURCE_NAME);
        } catch (EntityDeletionException $ede) {
            throw new ApiBadRequestException($ede->getMessage());
        }
    }
}
