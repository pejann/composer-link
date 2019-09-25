<?php
namespace Pejann\ComposerLink;

class App
{
    protected $vendors = [];
    protected $vendorDir;
    protected $execution = true;

    public function __construct()
    {
        $currentDir = getcwd();
        $vendorsFile = $currentDir . DIRECTORY_SEPARATOR . '.linkrc.json';
        if (file_exists($vendorsFile)) {
            $this->vendors = json_decode(file_get_contents($vendorsFile), true);
        } else {
            $this->execution = false;
        }
        $this->vendorDir = getcwd() . DIRECTORY_SEPARATOR . 'vendor';
    }

    public function execute()
    {
        if (!$this->execution) {
            return;
        }

        foreach ($this->vendors as $vendor => $linkPath) {
            $vendorPath = $this->vendorDir . DIRECTORY_SEPARATOR . $vendor;
            $exists = file_exists($vendorPath);
            $isLink = is_link($vendorPath);

            if ($exists && !$isLink) {
                $this->removeFolderRecursivelly($vendorPath);

            } else if ($exists && $isLink) {
                unlink($vendorPath);
            }

            symlink($linkPath, $vendorPath);
        }
    }

    private function removeFolderRecursivelly($folder)
    {
        $iterator = new \RecursiveDirectoryIterator($folder, \RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new \RecursiveIteratorIterator($iterator, \RecursiveIteratorIterator::CHILD_FIRST);

        foreach ($files as $file) {
            if ($file->isDir()) {
                rmdir($file->getRealPath());
            } else {
                unlink($file->getRealPath());
            }
        }

        rmdir($folder);
    }


}