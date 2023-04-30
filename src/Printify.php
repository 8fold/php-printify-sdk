<?php
declare(strict_types=1);

namespace Eightfold\Printify;

class Printify
{
    private const API_VERSION = 'https://api.printify.com/v1';

    /**
     * @var array<string, string>
     */
    private array $mergedConfig;

    public static function account(string $accessToken): self
    {
        return new self($accessToken);
    }

    final private function __construct(private string $accessToken)
    {
    }

    public function apiVersion(): string
    {
        $config = $this->config();
        return $config['api_version'];
    }

    public function accessToken(): string
    {
        $config = $this->config();
        return $config['access_token'];
    }

    /**
     * @return array<string, string>
     */
    private function config(): array
    {
        if (isset($this->mergedConfig) === false) {
            $dc = $this->defaultConfig();
            $dc['access_token'] = $this->accessToken;

            $this->mergedConfig = $dc;
        }
        return $this->mergedConfig;
    }

    /**
     * @return array<string, string>
     */
    private function defaultConfig(): array
    {
        return [
            'api_version'  => self::API_VERSION,
            'access_token' => ''
        ];
    }
}
