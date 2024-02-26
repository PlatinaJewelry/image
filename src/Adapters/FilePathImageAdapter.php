<?php

namespace Platina\Image\Adapters;

use Imagick;
use ImagickException;
use ImagickPixel;
use Platina\Image\Contracts\ImageInterface;
use Platina\Image\Exception\NotReadableException;
use Platina\Image\Image;

/**
 * Адаптер для создания объекта изображения на основе локального файла
 *
 * Class FilePathImageAdapter
 */
class FilePathImageAdapter extends AbstractImageAdapter
{
    protected string $filePath;

    /**
     * Конструктор класса.
     *
     * @param string $filePath Путь к локальному файлу.
     */
    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * Метод для создания объекта изображения на основе локального файла
     *
     * @return ImageInterface Объект изображения
     *
     * @throws NotReadableException Выбрасывает исключение, если изображение не может быть прочитано
     */
    public function createImageFromData(): ImageInterface
    {
        $image = new Image();

        try {
            // Создание объекта Imagick для работы с изображением
            $imagick = new Imagick();

            // Устанавливаем фон изображения как прозрачный
            $imagick->setBackgroundColor(new ImagickPixel('transparent'));
            // Установка разрешения (DPI)
            $imagick->setResolution(600, 600);
            // Чтение изображения из локального файла
            $imagick->readImage($this->filePath);

            // Получить информацию о файле
            $fileInfo = pathinfo($this->filePath);

            // Установка MIME-типа изображения
            $image->setMime($imagick->getImageMimeType());
            // Установка базового имени файла в объект изображения
            $image->setBasename($fileInfo['basename']);
            // Установка директории, имени файла и базового имени файла в объект ImageFacade
            $image->setDirname($fileInfo['dirname']);
            // Установка имени файла с расширением в объект изображения
            $image->setFilename($fileInfo['filename']);
            // Установка расширения файла
            $image->setExtension($fileInfo['extension']);
            // Установка ресурса изображения Imagick в объект ImageFacade
            $image->setImageResource($imagick);

            return $this->convertToFormat($image);

        } catch (ImagickException $e) {
            // Обрабатываем исключения Imagick, если возникли проблемы при обработке изображения
            throw new NotReadableException("Ошибка обработки изображения: " . $e->getMessage());
        }
    }
}
