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

use Doctrine\DBAL\DBALException;
use AskerBundle\Controller\BaseController;
use AskerBundle\Entity\ExerciseModel\ExerciseModel;
use AskerBundle\Exception\Api\ApiBadRequestException;
use AskerBundle\Exception\Api\ApiConflictException;
use AskerBundle\Exception\Api\ApiNotFoundException;
use AskerBundle\Exception\EntityDeletionException;
use AskerBundle\Exception\FilterException;
use AskerBundle\Exception\InvalidTypeException;
use AskerBundle\Exception\NoAuthorException;
use AskerBundle\Exception\NonExistingObjectException;
use AskerBundle\Model\Api\ApiCreatedResponse;
use AskerBundle\Model\Api\ApiDeletedResponse;
use AskerBundle\Model\Api\ApiEditedResponse;
use AskerBundle\Model\Api\ApiGotResponse;
use AskerBundle\Model\Api\ApiResponse;
use AskerBundle\Model\Collection\CollectionInformation;
use AskerBundle\Model\Resources\ExerciseModelResource;
use AskerBundle\Model\Resources\ExerciseModelResourceFactory;

/**
 * API Exercise Model controller
 *
 * @author Baptiste Cablé <baptiste.cable@liris.cnrs.fr>
 */
class ExerciseModelController extends BaseController
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
            $exerciseModelResource = $this->get(
                'asker.exercise.exercise_model'
            )->getContentFullResource
                (
                    $exerciseModelId,
                    $this->getUserId()
                );

            return new ApiGotResponse($exerciseModelResource, array("details", 'Default'));

        } catch (NonExistingObjectException $neoe) {
            throw new ApiNotFoundException(ExerciseModelResource::RESOURCE_NAME);
        }
    }

    /**
     * Get the list of exercise models. In the collection information filters (url filters),
     * type is used for the type of the exercise and all other values are used to search in
     * metadata.
     *
     * @param CollectionInformation $collectionInformation
     *
     * @throws ApiBadRequestException
     * @return ApiGotResponse
     */
    public function listAction(CollectionInformation $collectionInformation)
    {
        try {
            $exerciseModels = $this->get('asker.exercise.exercise_model')->getAll(
                $collectionInformation,
                $this->getUserId()
            );

            $exerciseModelResources = $this->get(
                'asker.exercise.exercise_model'
            )->getAllContentFullResourcesFromEntityList(
                    $exerciseModels
                );

            return new ApiGotResponse($exerciseModelResources, array(
                'details',
                'Default'
            ));
        } catch (FilterException $fe) {
            throw new ApiBadRequestException($fe->getMessage());
        }
    }

    /**
     * Create a new model (without metadata)
     *
     * @param ExerciseModelResource $modelResource
     *
     * @throws ApiBadRequestException
     * @throws ApiNotFoundException
     * @return ApiResponse
     */
    public function createAction(
        ExerciseModelResource $modelResource
    )
    {
        try {
            $userId = $this->getUserId();
            $user = $this->get('asker.exercise.user')->get($userId);

            $this->validateResource($modelResource, array('create', 'Default'));

            $modelResource->setAuthor($userId);
            $modelResource->setOwner($userId);

            /** @var ExerciseModel $model */
            $model = $this->get('asker.exercise.exercise_model')->createAndAdd
                (
                    $modelResource
                );

            // create the claroline ResourceNode for this model
            /*$workspace = $user->getPersonalWorkspace();
            $this->get('claroline.manager.resource_manager')->create(
                $model,
                $this->get('claroline.manager.resource_manager')->getResourceTypeByName(
                    'claire_exercise_model'
                ),
                $user,
                $workspace,
                $this->get('doctrine.orm.entity_manager')->getRepository
                    (
                        'ClarolineCoreBundle:Resource\ResourceNode'
                    )->findWorkspaceRoot($workspace)
            );*/

            $modelResource = ExerciseModelResourceFactory::create($model);

            return new ApiCreatedResponse($modelResource, array("details", 'Default'));

        } catch (NonExistingObjectException $neoe) {
            throw new ApiNotFoundException(ExerciseModelResource::RESOURCE_NAME);
        } catch (NoAuthorException $nae) {
            throw new ApiBadRequestException($nae->getMessage());
        }
    }

    /**
     * Edit a model
     *
     * @param ExerciseModelResource $modelResource
     * @param int                   $exerciseModelId
     *
     * @throws ApiBadRequestException
     * @throws ApiNotFoundException
     * @throws ApiConflictException
     * @return ApiEditedResponse
     */
    public function editAction(ExerciseModelResource $modelResource, $exerciseModelId)
    {
        try {
            $this->validateResource($modelResource, array('edit', 'Default'));

            $modelResource->setId($exerciseModelId);

            $model = $this->get('asker.exercise.exercise_model')->edit
                (
                    $modelResource,
                    $this->getUserId()
                );
            $modelResource = ExerciseModelResourceFactory::create($model);

            return new ApiEditedResponse($modelResource);

        } catch (NonExistingObjectException $neoe) {
            throw new ApiNotFoundException(ExerciseModelResource::RESOURCE_NAME);
        } catch (DBALException $eoe) {
            throw new ApiConflictException($eoe->getMessage());
        } catch (NoAuthorException $nae) {
            throw new ApiBadRequestException($nae->getMessage());
        } catch (InvalidTypeException $ite) {
            throw new ApiBadRequestException($ite->getMessage());
        }
    }

    /**
     * Delete a model
     *
     * @param int $exerciseModelId
     *
     * @throws \AskerBundle\Exception\Api\ApiNotFoundException
     * @throws \AskerBundle\Exception\Api\ApiBadRequestException
     * @return ApiDeletedResponse
     */
    public function deleteAction($exerciseModelId)
    {
        try {
            $this->get('asker.exercise.exercise_model')->remove(
                $exerciseModelId,
                $this->getUserId()
            );

            return new ApiDeletedResponse();

        } catch (NonExistingObjectException $neoe) {
            throw new ApiNotFoundException(ExerciseModelResource::RESOURCE_NAME);
        } catch (EntityDeletionException $ede) {
            throw new ApiBadRequestException($ede->getMessage());
        }
    }

    /**
     * Subscribe to a model
     *
     * @param int $exerciseModelId
     *
     * @throws ApiBadRequestException
     * @throws ApiNotFoundException
     * @return ApiResponse
     */
    public function subscribeAction($exerciseModelId)
    {
        try {
            $model = $this->get('asker.exercise.exercise_model')->subscribe(
                $this->getUserId(),
                $exerciseModelId
            );

            // create the claroline ResourceNode for this model
            /*$user = $this->get('asker.exercise.user')->get($this->getUserId());
            $this->get('asker.exercise.exercise_model')->createClarolineResourceNode(
                $user,
                $model
            );*/

            $modelResource = $this->get('asker.exercise.exercise_model')
                ->getContentFullResourceFromEntity($model);

            return new ApiCreatedResponse($modelResource, array("details", 'Default'));

        } catch (NonExistingObjectException $neoe) {
            throw new ApiNotFoundException(ExerciseModelResource::RESOURCE_NAME);
        }
    }

    /**
     * Duplicate a model
     *
     * @param int $exerciseModelId
     *
     * @throws ApiBadRequestException
     * @throws ApiNotFoundException
     * @return ApiResponse
     */
    public function duplicateAction($exerciseModelId)
    {
        try {
            /** @var ExerciseModel $model */
            $model = $this->get('asker.exercise.exercise_model')->duplicate(
                $exerciseModelId,
                $this->getUserId()
            );

			/*
            // create the claroline ResourceNode for this model
            $user = $this->get('asker.exercise.user')->get($this->getUserId());
            $this->get('asker.exercise.exercise_model')->createClarolineResourceNode(
                $user,
                $model
            );
			*/
			
            $modelResource = $this->get('asker.exercise.exercise_model')
                ->getContentFullResourceFromEntity($model);

            return new ApiCreatedResponse($modelResource, array("details", 'Default'));

        } catch (NonExistingObjectException $neoe) {
            throw new ApiNotFoundException(ExerciseModelResource::RESOURCE_NAME);
        }
    }

    /**
     * Import a model
     *
     * @param int $exerciseModelId
     *
     * @throws ApiBadRequestException
     * @throws ApiNotFoundException
     * @return ApiResponse
     */
    public function importAction($exerciseModelId)
    {
        try {
            /** @var ExerciseModel $model */
            $model = $this->get('asker.exercise.exercise_model')->import(
                $this->getUserId(),
                $exerciseModelId
            );

            // create the claroline ResourceNode for this model
			/*
            $user = $this->get('asker.exercise.user')->get($this->getUserId());
            $this->get('asker.exercise.exercise_model')->createClarolineResourceNode(
                $user,
                $model
            );
			*/

            $modelResource = $this->get('asker.exercise.exercise_model')
                ->getContentFullResourceFromEntity($model);

            return new ApiCreatedResponse($modelResource, array("details", 'Default'));

        } catch (NonExistingObjectException $neoe) {
            throw new ApiNotFoundException(ExerciseModelResource::RESOURCE_NAME);
        }
    }
}
