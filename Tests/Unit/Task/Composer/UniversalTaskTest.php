<?php
namespace TYPO3\Surf\Tests\Unit\Task\Composer;

/*
 * This file is part of TYPO3 Surf.
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

use TYPO3\Surf\Task\Composer\UniversalTask;
use TYPO3\Surf\Tests\Unit\Task\BaseTaskTest;

/**
 * Unit test for the TagTask
 */
class UniversalTaskTest extends BaseTaskTest
{
    /**
     * Set up test dependencies
     */
    protected function setUp()
    {
        parent::setUp();

        $this->application->setDeploymentPath('/home/jdoe/app');
    }

    /**
     * @test
     */
    public function executeUserConfiguredComposerCommand()
    {
        $options = [
            'composerCommandPath' => '/my/path/to/composer.phar',
            'command' => 'run-script',
            'additionalArguments' => 'my-script'
        ];

        $this->task->execute($this->node, $this->application, $this->deployment, $options);
        $this->assertCommandExecuted('/^\/my\/path\/to\/composer.phar \'run-script\' --no-ansi --no-interaction \'my-script\' 2>&1$/');
    }

    /**
     * @test
     */
    public function executeUserConfiguredComposerUpdateCommand()
    {
        $options = [
            'composerCommandPath' => 'composer',
            'command' => 'update',
            'arguments' => [
                '--no-ansi',
                '--no-interaction',
                '--no-dev',
                '--no-progress',
                '--classmap-authoritative'
            ]
        ];

        $this->task->execute($this->node, $this->application, $this->deployment, $options);
        $this->assertCommandExecuted('/^composer \'update\' \'--no-ansi\' \'--no-interaction\' \'--no-dev\' \'--no-progress\' \'--classmap-authoritative\' 2>&1$/');
    }

    /**
     * @return \TYPO3\Surf\Domain\Model\Task
     */
    protected function createTask()
    {
        return new UniversalTask();
    }
}
