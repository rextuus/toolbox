<?php
declare(strict_types=1);

namespace App\Stock\Content\Recommendation\Data;

use Symfony\Component\Form\DataTransformerInterface;

/**
 * @author Wolfgang Hinzmann <wolfgang.hinzmann@doccheck.com>
 * @license 2023 DocCheck Community GmbH
 */
class StringToDatetimeTransformer implements DataTransformerInterface
{
    public function transform($value): mixed
    {
        // Transform DateTime to string for rendering in the form
        if ($value === null) {
            return '';
        }

        return $value->format('d.m.Y');
    }

    public function reverseTransform($value): mixed
    {
        // Transform string to DateTime for processing in the application
        if ($value === null || $value === '') {
            return null;
        }

        return \DateTime::createFromFormat('d.m.Y', $value);
    }
}
