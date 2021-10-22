<?php
/**
 * CoreShop.
 *
 * This source file is subject to the GNU General Public License version 3 (GPLv3)
 * For the full copyright and license information, please view the LICENSE.md and gpl-3.0.txt
 * files that are distributed with this source code.
 *
 * @copyright  Copyright (c) CoreShop GmbH (https://www.coreshop.org)
 * @license    https://www.coreshop.org/license     GNU General Public License version 3 (GPLv3)
 */

declare(strict_types=1);

namespace CoreShop\Component\Rule\Condition;

use CoreShop\Component\Resource\Model\ResourceInterface;
use CoreShop\Component\Rule\Model\RuleInterface;

class NestedConditionChecker implements ConditionCheckerInterface
{
    public function __construct(protected RuleConditionsValidationProcessorInterface $ruleConditionsValidationProcessor)
    {
    }

    public function isValid(ResourceInterface $subject, RuleInterface $rule, array $configuration, array $params = []): bool
    {
        $operator = $configuration['operator'];
        $valid = 'and' === $operator;

        foreach ($configuration['conditions'] as $condition) {
            $conditionValid = $this->ruleConditionsValidationProcessor->isValid($subject, $rule, [$condition], $params);

            switch ($operator) {
                case 'and':
                    if (!$conditionValid) {
                        $valid = false;

                        break 2;
                    }

                    break;
                case 'or':
                    if ($conditionValid) {
                        $valid = true;

                        break 2;
                    }

                    break;
            }
        }

        if ('not' === $operator) {
            return !$valid;
        }

        return $valid;
    }
}
