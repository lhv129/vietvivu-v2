<?php

namespace App\Services;

use App\Helpers\ImageHelper;
use App\Repositories\MediaRepository;
use Illuminate\Support\Facades\Storage;

class MediaService extends BaseService
{
    protected string $notFoundMessage = "Phương tiện này không tồn tại hoặc đã bị xóa.";

    public function __construct(MediaRepository $repository)
    {
        parent::__construct($repository);
    }

    public function getByMediable(string $type, int $id)
    {
        return $this->repository->getByMediable($type, $id);
    }

    public function deleteByMediable(string $type, int $id)
    {
        return $this->repository->deleteByMediable($type, $id);
    }

    /**
     * Move folder khi slug thay đổi
     */
    public function moveFolder($mediableType, $mediableId, $oldSlug, $newSlug)
    {
        $oldFolder = "uploads/{$mediableType}s/$oldSlug";
        $newFolder = "uploads/{$mediableType}s/$newSlug";

        if (!Storage::disk('public')->exists($oldFolder)) {
            return;
        }

        Storage::disk('public')->makeDirectory($newFolder);

        $files = Storage::disk('public')->files($oldFolder);

        foreach ($files as $file) {

            $filename = basename($file);

            Storage::disk('public')->move(
                $file,
                "$newFolder/$filename"
            );
        }

        Storage::disk('public')->deleteDirectory($oldFolder);

        /**
         * update DB path
         */
        $medias = $this->repository->getByMediable($mediableType, $mediableId);

        foreach ($medias as $media) {

            $newPath = str_replace(
                "/storage/uploads/{$mediableType}s/$oldSlug",
                "/storage/uploads/{$mediableType}s/$newSlug",
                $media->path
            );

            $this->repository->update($media, [
                'path' => $newPath
            ]);
        }
    }

    /**
     * Sync media (delete old + upload new)
     */
    public function syncMedia($mediableType, $mediableId, $files)
    {
        $folder = "{$mediableType}s/$mediableId";

        $oldMedia = $this->repository
            ->getByMediable($mediableType, $mediableId)
            ->sortBy('sort_order')
            ->values();

        $oldCount = $oldMedia->count();
        $newCount = count($files);

        foreach ($files as $index => $file) {

            $path = ImageHelper::uploadSingle($file, $folder);

            if (isset($oldMedia[$index])) {

                ImageHelper::delete($oldMedia[$index]->path);

                $this->repository->update($oldMedia[$index], [
                    'path' => $path,
                    'sort_order' => $index
                ]);
            } else {

                $this->repository->create([
                    'mediable_type' => $mediableType,
                    'mediable_id' => $mediableId,
                    'path' => $path,
                    'type' => 'image',
                    'sort_order' => $index,
                    'is_active' => 1
                ]);
            }
        }

        /**
         * delete dư
         */
        if ($oldCount > $newCount) {

            $deleteMedia = $oldMedia->slice($newCount);

            foreach ($deleteMedia as $media) {

                ImageHelper::delete($media->path);

                $this->repository->forceDelete($media);
            }
        }
    }
}
