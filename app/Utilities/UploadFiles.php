<?php

namespace App\Utilities;

use Carbon\Carbon;

class UploadFiles
{
    public function upload($file, $path)
    {
        $fileName = $file->getClientOriginalName();
        $newFileName = Carbon::now()->timestamp . '_' . $fileName;
        $file->move($path, $newFileName);
        return ltrim($path, '.') . "/" . $newFileName;
    }

    public function delete($path)
    {
        $routePath = base_path("public") . $path;
        if (file_exists($routePath)) {
            chmod($routePath, 0644);
            unlink($routePath);
        }
    }

    public function update($file, $path, $oldFileName)
    {
        $this->delete($oldFileName);
        $newFile = $this->upload($file, $path);
        return $newFile;
    }
}
