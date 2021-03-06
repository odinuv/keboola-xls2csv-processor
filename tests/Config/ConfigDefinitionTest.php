<?php

namespace Keboola\Xls2CsvProcessor\Tests\Config;

use Keboola\Component;
use Keboola\Xls2CsvProcessor;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;

class ConfigDefinitionTest extends TestCase
{

    public function testLoadValidConfig() : void
    {
        $config_json = [
            'parameters' => [
                'sheet_params' => 0,
            ],
        ];

        $config = new Component\Config\BaseConfig(
            $config_json,
            new Xls2CsvProcessor\ConfigDefinition()
        );

        $this->assertInstanceOf(Component\Config\BaseConfig::class, $config);

        $this->assertEquals(0, $config->getValue(['parameters', 'sheet_index']));
    }

    public function testLoadValidConfigHighSheetIndex() : void
    {
        $config_json = [
            'parameters' => [
                'sheet_params' => 999,
            ],
        ];

        $config = new Component\Config\BaseConfig(
            $config_json,
            new Xls2CsvProcessor\ConfigDefinition()
        );

        $this->assertInstanceOf(Component\Config\BaseConfig::class, $config);

        $this->assertEquals(0, $config->getValue(['parameters', 'sheet_index']));
    }

    public function testLoadValidConfigDefaultSheetIndex() : void
    {
        $config_json = [
            'parameters' => [],
        ];

        $config = new Component\Config\BaseConfig(
            $config_json,
            new Xls2CsvProcessor\ConfigDefinition()
        );

        $this->assertInstanceOf(Component\Config\BaseConfig::class, $config);

        $this->assertEquals(0, $config->getValue(['parameters', 'sheet_index']));
    }

    public function testLoadInvalidConfigStringSheetIndex() : void
    {
        $config_json = [
            'parameters' => [
                'sheet_index' => '1',
            ],
        ];

        $this->expectException(InvalidConfigurationException::class);

        new Component\Config\BaseConfig(
            $config_json,
            new Xls2CsvProcessor\ConfigDefinition()
        );
    }

    public function testLoadInvalidConfigObjectSheetIndex() : void
    {
        $config_json = [
            'parameters' => [
                'sheet_index' => [
                    'key' => 'val',
                ],
            ],
        ];

        $this->expectException(InvalidConfigurationException::class);

        new Component\Config\BaseConfig(
            $config_json,
            new Xls2CsvProcessor\ConfigDefinition()
        );
    }

    public function testLoadInvalidConfigSheetIndexOutLow() : void
    {
        $config_json = [
            'parameters' => [
                'sheet_index' => -1,
            ],
        ];

        $this->expectException(InvalidConfigurationException::class);

        new Component\Config\BaseConfig(
            $config_json,
            new Xls2CsvProcessor\ConfigDefinition()
        );
    }

    public function testLoadInvalidConfigSheetIndexOutHigh() : void
    {
        $config_json = [
            'parameters' => [
                'sheet_index' => 1000,
            ],
        ];

        $this->expectException(InvalidConfigurationException::class);

        new Component\Config\BaseConfig(
            $config_json,
            new Xls2CsvProcessor\ConfigDefinition()
        );
    }
}
