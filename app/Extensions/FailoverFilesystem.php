<?php

namespace App\Extensions;

use Illuminate\Contracts\Filesystem\Cloud as CloudFilesystem;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Log;

class FailoverFilesystem implements CloudFilesystem
{
    protected $primary;
    protected $fallback;

    public function __construct(Filesystem $primary, Filesystem $fallback)
    {
        $this->primary = $primary;
        $this->fallback = $fallback;
    }

    // ── Cloud interface ──

    public function url($path)
    {
        try {
            // Only return primary URL if the file actually exists there
            if ($this->primary->exists($path)) {
                return $this->primary->url($path);
            }
        } catch (\Exception $e) {
            // Fallback to secondary if primary check fails
        }
        
        return $this->fallback->url($path);
    }

    // ── Filesystem interface – every method listed in the contract ──

    public function path($path)
    {
        return $this->primary->path($path);
    }

    public function exists($path)
    {
        try {
            return $this->primary->exists($path) || $this->fallback->exists($path);
        } catch (\Exception $e) {
            return $this->fallback->exists($path);
        }
    }

    public function get($path)
    {
        try {
            return $this->primary->get($path);
        } catch (\Exception $e) {
            return $this->fallback->get($path);
        }
    }

    public function readStream($path)
    {
        try {
            return $this->primary->readStream($path);
        } catch (\Exception $e) {
            return $this->fallback->readStream($path);
        }
    }

    public function put($path, $contents, $options = [])
    {
        try {
            return $this->primary->put($path, $contents, $options);
        } catch (\Exception $e) {
            Log::warning("Storage Failover: put() failed on primary. Error: " . $e->getMessage());
            return $this->fallback->put($path, $contents, $options);
        }
    }

    public function putFile($path, $file = null, $options = [])
    {
        try {
            return $this->primary->putFile($path, $file, $options);
        } catch (\Exception $e) {
            Log::warning("Storage Failover: putFile() failed on primary. Error: " . $e->getMessage());
            return $this->fallback->putFile($path, $file, $options);
        }
    }

    public function putFileAs($path, $file, $name = null, $options = [])
    {
        try {
            return $this->primary->putFileAs($path, $file, $name, $options);
        } catch (\Exception $e) {
            Log::warning("Storage Failover: putFileAs() failed on primary. Error: " . $e->getMessage());
            return $this->fallback->putFileAs($path, $file, $name, $options);
        }
    }

    public function writeStream($path, $resource, array $options = [])
    {
        try {
            return $this->primary->writeStream($path, $resource, $options);
        } catch (\Exception $e) {
            Log::warning("Storage Failover: writeStream() failed on primary. Error: " . $e->getMessage());
            return $this->fallback->writeStream($path, $resource, $options);
        }
    }

    public function getVisibility($path)
    {
        try {
            return $this->primary->getVisibility($path);
        } catch (\Exception $e) {
            return $this->fallback->getVisibility($path);
        }
    }

    public function setVisibility($path, $visibility)
    {
        try {
            $this->primary->setVisibility($path, $visibility);
        } catch (\Exception $e) {
            // ignore
        }
        return $this->fallback->setVisibility($path, $visibility);
    }

    public function prepend($path, $data)
    {
        try {
            return $this->primary->prepend($path, $data);
        } catch (\Exception $e) {
            return $this->fallback->prepend($path, $data);
        }
    }

    public function append($path, $data)
    {
        try {
            return $this->primary->append($path, $data);
        } catch (\Exception $e) {
            return $this->fallback->append($path, $data);
        }
    }

    public function delete($paths)
    {
        try { $this->primary->delete($paths); } catch (\Exception $e) {}
        try { $this->fallback->delete($paths); } catch (\Exception $e) {}
        return true;
    }

    public function copy($from, $to)
    {
        try {
            return $this->primary->copy($from, $to);
        } catch (\Exception $e) {
            return $this->fallback->copy($from, $to);
        }
    }

    public function move($from, $to)
    {
        try {
            return $this->primary->move($from, $to);
        } catch (\Exception $e) {
            return $this->fallback->move($from, $to);
        }
    }

    public function size($path)
    {
        try {
            return $this->primary->size($path);
        } catch (\Exception $e) {
            return $this->fallback->size($path);
        }
    }

    public function lastModified($path)
    {
        try {
            return $this->primary->lastModified($path);
        } catch (\Exception $e) {
            return $this->fallback->lastModified($path);
        }
    }

    public function mimeType($path)
    {
        try {
            return $this->primary->mimeType($path);
        } catch (\Exception $e) {
            return $this->fallback->mimeType($path);
        }
    }

    public function checksum($path, array $options = [])
    {
        try {
            return $this->primary->checksum($path, $options);
        } catch (\Exception $e) {
            return $this->fallback->checksum($path, $options);
        }
    }

    public function files($directory = null, $recursive = false)
    {
        try {
            return $this->primary->files($directory, $recursive);
        } catch (\Exception $e) {
            return $this->fallback->files($directory, $recursive);
        }
    }

    public function allFiles($directory = null)
    {
        try {
            return $this->primary->allFiles($directory);
        } catch (\Exception $e) {
            return $this->fallback->allFiles($directory);
        }
    }

    public function directories($directory = null, $recursive = false)
    {
        try {
            return $this->primary->directories($directory, $recursive);
        } catch (\Exception $e) {
            return $this->fallback->directories($directory, $recursive);
        }
    }

    public function allDirectories($directory = null)
    {
        try {
            return $this->primary->allDirectories($directory);
        } catch (\Exception $e) {
            return $this->fallback->allDirectories($directory);
        }
    }

    public function makeDirectory($path)
    {
        try {
            return $this->primary->makeDirectory($path);
        } catch (\Exception $e) {
            return $this->fallback->makeDirectory($path);
        }
    }

    public function deleteDirectory($directory)
    {
        try {
            return $this->primary->deleteDirectory($directory);
        } catch (\Exception $e) {
            return $this->fallback->deleteDirectory($directory);
        }
    }
}
