<?php

namespace MarcReichel\ExposedPassword;

use GuzzleHttp\Client;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Filesystem\Cache;
use Illuminate\Support\Collection;

class NotExposed implements Rule
{
    /**
     * @var \GuzzleHttp\Client $client
     */
    protected $client;

    /**
     * Create a new rule instance.
     */
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.pwnedpasswords.com/range/',
        ]);
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        list($prefix, $suffix) = preg_split('/(?<=.{5})/',
            strtolower(sha1($value)), 2);

        try {
            $request = $this->client
                ->get($prefix);
            $response = (string)$request->getBody();
        } catch (\Exception $e) {
            $response = '';
        }

        $suffixList = (new Collection(explode("\r\n", $response)))
            ->map(function ($item) {
                return strtolower(explode(':', $item)[0]);
            });

        return !$suffixList->contains($suffix);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute has been exposed in a data breach.';
    }
}
