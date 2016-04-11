<?php namespace Mabasic\TranslateThis;

use Illuminate\Filesystem\Filesystem;

class TranslateThis {

    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $filesystem;

    /**
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * Exports localization files from source to destination.
     *
     * @param  string $source
     * @param  string $destination
     * @return boolean
     */
    public function export($source, $destination)
    {
        $files = $this->filesystem->allFiles($source);

        foreach($files as $file)
        {
            $array = include $file;

            // this is where I hold clean text from file
            $current = "";

            array_walk_recursive($array, function($item, $key) use (&$current) {
                // strip html and php tags from string
                $no_tags = strip_tags($item);
                // replace multiple blank spaces with a single blank space
                $no_extra_blank_space = preg_replace('/\s+/', ' ', $no_tags);
                // trim string left and right; add separator ~
                $current .= trim($no_extra_blank_space) ."\r\n~\r\n";
            });

            // $source about.php => $destination about.txt
            $new_file_name = $destination . '\\' . $file->getBasename('.php') . '.txt';

            // save file to destination
            file_put_contents($new_file_name, $current);
        }

        return true;
    }

}