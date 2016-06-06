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

namespace AskerBundle\Model\Resources;

use JMS\Serializer\Handler\HandlerRegistry;
use JMS\Serializer\SerializerBuilder;
use AskerBundle\Entity\CreatedExercise\StoredExercise;
use AskerBundle\Model\Resources\ExerciseObject;
use AskerBundle\Model\Resources\ExerciseResource;
use AskerBundle\Serializer\Handler\AbstractClassForExerciseHandler;

/**
 * Class ExerciseModelResourceFactory
 *
 * @author Baptiste Cablé <baptiste.cable@liris.cnrs.fr>
 */
abstract class ExerciseResourceFactory
{

    /**
     * Create an ExerciseResource collection
     *
     * @param array $exercises
     *
     * @return array
     */
    public static function createCollection(array $exercises)
    {
        $exerciseResources = array();
        foreach ($exercises as $exercise) {
            $exerciseResources[] = self::create($exercise);
        }

        return $exerciseResources;
    }

    /**
     * Create an Exercise Resource
     *
     * @param StoredExercise $exercise
     * @param bool           $links
     *
     * @return ExerciseResource
     */
    public static function create(StoredExercise $exercise, $links = false)
    {
        $exerciseResource = new ExerciseResource();
        $exerciseResource->setId($exercise->getId());
        $exerciseResource->setExerciseModel($exercise->getExerciseModel()->getId());
        $exerciseResource->setType($exercise->getExerciseModel()->getType());
        $exerciseResource->setTitle($exercise->getExerciseModel()->getTitle());

        $serializer = SerializerBuilder::create()
            ->addDefaultHandlers()
            ->configureHandlers(
                function (HandlerRegistry $registry) {
                    $registry->registerSubscribingHandler(
                        new AbstractClassForExerciseHandler()
                    );
                }
            )
            ->build();
        $content = $serializer->deserialize(
            $exercise->getContent(),
            ExerciseResource::getClass($exercise->getExerciseModel()->getType()),
            'json'
        );

        $exerciseResource->setContent($content);

        if ($links) {
            $attempts = array();
            foreach ($exercise->getAttempts() as $attempt) {
                $attempts[] = AttemptResourceFactory::create($attempt, true);
            }
            $exerciseResource->setAttempts($attempts);
        }

        return $exerciseResource;
    }
}
