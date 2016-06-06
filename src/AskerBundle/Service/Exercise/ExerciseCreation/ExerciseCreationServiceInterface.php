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

namespace AskerBundle\Service\Exercise\ExerciseCreation;

use AppBundle\Entity\User;
use AskerBundle\Entity\CreatedExercise\Answer;
use AskerBundle\Entity\CreatedExercise\Item;
use AskerBundle\Entity\CreatedExercise\StoredExercise;
use AskerBundle\Entity\ExerciseModel\ExerciseModel;
use AskerBundle\Model\Resources\ExerciseModel\Common\CommonModel;
use AskerBundle\Model\Resources\ItemResource;

/**
 * Interface for the services which manages the specific exercise
 * generation
 *
 * @author Baptiste Cablé <baptiste.cable@liris.cnrs.fr>
 */
interface ExerciseCreationServiceInterface
{
    /**
     * Generate an instance of exercise according to the input exercise model entity.
     *
     * @param ExerciseModel $exerciseModel
     * @param CommonModel   $commonModel
     * @param User          $owner
     *
     * @return StoredExercise The instance of exercise
     */
    public function generateExerciseFromExerciseModel(
        ExerciseModel $exerciseModel,
        CommonModel $commonModel,
        User $owner
    );

    /**
     * Inserts the correction in the item and adapt the solution to make it
     * unique and match as best the user's answer
     *
     * @param Item   $entityItem
     * @param Answer $answer
     *
     * @return ItemResource
     */
    public function correct(Item $entityItem, Answer $answer);

    /**
     * Validate the answer to an item
     *
     * @param Item  $itemEntity
     * @param array $answer
     *
     * @throws \LogicException
     */
    public function validateAnswer(Item $itemEntity, array $answer);

    /**
     * Return an item without solution
     *
     * @param ItemResource $itemResource
     *
     * @return ItemResource
     */
    public function noSolutionItem($itemResource);
}
