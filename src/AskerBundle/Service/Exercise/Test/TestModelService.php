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

namespace AskerBundle\Service\Exercise\Test;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\DBALException;
use AskerBundle\Entity\ExerciseModel\ExerciseModel;
use AskerBundle\Entity\Test\TestModel;
use AskerBundle\Entity\TestModelFactory;
use AskerBundle\Entity\TestModelPositionFactory;
use AskerBundle\Exception\EntityDeletionException;
use AskerBundle\Exception\NoAuthorException;
use AskerBundle\Exception\NonExistingObjectException;
use AskerBundle\Model\Collection\CollectionInformation;
use AskerBundle\Model\Resources\TestModelResource;
use AskerBundle\Repository\Exercise\Test\TestModelPositionRepository;
use AskerBundle\Repository\Exercise\Test\TestModelRepository;
use AskerBundle\Service\Exercise\ExerciseModel\ExerciseModelService;
use AskerBundle\Service\TransactionalService;
use AskerBundle\Service\User\UserService;

/**
 * Class TestModelService
 *
 * @author Baptiste Cablé <baptiste.cable@liris.cnrs.fr>
 */
class TestModelService extends TransactionalService implements TestModelServiceInterface
{
    /**
     * @var TestModelRepository $testModelRepository
     */
    private $testModelRepository;

    /**
     * @var TestModelPositionRepository $testModelPositionRepository
     */
    private $testModelPositionRepository;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var ExerciseModelService
     */
    private $exerciseModelService;

    /**
     * Set testModelRepository
     *
     * @param TestModelRepository $testModelRepository
     */
    public function setTestModelRepository($testModelRepository)
    {
        $this->testModelRepository = $testModelRepository;
    }

    /**
     * Set userService
     *
     * @param \AskerBundle\Service\User\UserService $userService
     */
    public function setUserService($userService)
    {
        $this->userService = $userService;
    }

    /**
     * Set exerciseModelService
     *
     * @param \AskerBundle\Service\Exercise\ExerciseModel\ExerciseModelService $exerciseModelService
     */
    public function setExerciseModelService($exerciseModelService)
    {
        $this->exerciseModelService = $exerciseModelService;
    }

    /**
     * Set testModelPositionRepository
     *
     * @param \AskerBundle\Repository\Exercise\Test\TestModelPositionRepository $testModelPositionRepository
     */
    public function setTestModelPositionRepository($testModelPositionRepository)
    {
        $this->testModelPositionRepository = $testModelPositionRepository;
    }

    /**
     * Get a Test Model entity
     *
     * @param int $testModelId
     *
     * @return TestModel
     * @throws NonExistingObjectException
     */
    public function get($testModelId)
    {
        $testModel = $this->testModelRepository->find($testModelId);
        if (is_null($testModel)) {
            throw new NonExistingObjectException();
        }

        return $testModel;
    }

    /**
     * Get a list of Test Model
     *
     * @param CollectionInformation $collectionInformation The collection information
     *
     * @return array
     */
    public function getAll($collectionInformation = null)
    {
        return $this->testModelRepository->findAllBy($collectionInformation);
    }

    /**
     * Create and add a test model from a resource
     *
     * @param TestModelResource $testModelResource
     * @param int               $authorId
     *
     * @return TestModel
     */
    public function createAndAdd(TestModelResource $testModelResource, $authorId)
    {
        $testModel = $this->createFromResource($testModelResource, $authorId);

        return $this->add($testModel);
    }

    /**
     * Create an ExerciseModel entity from a resource
     *
     * @param TestModelResource $testModelResource
     * @param int               $authorId
     *
     * @throws NoAuthorException
     * @return TestModel
     */
    public function createFromResource(TestModelResource $testModelResource, $authorId = null)
    {
        $testModel = TestModelFactory::createFromResource($testModelResource);

        if (!is_null($testModelResource->getAuthor())) {
            $authorId = $testModelResource->getAuthor();
        }
        if (is_null($authorId)) {
            throw new NoAuthorException();
        }
        $testModel->setAuthor(
            $this->userService->get($authorId)
        );

        $testModelPositions = array();
        foreach ($testModelResource->getExerciseModels() as $position => $oemId) {
            /** @var ExerciseModel $exerciseModel */
            $exerciseModel = $this->exerciseModelService->get($oemId);
            $testModelPositions[] = TestModelPositionFactory::create(
                $exerciseModel,
                $testModel,
                $position
            );
        }
        $testModel->setTestModelPositions(new ArrayCollection($testModelPositions));

        return $testModel;
    }

    /**
     * Add a test model from an entity
     *
     * @param TestModel $testModel
     *
     * @return TestModel
     */
    public function add(TestModel $testModel)
    {
        $this->em->persist($testModel);
        $this->em->flush();

        return $testModel;
    }

    /**
     * Update an ExerciseResource object from a ResourceResource
     *
     * @param TestModelResource $testModelResource
     * @param TestModel         $testModel
     *
     * @throws NoAuthorException
     * @return TestModel
     */
    public function updateFromResource(TestModelResource $testModelResource, $testModel)
    {
        if (!is_null($testModelResource->getExerciseModels())) {
            $testModelPositions = array();
            foreach ($testModelResource->getExerciseModels() as $position => $oemId) {
                /** @var ExerciseModel $exerciseModel */
                $exerciseModel = $this->exerciseModelService->get($oemId);
                $testModelPositions[] = TestModelPositionFactory::create(
                    $exerciseModel,
                    $testModel,
                    $position
                );
            }
            $testModel->setTestModelPositions(new ArrayCollection($testModelPositions));

            // remove the previous positions
            $this->removePositions($testModel->getId());

        }

        if (!is_null($testModelResource->getTitle())) {
            $testModel->setTitle($testModelResource->getTitle());
        }

        return $testModel;
    }

    /**
     * Save a resource given in form of a ResourceResource
     *
     * @param TestModelResource $testModelResource
     * @param int               $testModelId
     *
     * @return TestModel
     */
    public function edit(TestModelResource $testModelResource, $testModelId)
    {
        $testModel = $this->get($testModelId);
        $testModel = $this->updateFromResource(
            $testModelResource,
            $testModel
        );

        return $this->save($testModel);
    }

    /**
     * Save a resource
     *
     * @param TestModel $testModel
     *
     * @return TestModel
     */
    public function save(TestModel $testModel)
    {
        $testModel = $this->testModelRepository->update($testModel);
        $this->em->flush();

        return $testModel;
    }

    /**
     * Remove all the positions for a test model
     *
     * @param int $testModelId
     *
     * @throws EntityDeletionException
     * @return TestModel
     */
    public function removePositions($testModelId)
    {
        $testModel = $this->get($testModelId);

        if (count($testModel->getTests())) {
            $this->testModelPositionRepository->deleteAllPositions($testModel);
            $this->em->flush();
        } else {
            throw new EntityDeletionException('Positions cannot be deleted because test model'
            . 'has been used.');
        }

        return $testModel;
    }

    /**
     * Delete a test model
     *
     * @param $testModelId
     *
     * @throws \AskerBundle\Exception\EntityDeletionException
     */
    public function remove($testModelId)
    {
        try {
            $testModel = $this->testModelRepository->find($testModelId);
            $this->testModelRepository->delete($testModel);
            $this->em->flush();
        } catch (DBALException $dbale) {
            throw new EntityDeletionException('This entity is needed and cannot be deleted');
        }
    }
}
