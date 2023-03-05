<?php

namespace Payavel;

class PaymentStatus
{
    const AUTHORIZED = 200;
    const APPROVED = 201;
    const CAPTURED = 202;
    const PARTIALLY_CAPTURED = 203;
    const SETTLED = 204;
    const CANCELED = 210;
    const VOIDED = 211;
    const REFUNDED = 212;
    const PARTIALLY_REFUNDED = 213;
    const REFUND_SETTLED = 214;
    const REFUND_FAILED = 215;
    const REFUND_REVERSED = 216;
    const PENDING = 300;
    const PROCESSING_ASYNC = 301;
    const REFUSED = 400;
    const DECLINED = 401;
    const REFERRED = 402;
    const NOT_ENOUGH_BALANCE = 403;
    const INVALID_CARD = 410;
    const INVALID_CARD_HOLDER_NAME = 411;
    const INVALID_CARD_NUMBER = 412;
    const INVALID_CARD_EXPIRY = 413;
    const INVALID_CARD_SECURITY_CODE = 414;
    const BLOCKED_CARD = 415;
    const RESTRICTED_CARD = 416;
    const INVALID_ADDRESS = 460;
    const INVALID_BILLING_ADDRESS = 461;
    const INVALID_SHIPPING_ADDRESS = 462;
    const FRAUD = 470;
    const FAILED_FRAUD_CHECK = 471;
    const ACQUIRER_SUSPECTED_FRAUD = 472;
    const ISSUER_SUSPECTED_FRAUD = 473;
    const AVS_DECLINED = 474;
    const INVALID_TRANSACTION = 480;
    const INVALID_CREDENTIALS = 481;
    const INVALID_AMOUNT = 482;
    const TRANSACTION_NOT_SUPPORTED = 483;
    const TRANSACTION_NOT_PERMITTED = 484;
    const DUPLICATE_TRANSACTION = 485;
    const PROCESSING_ISSUE = 490;
    const AUTHORIZATION_REVOKED = 491;
    const ACQUIRER_UNREACHABLE = 492;
    const ISSUER_UNREACHABLE = 493;
    const ERROR = 500;
    const ACQUIRER_ERROR = 501;
    const ISSUER_ERROR = 502;
    const UNKNOWN_ERROR = 503;

    /**
     * List of all supported payment response codes.
     *
     * @var array
     */
    public static $codes = [
        self::AUTHORIZED => 'Authorized',
        self::APPROVED => 'Approved',
        self::CAPTURED => 'Captured',
        self::PARTIALLY_CAPTURED => 'Partially captured',
        self::SETTLED => 'Settled',
        self::CANCELED => 'Requested cancelation',
        self::VOIDED => 'Voided',
        self::REFUNDED => 'Refunded',
        self::PARTIALLY_REFUNDED => 'Partially refunded',
        self::REFUND_SETTLED => 'Refund settled',
        self::REFUND_FAILED => 'Refund failed',
        self::REFUND_REVERSED => 'Refund reversed',
        self::PENDING => 'Pending',
        self::PROCESSING_ASYNC => 'Processing asynchronously',
        self::REFUSED => 'Refused',
        self::DECLINED => 'Declined',
        self::REFERRED => 'Referred',
        self::NOT_ENOUGH_BALANCE => 'Not enough balance',
        self::INVALID_CARD => 'Invalid card',
        self::INVALID_CARD_HOLDER_NAME => 'Invalid cardholder name',
        self::INVALID_CARD_NUMBER => 'Invalid card number',
        self::INVALID_CARD_EXPIRY => 'Invalid card expiration date',
        self::INVALID_CARD_SECURITY_CODE => 'Invalid security code',
        self::BLOCKED_CARD => 'Card blocked',
        self::RESTRICTED_CARD => 'Card restricted',
        self::INVALID_ADDRESS => 'Invalid address information',
        self::INVALID_BILLING_ADDRESS => 'Invalid billing address information',
        self::INVALID_SHIPPING_ADDRESS => 'Invalid shipping address information',
        self::FRAUD => 'Fraud',
        self::FAILED_FRAUD_CHECK => 'Fraud check failed',
        self::ACQUIRER_SUSPECTED_FRAUD => 'Acquirer suspected fraud',
        self::ISSUER_SUSPECTED_FRAUD => 'Issuer suspected fraud',
        self::AVS_DECLINED => 'Address verification system declined',
        self::INVALID_TRANSACTION => 'Invalid transaction',
        self::INVALID_CREDENTIALS => 'Invalid credentials',
        self::INVALID_AMOUNT => 'Invalid amount',
        self::TRANSACTION_NOT_SUPPORTED => 'Transaction not supported',
        self::TRANSACTION_NOT_PERMITTED => 'Transaction not permitted',
        self::DUPLICATE_TRANSACTION => 'Duplicate transaction',
        self::PROCESSING_ISSUE => 'Processing issue',
        self::AUTHORIZATION_REVOKED => 'Authorization revoked',
        self::ACQUIRER_UNREACHABLE => 'Acquirer unreachable',
        self::ISSUER_UNREACHABLE => 'Issuer unreachable',
        self::ERROR => 'Error',
        self::ACQUIRER_ERROR => 'Acquirer Error',
        self::ISSUER_ERROR => 'Issuer Error',
        self::UNKNOWN_ERROR => 'Unknown Error',
    ];

