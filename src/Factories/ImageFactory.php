<?php

namespace Platina\Image\Factories;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\UploadedFile;
use Platina\Image\Adapters\FilePathImageAdapter;
use Platina\Image\Adapters\UploadedFileImageAdapter;
use Platina\Image\Adapters\UrlImageAdapter;
use Platina\Image\Contracts\ImageFactoryInterface;
use Platina\Image\Contracts\ImageInterface;
use Platina\Image\Exception\NotReadableException;

/**
 * Фабрика для создания экземпляра класса ImageFacade на основе предоставленных данных (файла, URL и т. д.)
 *
 * Class ImageFactory
 */
class ImageFactory implements ImageFactoryInterface
{
    /**
     * Создает экземпляр класса ImageFacade на основе предоставленных данных (файла, URL и т. д.)
     *
     * @param mixed $data Данные для создания изображения, такие как файл, URL и т. д
     *
     * @return ImageInterface Возвращает экземпляр класса ImageFacade
     *
     * @throws NotReadableException|FileNotFoundException Исключение, если изображение не может быть прочитано или
     *     обработано.
     */
    public static function createImage(mixed $data): ImageInterface
    {
        // Проверка, является ли переданный путь к файлу валидным
        if (is_string($data) && str_contains($data, "\\")) {
            throw new NotReadableException("Неверный формат пути к файлу.");
        }

        // Определяет адаптер на основе типа предоставленных данных, и создает объект ImageFacade.
        $adapterClass = match (true) {
            // Используется адаптер для загруженных файлов
            $data instanceof UploadedFile => new UploadedFileImageAdapter($data),
            // Используется адаптер для локальных файлов
            is_string($data) && is_file($data) => new FilePathImageAdapter($data),
            // Используется адаптер для URL
            is_string($data) && filter_var($data, FILTER_VALIDATE_URL) !== false => new UrlImageAdapter($data),
            // Выбрасываем исключение, если нельзя прочитать источник изображения
            default => throw new NotReadableException("Невозможно прочитать источник изображения"),
        };

        // Создает экземпляр ImageFacade и передает адаптер
        return $adapterClass->createImageFromData();
    }
}
