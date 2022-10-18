<?php

namespace MangoPay;

/**
 * PayIn execution types
 */
class PayInExecutionType
{
    const Direct = 'DIRECT';
    const Web = 'WEB';
    const ExternalInstruction = 'EXTERNAL_INSTRUCTION';
    const Token = 'TOKEN';
    const Preauthorized = 'PREAUTHORIZED';
    const RecurringOrderExecution = 'RECURRING_ORDER_EXECUTION';
}
