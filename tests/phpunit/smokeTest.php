<?php
use PHPUnit\Framework\TestCase;

class SmokeTest extends TestCase {

	private $curl_body;
	private $curl_error;

	public function fetch_url( $url ) {
		$ch = curl_init();

		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $ch, CURLOPT_HEADER, 0 );

		$this->curl_body = curl_exec( $ch );
		$this->curl_error = curl_error( $ch ) ?: null;

		curl_close( $ch );

		return $this->curl_body;
	}

	public function urls() {
		return array(
			['http://localhost:8888/'],
			['http://localhost:8888/download/'],
		);
	}

	/**
	 * @dataProvider urls
	 */
	public function testHasBodyTag( $url ): void
	{
		$this->fetch_url( $url );

		$this->assertStringContainsString( '<body', $this->curl_body );
		$this->assertStringContainsString( '</body>', $this->curl_body );
	}

	/**
	 * @dataProvider urls
	 */
	public function testClosingHtml( $url ): void
	{
		$this->fetch_url( $url );

		$this->assertStringEndsWith( '</html>', rtrim( $this->curl_body ) );
	}

	/**
	 * @dataProvider urls
	 */
	public function testHasTitle( $url ): void
	{
		$this->fetch_url( $url );

		$this->assertRegExp( '#<title>[^<>]+ WordPress.org</title>#', $this->curl_body );
	}

	/**
	 * @dataProvider urls
	 */
	public function testHasMetaDescription( $url ): void
	{
		$this->fetch_url( $url );

		$this->assertRegExp( '#<meta name="description" content="[^"<>]+" />#', $this->curl_body );
		$this->assertRegExp( '#<meta property="og:description" content="[^"<>]+" />#', $this->curl_body );
	}

	/**
	 * @dataProvider urls
	 */
	public function testHasHrefLang( $url ): void
	{
		$this->markTestSkipped( 'Requires https://github.com/WordPress/wporg-main-2022/pull/54' );
		$this->fetch_url( $url );

		$this->assertRegExp( '#<link rel="alternate" hreflang="\w\w-\w\w" />#', $this->curl_body );
	}

}