    /**
     * List of all supported payment response code messages.
     *
     * @var array
     */
    public static $messages = [
        self::AUTHORIZED => 'The transaction was authorized.',
        self::APPROVED => 'The authorization was approved.',
        self::CAPTURED => 'The transaction is being captured.',
        self::PARTIALLY_CAPTURED => 'The transaction was partially captured.',
        self::SETTLED => 'The transaction was settled.',
        self::CANCELED => 'The transaction is being canceled.',
        self::VOIDED => 'The transaction has been voided.',
        self::REFUNDED => 'The transaction is being refunded.',
        self::PARTIALLY_REFUNDED => 'The transaction is being partially refunded.',
        self::REFUND_SETTLED => 'The refund was settled.',
        self::REFUND_FAILED => 'The refund failed to be processed.',
        self::REFUND_REVERSED => 'The refund was reversed and settled.',
        self::PENDING => 'The transaction is pending.',
        self::PROCESSING_ASYNC => 'The transaction is being completed asynchronously.',
        self::REFUSED => 'The transaction was refused.',
        self::DECLINED => 'The transaction was declined.',
        self::REFERRED => 'The transaction must be authorized by the the cardholder.',
        self::NOT_ENOUGH_BALANCE => 'Not enough balance/funds for the transaction to be processed.',
        self::INVALID_CARD => 'The card is not valid.',
        self::INVALID_CARD_HOLDER_NAME => 'The cardholder name is not valid.',
        self::INVALID_CARD_NUMBER => 'The card number is not valid.',
        self::INVALID_CARD_EXPIRY => 'The card expiration date is not valid.',
        self::INVALID_CARD_SECURITY_CODE => 'The security code is not valid.',
        self::BLOCKED_CARD => 'The card is blocked.',
        self::RESTRICTED_CARD => 'The card is restricted',
        self::INVALID_ADDRESS => 'The address information is not valid.',
        self::INVALID_BILLING_ADDRESS => 'The billing address information is not valid.',
        self::INVALID_SHIPPING_ADDRESS => 'The billing shipping information is not valid.',
        self::FRAUD => 'The transaction was marked fraudulent.',
        self::FAILED_FRAUD_CHECK => 'The fraud check failed before attempting to process.',
        self::ACQUIRER_SUSPECTED_FRAUD => 'The transaction was marked fraudulent by the acquirer.',
        self::ISSUER_SUSPECTED_FRAUD => 'The transaction was marked fraudulent by the issuer.',
        self::AVS_DECLINED => 'The transaction was declined by the address verification system (AVS).',
        self::INVALID_TRANSACTION => 'The transaction is not valid.',
        self::INVALID_CREDENTIALS => 'The transaction is not authorized.',
        self::INVALID_AMOUNT => 'The amount provided is not valid.',
        self::TRANSACTION_NOT_SUPPORTED => 'The transaction is not supported.',
        self::TRANSACTION_NOT_PERMITTED => 'The transaction is not permitted.',
        self::DUPLICATE_TRANSACTION => 'The transaction has already been processed.',
        self::PROCESSING_ISSUE => 'There was a processing issue.',
        self::AUTHORIZATION_REVOKED => 'The authorization for the transaction was revoked.',
        self::ACQUIRER_UNREACHABLE => 'The issuer is not reachable.',
        self::ISSUER_UNREACHABLE => 'The issuer is not reachable.',
        self::ERROR => 'An unexpected error occurred.',
        self::ACQUIRER_ERROR => 'There was an error while the acquirer was attempting to process the transaction.',
        self::ISSUER_ERROR => 'There was an error while the issuer was attempting to process the transaction.',
        self::UNKNOWN_ERROR => 'An unknown error occurred.',
    ];

    /**
     * Get the definition of the provided code.
     *
     * @param int $status
     * @return string|null
     */
    public static function get($status)
    {
        return self::$codes[$status] ?? null;
    }

    /**
     * Get the description of the provided code.
     *
     * @param int $status
     * @return string|null
     */
    public static function getMessage($status)
    {
        return self::$messages[$status] ?? null;
    }
}
