<?php

declare(strict_types=1);

/*
 * CoreShop
 *
 * This source file is available under two different licenses:
 *  - GNU General Public License version 3 (GPLv3)
 *  - CoreShop Commercial License (CCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @copyright  Copyright (c) CoreShop GmbH (https://www.coreshop.org)
 * @license    https://www.coreshop.org/license     GPLv3 and CCL
 *
 */

namespace CoreShop\Component\Rule\Condition;

use CoreShop\Component\Resource\Model\ResourceInterface;
use CoreShop\Component\Rule\Model\ConditionInterface;
use CoreShop\Component\Rule\Model\RuleInterface;

interface RuleConditionsValidationProcessorInterface
{
    public function getType(): string;

    public function isValid(ResourceInterface $subject, RuleInterface $rule, $conditions, array $params = []): bool;

    public function isConditionValid(ResourceInterface $subject, RuleInterface $rule, ConditionInterface $condition, array $params = []): bool;
}
