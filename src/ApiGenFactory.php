<?php declare(strict_types = 1);

namespace ApiGenX;

use ApiGenX\Renderer\LatteEngineFactory;
use ApiGenX\Renderer\LatteFunctions;
use ApiGenX\Renderer\SourceHighlighter;
use ApiGenX\Renderer\UrlGenerator;
use ApiGenX\TaskExecutor\LimitTaskExecutor;
use ApiGenX\TaskExecutor\PoolTaskExecutor;
use ApiGenX\TaskExecutor\WorkerTaskExecutor;
use League;
use React;
use React\EventLoop\LoopInterface;


final class ApiGenFactory
{
	public function create(LoopInterface $loop, string $sourceDir, string $baseDir, int $workerCount): ApiGen
	{
		$commonMarkEnv = League\CommonMark\Environment::createCommonMarkEnvironment();
		$commonMarkEnv->addExtension(new League\CommonMark\Extension\Autolink\AutolinkExtension());
		$commonMark = new League\CommonMark\CommonMarkConverter([], $commonMarkEnv);

		$urlGenerator = new UrlGenerator($baseDir);
		$sourceHighlighter = new SourceHighlighter();

		$latteFunctions = new LatteFunctions();
		$latteFactory = new LatteEngineFactory($latteFunctions, $urlGenerator, $commonMark, $sourceHighlighter);
		$latte = $latteFactory->create();

		$executor = new LimitTaskExecutor(PoolTaskExecutor::create($workerCount, fn() => new WorkerTaskExecutor($loop)), 80);
//		$executor = new SimpleTaskExecutor(new DefaultTaskEnvironment());

		$locator = new Locator($sourceDir);
		$analyzer = new Analyzer($locator, $loop, $executor);
		$indexer = new Indexer();
		$renderer = new Renderer($latte, $urlGenerator, $workerCount);

		return new ApiGen($analyzer, $indexer, $renderer);
	}
}