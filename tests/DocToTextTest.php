<?php

namespace Jaybizzle\DocToText\Test;

use Jaybizzle\DocToText\Doc;
use Jaybizzle\DocToText\Exceptions\CouldNotExtractText;
use Jaybizzle\DocToText\Exceptions\DocNotFound;
use PHPUnit\Framework\TestCase;

class DocToTextTest extends TestCase
{
    protected $dummyDoc = __DIR__.'/testfiles/dummy.doc';
    protected $dummyDocText = 'This is a dummy DOC';

    /** @test */
    public function it_can_extract_text_from_a_doc()
    {
        $text = (new Doc())
            ->setDoc($this->dummyDoc)
            ->text();

        $this->assertSame($this->dummyDocText, $text);
    }

    /** @test */
    public function it_provides_a_static_method_to_extract_text()
    {
        $this->assertSame($this->dummyDocText, Doc::getText($this->dummyDoc));
    }

    /** @test */
    public function it_can_handle_paths_with_spaces()
    {
        $docPath = __DIR__.'/testfiles/dummy with spaces in its name.doc';

        $this->assertSame($this->dummyDocText, Doc::getText($docPath));
    }

    /** @test */
    public function it_can_handle_paths_with_single_quotes()
    {
        $docPath = __DIR__.'/testfiles/dummy\'s_file.doc';

        $this->assertSame($this->dummyDocText, Doc::getText($docPath));
    }

    /** @test */
    public function it_can_handle_doctotext_options_without_starting_hyphen()
    {
        $text = (new Doc())
            ->setDoc(__DIR__.'/testfiles/dummy.doc')
            ->setOptions(['f', 'i 80'])
            ->text();

        $this->assertContains($this->dummyDocText, $text);
    }

    /** @test */
    public function it_can_handle_doctotext_options_with_starting_hyphen()
    {
        $text = (new Doc())
            ->setDoc(__DIR__.'/testfiles/dummy.doc')
            ->setOptions(['-f', '-i 08'])
            ->text();

        $this->assertContains($this->dummyDocText, $text);
    }

    /** @test */
    public function it_can_handle_doctotext_options_with_mixed_hyphen_status()
    {
        $text = (new Doc())
            ->setDoc(__DIR__.'/testfiles/dummy.doc')
            ->setOptions(['-f', 'i 80'])
            ->text();

        $this->assertContains($this->dummyDocText, $text);
    }

    /** @test */
    public function it_will_throw_an_exception_when_the_doc_is_not_found()
    {
        $this->expectException(DocNotFound::class);

        (new Doc())
            ->setDoc('/no/doc/here/dummy.doc')
            ->text();
    }

    /** @test */
    public function it_will_throw_an_exception_when_the_binary_is_not_found()
    {
        $this->expectException(CouldNotExtractText::class);

        (new Doc('/there/is/no/place/like/home/doctotext'))
            ->setDoc($this->dummyDoc)
            ->text();
    }

    /** @test */
    public function it_will_throw_an_exception_when_the_option_is_unknown()
    {
        $this->expectException(CouldNotExtractText::class);
        Doc::getText($this->dummyDoc, null, ['-foo']);
    }
}
