<?php

namespace Payavel;

use Payavel\Contracts\Merchantable;
use Payavel\Contracts\PaymentResponder;
use Payavel\Contracts\Providable;
use Payavel\Traits\PaymentResponses;
use Payavel\Traits\SimulateAttributes;
use RuntimeException;

abstract class PaymentResponse implements PaymentResponder
{
    use SimulateAttributes,
        PaymentResponses;

    /**
     * Statuses in this array are considered successful.
     *
     * @var array
     */
    protected $successStatuses = [
        PaymentStatus::AUTHORIZED,
        PaymentStatus::APPROVED,
        PaymentStatus::CAPTURED,
        PaymentStatus::PARTIALLY_CAPTURED,
        PaymentStatus::SETTLED,
        PaymentStatus::CANCELED,
        PaymentStatus::VOIDED,
        PaymentStatus::REFUNDED,
        PaymentStatus::PARTIALLY_REFUNDED,
        PaymentStatus::REFUND_SETTLED,
        PaymentStatus::REFUND_FAILED,
        PaymentStatus::REFUND_REVERSED,
        PaymentStatus::PENDING,
        PaymentStatus::PROCESSING_ASYNC,
    ];

    /**
     * Customize the response method names for your requests.
     *
     * @var array
     */
    protected $responseMethods = [];

    /**
     * The provider's raw response.
     *
     * @var mixed
     */
    protected $rawResponse;

    /**
     * Additional information needed to format the response.
     *
     * @var mixed
     */
    protected $additionalInformation;

    /**
     * The request method that returned this response.
     *
     * @var string
     */
    public $requestMethod;

    /**
     * The provider that the $request was made towards.
     *
     * @var \Payavel\Contracts\Providable
     */
    public $provider;

    /**
     * The merchant that was used to make the $request.
     *
     * @var \Payavel\Contracts\Merchantable
     */
    public $merchant;

    /**
     * The expected formatted data based on the $request.
     *
     * @var mixed
     */
    private $data;

    /**
     * @param mixed $rawResponse
     * @param mixed $additionalInformation
     */
    public function __construct($rawResponse, $additionalInformation = null)
    {
        $this->rawResponse = $rawResponse;
        $this->additionalInformation = $additionalInformation;
    }

    /**
     * Configure the response based on the request.
     *
     * @param string $requestMethod
     * @param \Payavel\Contracts\Providable $provider
     * @param \Payavel\Contracts\Merchantable $merchant
     * @return void
     */
    public function configure(string $requestMethod, Providable $provider, Merchantable $merchant)
    {
        $this->requestMethod = $requestMethod;
        $this->provider = $provider;
        $this->merchant = $merchant;
    }

    /**
     * Get the provider's raw response.
     *
     * @return mixed
     */
    public function getRawResponse()
    {
        return $this->rawResponse;
    }

    /**
     * Alias for the getRawResponse function.
     *
     * @return mixed
     */
    public function getRaw()
    {
        return $this->getRawResponse();
    }

    /**
     * Verify whether the request should be considered successful.
     *
     * @return bool
     */
    public function isSuccessful()
    {
        return in_array($this->getStatusCode(), $this->successStatuses);
    }

    /**
     * Verify whether the request should be considered a failure.
     *
     * @return bool
     */
    public function isNotSuccessful()
    {
        return ! $this->isSuccessful();
    }

    /**
     * Determines the status code based on the request's raw response.
     *
     * @return int
     */
    public abstract function getStatusCode();

    /**
     * Get a string representation of the response's status.
     *
     * @return string|null
     */
    public function getStatus()
    {
        return PaymentStatus::get($this->getStatusCode());
    }

    /**
     * Get a description of the response's status.
     *
     * @return string|null
     */
    public function getMessage()
    {
        return PaymentStatus::getMessage($this->getStatusCode());
    }

    /**
     * Get the formatted details based on the request that was made.
     *
     * @return array|mixed
     *
     * @throws \RuntimeException
     */
    public function getData()
    {
        if (! isset($this->data)) {
            $this->data = $this->{$this->getResponseMethod()}();
        }

        return $this->data;
    }

    /**
     * Get the response method that should be used to get the response's data.
     *
     * @return string
     */
    protected function getResponseMethod()
    {
        if (isset($this->requestMethod)) {
            if (
                array_key_exists($this->requestMethod, $this->responseMethods) &&
                method_exists($this, $method = $this->responseMethods[$this->requestMethod])
            ) {
                return $method;
            }

            if (method_exists($this, $method = "{$this->requestMethod}Response")) {
                return $method;
            }
        }

        return 'response';
    }
}
