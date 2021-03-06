<?php
namespace TYPO3\CMS\Fluid\Tests\Unit\ViewHelpers\Form;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3\CMS\Fluid\ViewHelpers\Form\HiddenViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\TagBuilder;

/**
 * Test for the "Hidden" Form view helper
 */
class HiddenViewHelperTest extends \TYPO3\CMS\Fluid\Tests\Unit\ViewHelpers\Form\FormFieldViewHelperBaseTestcase
{
    /**
     * @var \TYPO3\CMS\Fluid\ViewHelpers\Form\HiddenViewHelper
     */
    protected $viewHelper;

    protected function setUp(): void
    {
        parent::setUp();
        $this->viewHelper = $this->getAccessibleMock(HiddenViewHelper::class, ['setErrorClassAttribute', 'getName', 'getValueAttribute', 'registerFieldNameForFormTokenGeneration']);
        $this->injectDependenciesIntoViewHelper($this->viewHelper);
    }

    /**
     * @test
     */
    public function renderCorrectlySetsTagNameAndDefaultAttributes()
    {
        $tagBuilder = $this->prophesize(TagBuilder::class);
        $tagBuilder->render()->shouldBeCalled();
        $tagBuilder->reset()->shouldBeCalled();
        $tagBuilder->addAttribute('type', 'hidden')->shouldBeCalled();
        $tagBuilder->addAttribute('name', 'foo')->shouldBeCalled();
        $tagBuilder->addAttribute('value', 'bar')->shouldBeCalled();
        $tagBuilder->setTagName('input')->shouldBeCalled();
        $this->viewHelper->expects(self::once())->method('registerFieldNameForFormTokenGeneration')->with('foo');

        $this->viewHelper->expects(self::once())->method('getName')->willReturn('foo');
        $this->viewHelper->expects(self::once())->method('getValueAttribute')->willReturn('bar');
        $this->viewHelper->setTagBuilder($tagBuilder->reveal());

        $this->viewHelper->initializeArgumentsAndRender();
    }
}
