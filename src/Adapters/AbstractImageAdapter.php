<?php

namespace Platina\Image\Adapters;

use Platina\Image\Contracts\ImageAdapterInterface;
use Platina\Image\Contracts\ImageInterface;

abstract class AbstractImageAdapter implements ImageAdapterInterface
{
    /**
     * Создает объект изображения на основе полученных данных.
     *
     * @return ImageInterface Объект изображения.
     */
    abstract public function createImageFromData(): ImageInterface;

    /**
     * Преобразует изображение в поддерживаемый формат.
     *
     * @param ImageInterface $image Объект изображения для преобразования.
     *
     * @return ImageInterface Преобразованное изображение.
     */
    protected function convertToFormat(ImageInterface $image): ImageInterface
    {
        // Получение расширения файла и преобразование его в нижний регистр
        $fileExtension = strtolower($image->getExtension());
        // Получение массива форматов из конфигурации и приведение их к нижнему регистру
        $no_formats = array_map('strtolower', config('image.no_formats'));
        // Проверка, присутствует ли расширение файла в массиве не поддерживаемых форматов
        if (in_array($fileExtension, $no_formats)) {
            // Если формат файла не поддерживается, преобразовываем его в формат JPEG
            $image->encode('jpg');
        }

        return $image;
    }

}
