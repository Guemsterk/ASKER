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

namespace AskerBundle\Model\Resources\ExerciseResource\Sequence;

use JMS\Serializer\Annotation as Serializer;
use AskerBundle\Model\Resources\Validable;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class SequenceElement
 *
 * @author Baptiste Cablé <baptiste.cable@liris.cnrs.fr>
 * @Serializer\Discriminator(field = "object_type", map = {
 *    "block": "AskerBundle\Model\Resources\ExerciseResource\Sequence\SequenceBlock",
 *    "resource_id": "AskerBundle\Model\Resources\ExerciseResource\Sequence\ResourceId",
 *    "text": "AskerBundle\Model\Resources\ExerciseResource\Sequence\Text",
 *    "text_fragment": "AskerBundle\Model\Resources\ExerciseResource\Sequence\TextFragment"
 * })
 */
abstract class SequenceElement implements Validable
{
    /**
     * @const BLOCK_CLASS = 'AskerBundle\Model\Resources\ExerciseResource\Sequence\SequenceBlock'
     */
    const BLOCK_CLASS = 'AskerBundle\Model\Resources\ExerciseResource\Sequence\SequenceBlock';

    /**
     * @const RESOURCE_ID_CLASS = 'AskerBundle\Model\Resources\ExerciseResource\Sequence\ResourceId'
     */
    const RESOURCE_ID_CLASS = 'AskerBundle\Model\Resources\ExerciseResource\Sequence\ResourceId';

    /**
     * @const TEXT_CLASS = 'AskerBundle\Model\Resources\ExerciseResource\Sequence\Text'
     */
    const TEXT_CLASS = 'AskerBundle\Model\Resources\ExerciseResource\Sequence\Text';

    /**
     * @const TEXT_FRAGMENT_CLASS = 'AskerBundle\Model\Resources\ExerciseResource\Sequence\TextFragment'
     */
    const TEXT_FRAGMENT_CLASS = 'AskerBundle\Model\Resources\ExerciseResource\Sequence\TextFragment';
}
