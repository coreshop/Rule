<?php
/**
 * CoreShop.
 *
 * This source file is subject to the GNU General Public License version 3 (GPLv3)
 * For the full copyright and license information, please view the LICENSE.md and gpl-3.0.txt
 * files that are distributed with this source code.
 *
 * @copyright  Copyright (c) 2015-2017 Dominik Pfaffenbauer (https://www.pfaffenbauer.at)
 * @license    https://www.coreshop.org/license     GNU General Public License version 3 (GPLv3)
 */

namespace CoreShop\Component\Rule\Condition;

use CoreShop\Component\Resource\Model\ResourceInterface;
use CoreShop\Component\Rule\Model\RuleInterface;

class NestedConditionChecker implements ConditionCheckerInterface
{
    /**
     * @var RuleConditionsValidationProcessorInterface
     */
    protected $ruleConditionsValidationProcessor;

    /**
     * @param RuleConditionsValidationProcessorInterface $ruleConditionsValidationProcessor
     */
    public function __construct(RuleConditionsValidationProcessorInterface $ruleConditionsValidationProcessor)
    {
        $this->ruleConditionsValidationProcessor = $ruleConditionsValidationProcessor;
    }

    /**
     * {@inheritdoc}
     */
    public function isValid(ResourceInterface $subject, RuleInterface $rule, array $configuration, $params = [])
    {
        $operator = $configuration['operator'];

        foreach ($configuration['conditions'] as $condition) {
            $valid = $this->ruleConditionsValidationProcessor->isValid($subject, $rule, [$condition], $params);

            if ('and' === $operator) {
                if (!$valid) {
                    return false;
                }
            } else if ('or' === $operator) {
                if ($valid) {
                    return true;
                }
            } else if ('not' === $operator) {
                if (!$valid) {
                    return true;
                }
            }
        }

        if ('not' === $operator) {
            return false;
        }

        return true;
    }
}
