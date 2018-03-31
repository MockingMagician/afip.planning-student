<?php

namespace Afip\Planning\Components\Rendering;


class Converter
{
    private const CACHE_PATH = __DIR__.'/../../../../cache/converter';

    /** @var string */
    private $path;

    /** @var string */
    private $content;

    /*
   ____                    _                       _
  / ___| ___   _ __   ___ | |_  _ __  _   _   ___ | |_  ___   _ __  ___
 | |    / _ \ | '_ \ / __|| __|| '__|| | | | / __|| __|/ _ \ | '__|/ __|
 | |___| (_) || | | |\__ \| |_ | |   | |_| || (__ | |_| (_) || |   \__ \
  \____|\___/ |_| |_||___/ \__||_|    \__,_| \___| \__|\___/ |_|   |___/

     */

    public function __construct($path)
    {
        $this->path = \realpath($path);

        $this->content = file_get_contents($this->path);

        $splObject = new \SplFileObject($this->path);

        dump($splObject);
        dump($splObject->fstat());

        $dir = md5($splObject->getPathname());

        dump($dir);
    }

    /*
  __  __        _    _                 _
 |  \/  |  ___ | |_ | |__    ___    __| | ___
 | |\/| | / _ \| __|| '_ \  / _ \  / _` |/ __|
 | |  | ||  __/| |_ | | | || (_) || (_| |\__ \
 |_|  |_| \___| \__||_| |_| \___/  \__,_||___/

     */

    public function convert()
    {
        [$count, $converted] = $this->convertTags();

        return $converted;
    }

    private function convertTags()
    {
        $returned = \preg_replace_callback_array(
            [
                '/{% +if +([\S\s]+?) +%}/' => self::class.'::tagIf',
                '/({% +else +%})/'         => self::class.'::tagElse',
                '/({% +endif +%})/'        => self::class.'::tagEndIf',
                '/{{ +([\S]+?) +}}/'       => self::class.'::echo',
            ],
            $this->content,
            -1,
            $count
        );

        return [$count, $returned];
    }

    private static function tagIf(array $matches): string
    {
        return '<?php if('.$matches[1].') { ?>';
    }

    private static function tagElse(array $matches): string
    {
        return '<?php } else { ?>';
    }

    private static function tagEndIf(array $matches): string
    {
        return '<?php } ?>';
    }

    private static function echo(array $matches): string
    {
        $parsed = self::dotConversion($matches[1]);

        return '<?php echo htmlspecialchars($'.$matches[1].') ?>';
    }

    private static function dotConversion(string $dotNotationObject): string
    {
        return $dotNotationObject;
    }


}
