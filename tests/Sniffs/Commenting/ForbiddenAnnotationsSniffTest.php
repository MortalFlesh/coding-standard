<?php declare(strict_types = 1);

namespace SlevomatCodingStandard\Sniffs\Commenting;

class ForbiddenAnnotationsSniffTest extends \SlevomatCodingStandard\Sniffs\TestCase
{

	public function testNoForbiddenAnnotations(): void
	{
		$report = self::checkFile(__DIR__ . '/data/noForbiddenAnnotations.php', [
			'forbiddenAnnotations' => ['@see', '@throws'],
		]);
		self::assertNoSniffErrorInFile($report);
	}

	public function testForbiddenAnnotations(): void
	{
		$report = self::checkFile(__DIR__ . '/data/forbiddenAnnotations.php', [
			'forbiddenAnnotations' => ['@see', '@throws', '@Route'],
		]);

		self::assertSame(9, $report->getErrorCount());

		foreach ([5, 6, 20, 21, 30, 32, 45, 53, 66] as $line) {
			self::assertSniffError($report, $line, ForbiddenAnnotationsSniff::CODE_ANNOTATION_FORBIDDEN);
		}

		self::assertAllFixedInFile($report);
	}

}
