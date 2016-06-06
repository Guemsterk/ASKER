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

use AskerBundle\Entity\CreatedExercise\Answer;
use AskerBundle\Entity\CreatedExercise\Item;
use AskerBundle\Entity\ExerciseModel\ExerciseModel;
use AskerBundle\Model\Resources\AnswerResource;
use AskerBundle\Model\Resources\Exercise\Common\CommonExercise;
use AskerBundle\Model\Resources\ItemResource;

/**
 * Service which manages the exercise generation
 *
 * @author Baptiste Cablé <baptiste.cable@liris.cnrs.fr>
 */
interface ExerciseServiceInterface
{
    /**
     * Correct an item from an exercise
     *
     * @param Answer $answer Answer
     *
     * @return ItemResource The corrected item
     * @throws \Exception
     */
    public function correctItem(Answer $answer);

    /**
     * Generate an exercise from the id of the model
     *
     * @param ExerciseModel $exerciseModel
     *
     * @return CommonExercise The generated exercise
     */
    public function generateExercise($exerciseModel);

    /**
     * Validate learner's answer format
     *
     * @param Item           $item
     * @param AnswerResource $answerResource
     */
    public function validateAnswer(Item $item, AnswerResource $answerResource);

    /**
     * Return an item without solution
     *
     * @param ItemResource $itemResource
     *
     * @return ItemResource
     */
    public function noSolutionItem($itemResource);
}
